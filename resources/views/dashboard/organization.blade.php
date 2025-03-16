@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">لوحة تحكم المنظمة</h1>
        
        <div class="mt-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">إدارة الحملات والتقارير</h2>
                <a href="#" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                    إنشاء حملة جديدة
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-blue-50 p-4 rounded-lg shadow">
                    <h3 class="text-md font-semibold text-blue-800 mb-3">إحصائيات الحملات</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-3 rounded-md shadow-sm">
                            <p class="text-sm text-gray-500">إجمالي الحملات</p>
                            <p class="text-2xl font-bold text-blue-600">١٢</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm">
                            <p class="text-sm text-gray-500">الحملات النشطة</p>
                            <p class="text-2xl font-bold text-green-600">٥</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm">
                            <p class="text-sm text-gray-500">إجمالي المتطوعين</p>
                            <p class="text-2xl font-bold text-purple-600">٨٧</p>
                        </div>
                        <div class="bg-white p-3 rounded-md shadow-sm">
                            <p class="text-sm text-gray-500">ساعات التطوع</p>
                            <p class="text-2xl font-bold text-orange-600">٣٤٥</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-purple-50 p-4 rounded-lg shadow">
                    <h3 class="text-md font-semibold text-purple-800 mb-3">التقارير</h3>
                    <ul class="space-y-2">
                        <li class="bg-white p-3 rounded-md shadow-sm">
                            <a href="#" class="flex justify-between items-center">
                                <span class="text-gray-700">تقرير أداء الحملات</span>
                                <span class="text-purple-600">&larr;</span>
                            </a>
                        </li>
                        <li class="bg-white p-3 rounded-md shadow-sm">
                            <a href="#" class="flex justify-between items-center">
                                <span class="text-gray-700">تقرير المتطوعين</span>
                                <span class="text-purple-600">&larr;</span>
                            </a>
                        </li>
                        <li class="bg-white p-3 rounded-md shadow-sm">
                            <a href="#" class="flex justify-between items-center">
                                <span class="text-gray-700">تقرير التبرعات</span>
                                <span class="text-purple-600">&larr;</span>
                            </a>
                        </li>
                        <li class="bg-white p-3 rounded-md shadow-sm">
                            <a href="#" class="flex justify-between items-center">
                                <span class="text-gray-700">تقرير الأثر المجتمعي</span>
                                <span class="text-purple-600">&larr;</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg shadow">
                <h3 class="text-md font-semibold text-gray-800 mb-3">الحملات الحالية</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border-b text-right">اسم الحملة</th>
                                <th class="py-2 px-4 border-b text-right">تاريخ البدء</th>
                                <th class="py-2 px-4 border-b text-right">تاريخ الانتهاء</th>
                                <th class="py-2 px-4 border-b text-right">عدد المتطوعين</th>
                                <th class="py-2 px-4 border-b text-right">الحالة</th>
                                <th class="py-2 px-4 border-b text-right">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b">حملة إعادة إعمار</td>
                                <td class="py-2 px-4 border-b">١٠ مارس ٢٠٢٥</td>
                                <td class="py-2 px-4 border-b">١٠ أبريل ٢٠٢٥</td>
                                <td class="py-2 px-4 border-b">٢٥</td>
                                <td class="py-2 px-4 border-b">
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded">نشطة</span>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <a href="#" class="text-blue-600 hover:text-blue-800 ml-2">تعديل</a>
                                    <a href="#" class="text-blue-600 hover:text-blue-800 ml-2">تقرير</a>
                                    <a href="#" class="text-red-600 hover:text-red-800">حذف</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b">حملة توزيع مساعدات طبية</td>
                                <td class="py-2 px-4 border-b">١٥ مارس ٢٠٢٥</td>
                                <td class="py-2 px-4 border-b">١٥ مايو ٢٠٢٥</td>
                                <td class="py-2 px-4 border-b">١٨</td>
                                <td class="py-2 px-4 border-b">
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded">نشطة</span>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <a href="#" class="text-blue-600 hover:text-blue-800 ml-2">تعديل</a>
                                    <a href="#" class="text-blue-600 hover:text-blue-800 ml-2">تقرير</a>
                                    <a href="#" class="text-red-600 hover:text-red-800">حذف</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 