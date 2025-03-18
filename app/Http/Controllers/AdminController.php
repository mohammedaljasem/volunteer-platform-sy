<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Company;
use App\Models\Organization;
use App\Models\Donation;
use App\Models\LocalAd;
use App\Models\User;
use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Constructor to apply middleware
     */
    public function __construct()
    {
        // استخدام middleware للتحقق من أن المستخدم لديه صلاحية الوصول إلى لوحة الأدمن
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * عرض لوحة تحكم الأدمن
     * Display the admin dashboard.
     */
    public function index()
    {
        // جمع الإحصائيات
        $stats = [
            'campaigns' => Ad::count(),
            'teams' => Company::count(),
            'organizations' => Organization::count(),
            'total_donations' => Donation::sum('amount'),
            'active_local_ads' => LocalAd::where('status', 'نشط')->count(),
            'pending_local_ads' => LocalAd::where('status', 'معلق')->count(),
            'users' => User::count(),
            'job_offers' => JobOffer::count(),
        ];

        // جلب آخر الحملات
        $latest_campaigns = Ad::with('company')->latest()->take(5)->get();
        
        // جلب آخر التبرعات
        $latest_donations = Donation::with(['user', 'ad'])->latest()->take(5)->get();
        
        // جلب الإعلانات المحلية المعلقة
        $pending_local_ads = LocalAd::with(['user', 'city'])->where('status', 'معلق')->latest()->take(5)->get();
        
        // جلب المنظمات
        $organizations = Organization::latest()->take(5)->get();
        
        // جلب فرص التطوع
        $job_offers = JobOffer::with('organization')->latest()->take(5)->get();
        
        return view('admin.index', compact(
            'stats', 
            'latest_campaigns', 
            'latest_donations', 
            'pending_local_ads',
            'organizations',
            'job_offers'
        ));
    }
    
    /**
     * عرض جميع الحملات التطوعية
     * Show all campaigns
     */
    public function campaigns()
    {
        $campaigns = Ad::with('company')->latest()->paginate(10);
        return view('admin.campaigns.index', compact('campaigns'));
    }
    
    /**
     * عرض نموذج تعديل حملة
     * Show edit campaign form
     */
    public function editCampaign($id)
    {
        $campaign = Ad::findOrFail($id);
        $companies = Company::all();
        return view('admin.campaigns.edit', compact('campaign', 'companies'));
    }
    
    /**
     * تحديث حملة تطوعية
     * Update campaign
     */
    public function updateCampaign(Request $request, $id)
    {
        $campaign = Ad::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'company_id' => 'required|exists:companies,id',
            'category' => 'nullable|string',
            'goal_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'image' => 'nullable|image|max:2048',
        ]);
        
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($campaign->image) {
                Storage::disk('public')->delete($campaign->image);
            }
            
            $path = $request->file('image')->store('ads', 'public');
            $validated['image'] = $path;
        }
        
        $campaign->update($validated);
        
        return redirect()->route('admin.campaigns')
            ->with('success', 'تم تحديث الحملة بنجاح');
    }
    
    /**
     * حذف حملة تطوعية
     * Delete a campaign
     */
    public function deleteAd($id)
    {
        $ad = Ad::findOrFail($id);
        
        // حذف الصورة المرتبطة بالحملة
        if ($ad->image) {
            Storage::disk('public')->delete($ad->image);
        }
        
        $ad->delete();
        
        return redirect()->route('admin.index')->with('success', 'تم حذف الحملة بنجاح');
    }
    
    /**
     * عرض جميع المستخدمين
     * Show all users
     */
    public function users()
    {
        $users = User::with('roles')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * عرض نموذج تعديل المستخدم
     * Show edit user form
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $roles = \Spatie\Permission\Models\Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }
    
    /**
     * تحديث بيانات المستخدم
     * Update user
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|exists:roles,name'
        ]);
        
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);
        
        // تحديث دور المستخدم
        $user->syncRoles([$validated['role']]);
        
        return redirect()->route('admin.users')
            ->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }
    
    /**
     * حذف مستخدم
     * Delete user
     */
    public function deleteUser($id)
    {
        if (Auth::id() == $id) {
            return redirect()->route('admin.users')
                ->with('error', 'لا يمكنك حذف حسابك الخاص');
        }
        
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect()->route('admin.users')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }
    
    /**
     * عرض جميع المنظمات
     * Show all organizations
     */
    public function organizations()
    {
        $organizations = Organization::latest()->paginate(10);
        return view('admin.organizations.index', compact('organizations'));
    }
    
    /**
     * التحقق من منظمة
     * Verify organization
     */
    public function verifyOrganization($id)
    {
        $organization = Organization::findOrFail($id);
        $organization->verified = true;
        $organization->save();
        
        return redirect()->route('admin.organizations')
            ->with('success', 'تم التحقق من المنظمة بنجاح');
    }
    
    /**
     * عرض نموذج تعديل المنظمة
     * Show edit organization form
     */
    public function editOrganization($id)
    {
        $organization = Organization::findOrFail($id);
        return view('admin.organizations.edit', compact('organization'));
    }
    
    /**
     * تحديث بيانات المنظمة
     * Update organization
     */
    public function updateOrganization(Request $request, $id)
    {
        $organization = Organization::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'nullable|image|max:2048',
            'website' => 'nullable|url',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'verified' => 'nullable|boolean',
        ]);
        
        if ($request->hasFile('logo')) {
            if ($organization->logo) {
                Storage::disk('public')->delete($organization->logo);
            }
            
            $path = $request->file('logo')->store('organizations', 'public');
            $validated['logo'] = $path;
        }
        
        $organization->update($validated);
        
        return redirect()->route('admin.organizations')
            ->with('success', 'تم تحديث بيانات المنظمة بنجاح');
    }
    
    /**
     * حذف منظمة
     * Delete organization
     */
    public function deleteOrganization($id)
    {
        $organization = Organization::findOrFail($id);
        
        if ($organization->logo) {
            Storage::disk('public')->delete($organization->logo);
        }
        
        $organization->delete();
        
        return redirect()->route('admin.organizations')
            ->with('success', 'تم حذف المنظمة بنجاح');
    }
    
    /**
     * تفعيل إعلان محلي
     * Approve a local ad
     */
    public function approveLocalAd($id)
    {
        $localAd = LocalAd::findOrFail($id);
        $localAd->status = 'نشط';
        $localAd->save();
        
        return redirect()->route('admin.index')->with('success', 'تم تفعيل الإعلان المحلي بنجاح');
    }
    
    /**
     * رفض إعلان محلي
     * Reject a local ad
     */
    public function rejectLocalAd($id)
    {
        $localAd = LocalAd::findOrFail($id);
        $localAd->status = 'مرفوض';
        $localAd->save();
        
        return redirect()->route('admin.index')->with('success', 'تم رفض الإعلان المحلي');
    }
    
    /**
     * عرض جميع الإعلانات المحلية
     * Show all local ads
     */
    public function localAds()
    {
        $localAds = LocalAd::with(['user', 'city'])->latest()->paginate(10);
        return view('admin.local-ads.index', compact('localAds'));
    }
    
    /**
     * عرض نموذج تعديل إعلان محلي
     * Edit local ad form
     */
    public function editLocalAd($id)
    {
        $localAd = LocalAd::findOrFail($id);
        $cities = \App\Models\City::all();
        return view('admin.local-ads.edit', compact('localAd', 'cities'));
    }
    
    /**
     * تحديث إعلان محلي
     * Update local ad
     */
    public function updateLocalAd(Request $request, $id)
    {
        $localAd = LocalAd::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:نشط,معلق,مرفوض',
            'city_id' => 'nullable|exists:cities,id',
            'category' => 'nullable|string',
            'contact_info' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);
        
        if ($request->hasFile('image')) {
            if ($localAd->image) {
                Storage::disk('public')->delete($localAd->image);
            }
            
            $path = $request->file('image')->store('local-ads', 'public');
            $validated['image'] = $path;
        }
        
        $localAd->update($validated);
        
        return redirect()->route('admin.local-ads')
            ->with('success', 'تم تحديث الإعلان المحلي بنجاح');
    }
    
    /**
     * حذف إعلان محلي
     * Delete local ad
     */
    public function deleteLocalAd($id)
    {
        $localAd = LocalAd::findOrFail($id);
        
        if ($localAd->image) {
            Storage::disk('public')->delete($localAd->image);
        }
        
        $localAd->delete();
        
        return redirect()->route('admin.local-ads')
            ->with('success', 'تم حذف الإعلان المحلي بنجاح');
    }

    /**
     * عرض جميع فرص التطوع
     * Show all job offers
     */
    public function jobOffers()
    {
        $jobOffers = JobOffer::with('organization')->latest()->paginate(10);
        return view('admin.job-offers.index', compact('jobOffers'));
    }

    /**
     * عرض فرصة تطوع واحدة
     * Show a single job offer
     */
    public function showJobOffer($id)
    {
        $jobOffer = JobOffer::with('organization')->findOrFail($id);
        return view('admin.job-offers.show', compact('jobOffer'));
    }
    
    /**
     * عرض نموذج تعديل فرصة تطوع
     * Show edit job offer form
     */
    public function editJobOffer($id)
    {
        $jobOffer = JobOffer::findOrFail($id);
        $organizations = Organization::all();
        return view('admin.job-offers.edit', compact('jobOffer', 'organizations'));
    }

    /**
     * تحديث فرصة تطوع
     * Update job offer
     */
    public function updateJobOffer(Request $request, $id)
    {
        $jobOffer = JobOffer::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:متاحة,مغلقة,معلقة',
            'organization_id' => 'nullable|exists:organizations,id',
            'skills_required' => 'nullable|string',
            'location' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'start_date' => 'nullable|date',
            'deadline' => 'nullable|date|after:start_date',
        ]);
        
        if ($request->hasFile('image')) {
            if ($jobOffer->image) {
                Storage::disk('public')->delete($jobOffer->image);
            }
            
            $path = $request->file('image')->store('job-offers', 'public');
            $validated['image'] = $path;
        }
        
        $jobOffer->update($validated);
        
        return redirect()->route('admin.job-offers')
            ->with('success', 'تم تحديث فرصة التطوع بنجاح');
    }

    /**
     * حذف فرصة تطوع
     * Delete job offer
     */
    public function deleteJobOffer($id)
    {
        $jobOffer = JobOffer::findOrFail($id);
        
        if ($jobOffer->image) {
            Storage::disk('public')->delete($jobOffer->image);
        }
        
        $jobOffer->delete();
        
        return redirect()->route('admin.job-offers')
            ->with('success', 'تم حذف فرصة التطوع بنجاح');
    }
} 