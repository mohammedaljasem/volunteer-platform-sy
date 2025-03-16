<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class OrganizationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // عرض جميع المنظمات
        $organizations = Organization::withCount('users', 'jobOffers')
            ->latest()
            ->paginate(10);
            
        return view('organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // التحقق من صلاحية المستخدم لإنشاء منظمة
        // استخدام in_array للتحقق من الأدوار بدلاً من hasRole
        $userRoles = Auth::user()->roles->pluck('name')->toArray();
        if (!in_array('منظمة', $userRoles) && !in_array('فرقة تطوعية', $userRoles)) {
            return redirect()->route('organizations.index')
                ->with('error', 'ليس لديك صلاحية إنشاء منظمة جديدة. يرجى التواصل مع مدير النظام.');
        }
        
        return view('organizations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // التحقق من صلاحية المستخدم لإنشاء منظمة
        // استخدام in_array للتحقق من الأدوار بدلاً من hasRole
        $userRoles = Auth::user()->roles->pluck('name')->toArray();
        if (!in_array('منظمة', $userRoles) && !in_array('فرقة تطوعية', $userRoles)) {
            return redirect()->route('organizations.index')
                ->with('error', 'ليس لديك صلاحية إنشاء منظمة جديدة. يرجى التواصل مع مدير النظام.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:organizations',
            'description' => 'required|string',
            'contact_email' => 'required|email|max:255',
            'verification_docs' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);
        
        $organization = new Organization();
        $organization->name = $validated['name'];
        $organization->description = $validated['description'];
        $organization->contact_email = $validated['contact_email'];
        $organization->verified = false; // المنظمات الجديدة غير مُصدقة بشكل افتراضي
        
        // رفع وثائق التحقق إذا تم توفيرها
        if ($request->hasFile('verification_docs')) {
            $path = $request->file('verification_docs')->store('verification_docs', 'public');
            $organization->verification_docs = $path;
        }
        
        $organization->save();
        
        // إضافة المستخدم الحالي كمدير للمنظمة
        $organization->users()->attach(Auth::id(), ['role' => 'مدير']);
        
        return redirect()->route('organizations.show', $organization)
            ->with('success', 'تم إنشاء المنظمة بنجاح. سيتم مراجعتها للتحقق من صحة المعلومات.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization)
    {
        // جلب فرص التطوع الخاصة بالمنظمة
        $jobOffers = JobOffer::where('organization_id', $organization->id)
            ->latest()
            ->paginate(6);
        
        return view('organizations.show', compact('organization', 'jobOffers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization)
    {
        // التحقق من صلاحية المستخدم لتعديل المنظمة
        if (!$this->canManageOrganization($organization)) {
            return redirect()->route('organizations.show', $organization)
                ->with('error', 'ليس لديك صلاحية تعديل هذه المنظمة.');
        }
        
        return view('organizations.edit', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organization $organization)
    {
        // التحقق من صلاحية المستخدم لتعديل المنظمة
        if (!$this->canManageOrganization($organization)) {
            return redirect()->route('organizations.show', $organization)
                ->with('error', 'ليس لديك صلاحية تعديل هذه المنظمة.');
        }
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('organizations')->ignore($organization->id)],
            'description' => 'required|string',
            'contact_email' => 'required|email|max:255',
            'verification_docs' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);
        
        $organization->name = $validated['name'];
        $organization->description = $validated['description'];
        $organization->contact_email = $validated['contact_email'];
        
        // رفع وثائق التحقق الجديدة إذا تم توفيرها
        if ($request->hasFile('verification_docs')) {
            // حذف الملف القديم إذا وجد
            if ($organization->verification_docs) {
                Storage::disk('public')->delete($organization->verification_docs);
            }
            
            $path = $request->file('verification_docs')->store('verification_docs', 'public');
            $organization->verification_docs = $path;
            
            // إعادة تعيين حالة التحقق إذا تم تغيير الوثائق
            $organization->verified = false;
        }
        
        $organization->save();
        
        return redirect()->route('organizations.show', $organization)
            ->with('success', 'تم تحديث المنظمة بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        // التحقق من صلاحية المستخدم لحذف المنظمة (يجب أن يكون مديرًا)
        if (!$this->canManageOrganization($organization, true)) {
            return redirect()->route('organizations.show', $organization)
                ->with('error', 'ليس لديك صلاحية حذف هذه المنظمة.');
        }
        
        // حذف الملفات المرتبطة بالمنظمة
        if ($organization->verification_docs) {
            Storage::disk('public')->delete($organization->verification_docs);
        }
        
        // حذف المنظمة
        $organization->delete();
        
        return redirect()->route('organizations.index')
            ->with('success', 'تم حذف المنظمة بنجاح.');
    }
    
    /**
     * انضمام المستخدم الحالي إلى المنظمة
     */
    public function join(Organization $organization)
    {
        // التحقق من أن المستخدم ليس عضواً بالفعل
        $exists = DB::table('organization_user')
            ->where('user_id', Auth::id())
            ->where('organization_id', $organization->id)
            ->exists();
            
        if ($exists) {
            return redirect()->route('organizations.show', $organization)
                ->with('error', 'أنت بالفعل عضو في هذه المنظمة');
        }

        // إضافة المستخدم كعضو في المنظمة
        // استخدام العلاقة في النموذج بدلاً من الاستعلام المباشر
        $organization->users()->attach(Auth::id(), [
            'role' => 'عضو',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('organizations.show', $organization)
            ->with('success', 'تم الانضمام إلى المنظمة بنجاح');
    }

    /**
     * مغادرة المستخدم الحالي للمنظمة
     */
    public function leave(Organization $organization)
    {
        // التحقق من أن المستخدم عضو بالفعل
        $exists = DB::table('organization_user')
            ->where('user_id', Auth::id())
            ->where('organization_id', $organization->id)
            ->exists();
            
        if (!$exists) {
            return redirect()->route('organizations.show', $organization)
                ->with('error', 'أنت لست عضواً في هذه المنظمة');
        }

        // التحقق إذا كان المستخدم هو آخر مدير في المنظمة
        $managersCount = DB::table('organization_user')
            ->where('organization_id', $organization->id)
            ->where('role', 'مدير')
            ->count();
        
        $isManager = DB::table('organization_user')
            ->where('user_id', Auth::id())
            ->where('organization_id', $organization->id)
            ->where('role', 'مدير')
            ->exists();
            
        if ($managersCount <= 1 && $isManager) {
            return redirect()->route('organizations.show', $organization)
                ->with('error', 'لا يمكنك مغادرة المنظمة لأنك المدير الوحيد. قم بترقية عضو آخر أولاً.');
        }

        // إزالة المستخدم من المنظمة
        // استخدام العلاقة في النموذج بدلاً من الاستعلام المباشر
        $organization->users()->detach(Auth::id());

        return redirect()->route('organizations.index')
            ->with('success', 'تم مغادرة المنظمة بنجاح');
    }

    /**
     * إضافة عضو جديد إلى المنظمة
     */
    public function addMember(Request $request, Organization $organization)
    {
        // التحقق من صلاحيات المستخدم
        $userRole = DB::table('organization_user')
            ->where('user_id', Auth::id())
            ->where('organization_id', $organization->id)
            ->value('role');
        
        if ($userRole !== 'مدير') {
            abort(403, 'ليس لديك صلاحية لإضافة أعضاء');
        }

        // التحقق من البيانات
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|in:عضو,مدير',
        ], [
            'email.exists' => 'لا يوجد مستخدم بهذا البريد الإلكتروني',
            'role.in' => 'الدور غير صالح'
        ]);

        // جلب المستخدم
        $user = User::where('email', $validated['email'])->first();

        // التحقق من أن المستخدم ليس عضواً بالفعل
        $exists = DB::table('organization_user')
            ->where('user_id', $user->id)
            ->where('organization_id', $organization->id)
            ->exists();
            
        if ($exists) {
            return redirect()->route('organizations.show', $organization)
                ->with('error', 'المستخدم عضو بالفعل في هذه المنظمة');
        }

        // إضافة المستخدم للمنظمة
        // استخدام العلاقة في النموذج بدلاً من الاستعلام المباشر
        $organization->users()->attach($user->id, [
            'role' => $validated['role'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('organizations.show', $organization)
            ->with('success', 'تم إضافة العضو بنجاح');
    }

    /**
     * إزالة عضو من المنظمة
     */
    public function removeMember(Request $request, Organization $organization)
    {
        // التحقق من صلاحيات المستخدم
        $userRole = DB::table('organization_user')
            ->where('user_id', Auth::id())
            ->where('organization_id', $organization->id)
            ->value('role');
        
        if ($userRole !== 'مدير') {
            abort(403, 'ليس لديك صلاحية لإزالة أعضاء');
        }

        // التحقق من البيانات
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // التحقق من أن المستخدم ليس نفسه
        if (Auth::id() == $validated['user_id']) {
            return redirect()->route('organizations.show', $organization)
                ->with('error', 'لا يمكنك إزالة نفسك من المنظمة، استخدم زر المغادرة بدلاً من ذلك.');
        }

        // التحقق من أن المستخدم عضو بالفعل
        $exists = DB::table('organization_user')
            ->where('user_id', $validated['user_id'])
            ->where('organization_id', $organization->id)
            ->exists();
            
        if (!$exists) {
            return redirect()->route('organizations.show', $organization)
                ->with('error', 'المستخدم ليس عضواً في هذه المنظمة');
        }

        // إزالة المستخدم من المنظمة
        // استخدام العلاقة في النموذج بدلاً من الاستعلام المباشر
        $organization->users()->detach($validated['user_id']);

        return redirect()->route('organizations.show', $organization)
            ->with('success', 'تم إزالة العضو بنجاح');
    }

    /**
     * تحديث دور عضو في المنظمة
     */
    public function updateMemberRole(Request $request, Organization $organization)
    {
        // التحقق من صلاحيات المستخدم
        $userRole = DB::table('organization_user')
            ->where('user_id', Auth::id())
            ->where('organization_id', $organization->id)
            ->value('role');
        
        if ($userRole !== 'مدير') {
            abort(403, 'ليس لديك صلاحية لتعديل أدوار الأعضاء');
        }

        // التحقق من البيانات
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:عضو,مدير',
        ]);

        // التحقق من أن المستخدم عضو بالفعل
        $exists = DB::table('organization_user')
            ->where('user_id', $validated['user_id'])
            ->where('organization_id', $organization->id)
            ->exists();
            
        if (!$exists) {
            return redirect()->route('organizations.show', $organization)
                ->with('error', 'المستخدم ليس عضواً في هذه المنظمة');
        }

        // تحديث دور المستخدم
        // استخدام العلاقة في النموذج بدلاً من الاستعلام المباشر
        $organization->users()->updateExistingPivot($validated['user_id'], [
            'role' => $validated['role'],
            'updated_at' => now()
        ]);

        return redirect()->route('organizations.show', $organization)
            ->with('success', 'تم تحديث دور العضو بنجاح');
    }

    /**
     * التحقق من المنظمة (للمشرفين فقط)
     */
    public function verifyOrganization(Organization $organization)
    {
        // التحقق من صلاحيات المستخدم (هل هو مشرف)
        $isAdmin = DB::table('model_has_roles')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('model_has_roles.model_id', Auth::id())
            ->where('roles.name', 'مشرف')
            ->exists();
            
        if (!$isAdmin) {
            abort(403, 'ليس لديك صلاحية للتحقق من المنظمات');
        }

        // تحديث حالة التحقق
        $organization->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        return redirect()->route('organizations.show', $organization)
            ->with('success', 'تم التحقق من المنظمة بنجاح');
    }
    
    /**
     * Check if the authenticated user can manage the organization
     */
    private function canManageOrganization(Organization $organization, $requireManager = false)
    {
        // المشرفون يمكنهم دائمًا إدارة المنظمات
        $userRoles = Auth::user()->roles->pluck('name')->toArray();
        if (in_array('admin', $userRoles)) {
            return true;
        }
        
        // التحقق مما إذا كان المستخدم مرتبطًا بالمنظمة وله الدور المناسب
        $userRole = DB::table('organization_user')
            ->where('organization_id', $organization->id)
            ->where('user_id', Auth::id())
            ->value('role');
            
        if ($requireManager) {
            // للعمليات الحساسة، يجب أن يكون المستخدم مديرًا
            return $userRole === 'مدير';
        }
        
        // للعمليات العادية، يمكن للمدير أو العضو إدارة المنظمة
        return in_array($userRole, ['مدير', 'عضو']);
    }
}
