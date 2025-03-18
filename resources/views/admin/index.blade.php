<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
            {{ __('لوحة تحكم الأدمن') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 rtl" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- إشعارات النجاح والخطأ -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- بطاقات الإحصائيات -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-2xl text-blue-600 font-bold">{{ $stats['campaigns'] }}</div>
                    <div class="text-gray-600 mt-1">عدد الحملات</div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-2xl text-green-600 font-bold">{{ $stats['teams'] }}</div>
                    <div class="text-gray-600 mt-1">عدد الفرق</div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-2xl text-purple-600 font-bold">{{ $stats['organizations'] }}</div>
                    <div class="text-gray-600 mt-1">عدد المنظمات</div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-2xl text-amber-600 font-bold">{{ number_format($stats['total_donations'], 2) }} ل.س</div>
                    <div class="text-gray-600 mt-1">إجمالي التبرعات</div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-2xl text-teal-600 font-bold">{{ $stats['active_local_ads'] }}</div>
                    <div class="text-gray-600 mt-1">الإعلانات المحلية النشطة</div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-2xl text-orange-600 font-bold">{{ $stats['pending_local_ads'] }}</div>
                    <div class="text-gray-600 mt-1">الإعلانات المحلية المعلقة</div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="text-2xl text-indigo-600 font-bold">{{ $stats['users'] }}</div>
                    <div class="text-gray-600 mt-1">عدد المستخدمين</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- آخر الحملات -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">آخر الحملات</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">العنوان</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المنظمة</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">إجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($latest_campaigns as $campaign)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $campaign->title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $campaign->company->name ?? 'غير محدد' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $campaign->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $campaign->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                            <a href="{{ route('ads.show', $campaign->id) }}" class="text-indigo-600 hover:text-indigo-900 ml-2">عرض</a>
                                            <form action="{{ route('admin.campaigns.delete', $campaign->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('هل أنت متأكد من حذف هذه الحملة؟')">حذف</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">لا توجد حملات لعرضها</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- آخر التبرعات -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">آخر التبرعات</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المتبرع</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحملة</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المبلغ</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التاريخ</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($latest_donations as $donation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $donation->user->name ?? 'غير معروف' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $donation->ad->title ?? 'غير معروف' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ number_format($donation->amount, 2) }} ل.س</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $donation->created_at->format('Y-m-d') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">لا توجد تبرعات لعرضها</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                <!-- المنظمات -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">المنظمات المسجلة</h2>
                        <a href="{{ route('admin.organizations') }}" class="px-3 py-1 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600">عرض الكل</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الاسم</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التحقق</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">إجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @isset($organizations)
                                    @forelse($organizations as $organization)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $organization->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $organization->verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $organization->verified ? 'تم التحقق' : 'غير متحقق' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                                <a href="{{ route('organizations.show', $organization->id) }}" class="text-indigo-600 hover:text-indigo-900 ml-2">عرض</a>
                                                <a href="{{ route('admin.organizations.edit', $organization->id) }}" class="text-blue-600 hover:text-blue-900 ml-2">تعديل</a>
                                                @if(!$organization->verified)
                                                    <form action="{{ route('admin.organizations.verify', $organization->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-900 ml-2">تحقق</button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('admin.organizations.delete', $organization->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('هل أنت متأكد من حذف هذه المنظمة؟')">حذف</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">لا توجد منظمات لعرضها</td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">قم بتحديث متغير Organizations في المتحكم</td>
                                    </tr>
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- فرص التطوع -->
                <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">فرص التطوع</h2>
                        <a href="{{ route('admin.job-offers') }}" class="px-3 py-1 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600">عرض الكل</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">العنوان</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المنظمة</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">إجراءات</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @isset($job_offers)
                                    @forelse($job_offers as $jobOffer)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $jobOffer->title }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ $jobOffer->organization->name ?? 'غير محدد' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $jobOffer->status == 'متاحة' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $jobOffer->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                                <a href="{{ route('job-offers.show', $jobOffer->id) }}" class="text-indigo-600 hover:text-indigo-900 ml-2">عرض</a>
                                                <a href="{{ route('admin.job-offers.edit', $jobOffer->id) }}" class="text-blue-600 hover:text-blue-900 ml-2">تعديل</a>
                                                <form action="{{ route('admin.job-offers.delete', $jobOffer->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('هل أنت متأكد من حذف هذه الفرصة؟')">حذف</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">لا توجد فرص تطوع لعرضها</td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">قم بتحديث متغير job_offers في المتحكم</td>
                                    </tr>
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- الإعلانات المحلية المعلقة -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">الإعلانات المحلية المعلقة</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">العنوان</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المستخدم</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المدينة</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الإضافة</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">إجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pending_local_ads as $localAd)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $localAd->title }}</div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($localAd->description, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $localAd->user->name ?? 'غير معروف' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $localAd->city->name ?? 'غير محدد' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $localAd->created_at->format('Y-m-d') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                        <form action="{{ route('admin.local-ads.approve', $localAd->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 ml-2">قبول</button>
                                        </form>
                                        <form action="{{ route('admin.local-ads.reject', $localAd->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('هل أنت متأكد من رفض هذا الإعلان؟')">رفض</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">لا توجد إعلانات معلقة لعرضها</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- نموذج إضافة إعلان محلي جديد -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">إضافة إعلان محلي جديد</h2>
                
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">العنوان</label>
                        <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">الوصف</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                    </div>
                    
                    <div>
                        <label for="city_id" class="block text-sm font-medium text-gray-700">المدينة</label>
                        <select name="city_id" id="city_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">اختر المدينة</option>
                            <!-- لاحقا يمكن استبدال هذا بدورة على مدن سوريا من قاعدة البيانات -->
                            <option value="1">دمشق</option>
                            <option value="2">حلب</option>
                            <option value="3">حمص</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="contact_info" class="block text-sm font-medium text-gray-700">معلومات الاتصال</label>
                        <input type="text" name="contact_info" id="contact_info" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                    
                    <div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                            إضافة الإعلان
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout> 