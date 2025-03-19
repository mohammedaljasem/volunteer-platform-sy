<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $organization->name }}
                @if($organization->is_verified)
                <span class="inline-flex items-center mr-2 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                    <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3" />
                    </svg>
                    {{ __('تم التحقق') }}
                </span>
                @else
                <span class="inline-flex items-center mr-2 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                    {{ __('في انتظار التحقق') }}
                </span>
                @endif
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('organizations.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:border-gray-700 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-gray-700 dark:hover:bg-gray-600">
                    {{ __('العودة للقائمة') }}
                </a>
                @php
                    $isMember = DB::table('organization_user')
                        ->where('user_id', Auth::id())
                        ->where('organization_id', $organization->id)
                        ->exists();
                    
                    $userRole = DB::table('organization_user')
                        ->where('user_id', Auth::id())
                        ->where('organization_id', $organization->id)
                        ->value('role');
                        
                    $isAdmin = DB::table('model_has_roles')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('model_has_roles.model_id', Auth::id())
                        ->where('roles.name', 'مشرف')
                        ->exists();
                        
                    $isManager = DB::table('organization_user')
                        ->where('user_id', Auth::id())
                        ->where('organization_id', $organization->id)
                        ->where('role', 'مدير')
                        ->exists();
                @endphp
                
                @if($isManager)
                <a href="{{ route('organizations.edit', $organization) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-blue-700 dark:hover:bg-blue-600">
                    {{ __('تعديل المنظمة') }}
                </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-green-900/40 dark:border-green-800 dark:text-green-300" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif
            
            @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative dark:bg-red-900/40 dark:border-red-800 dark:text-red-300" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif
            
            @if(session('info'))
            <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative dark:bg-blue-900/40 dark:border-blue-800 dark:text-blue-300" role="alert">
                <span class="block sm:inline">{{ session('info') }}</span>
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('معلومات المنظمة') }}</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('التفاصيل الأساسية للمنظمة') }}</p>
                            
                            @if(!$isMember)
                            <div class="mt-4">
                                <form method="POST" action="{{ route('organizations.join', $organization) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-blue-700 dark:hover:bg-blue-600">
                                        {{ __('انضمام للمنظمة') }}
                                    </button>
                                </form>
                            </div>
                            @else
                            <div class="mt-4">
                                <form method="POST" action="{{ route('organizations.leave', $organization) }}" onsubmit="return confirm('{{ __('هل أنت متأكد من مغادرة المنظمة؟') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-red-700 dark:hover:bg-red-600">
                                        {{ __('مغادرة المنظمة') }}
                                    </button>
                                </form>
                            </div>
                            @endif
                            
                            @if($isAdmin && !$organization->is_verified)
                            <div class="mt-4">
                                <form method="POST" action="{{ route('organizations.verify', $organization) }}">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-green-700 dark:hover:bg-green-600">
                                        {{ __('تحقق من المنظمة') }}
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <div>
                                <dl>
                                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('اسم المنظمة') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $organization->name }}</dd>
                                    </div>
                                    <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('الوصف') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $organization->description }}</dd>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('البريد الإلكتروني للتواصل') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $organization->contact_email }}</dd>
                                    </div>
                                    @if(($isMember || $isAdmin) && $organization->verification_docs)
                                    <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('وثائق التحقق') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                            <a href="{{ Storage::url($organization->verification_docs) }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                {{ __('عرض وثائق التحقق') }}
                                            </a>
                                        </dd>
                                    </div>
                                    @endif
                                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">{{ __('تاريخ الإنشاء') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">{{ $organization->created_at ? $organization->created_at->format('Y-m-d') : __('غير متوفر') }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                    
                    <!-- فرص التطوع -->
                    @include('organizations.job_offers')
                    
                    <!-- أعضاء المنظمة -->
                    @include('organizations.members')
                    
                    @if($isManager)
                    <!-- حذف المنظمة -->
                    <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-end">
                            <form method="POST" action="{{ route('organizations.destroy', $organization) }}" onsubmit="return confirm('{{ __('هل أنت متأكد من حذف المنظمة؟ هذا الإجراء لا يمكن التراجع عنه.') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:border-red-700 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-red-700 dark:hover:bg-red-600">
                                    {{ __('حذف المنظمة') }}
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 