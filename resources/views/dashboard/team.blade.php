@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">لوحة تحكم الفريق التطوعي</h1>
        
        <div class="mt-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-700">إدارة الحملات التطوعية</h2>
                <a href="#" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                    إنشاء حملة جديدة
                </a>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg shadow mb-6">
                <h3 class="text-md font-semibold text-gray-800 mb-3">الحملات النشطة</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 border-b text-right">اسم الحملة</th>
                                <th class="py-2 px-4 border-b text-right">تاريخ البدء</th>
                                <th class="py-2 px-4 border-b text-right">عدد المتطوعين</th>
                                <th class="py-2 px-4 border-b text-right">الحالة</th>
                                <th class="py-2 px-4 border-b text-right">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 border-b">حملة توزيع المساعدات</td>
                                <td class="py-2 px-4 border-b">١٥ مارس ٢٠٢٥</td>
                                <td class="py-2 px-4 border-b">١٢</td>
                                <td class="py-2 px-4 border-b">
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded">نشطة</span>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <a href="#" class="text-blue-600 hover:text-blue-800 ml-2">تعديل</a>
                                    <a href="#" class="text-red-600 hover:text-red-800">حذف</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 border-b">حملة تنظيف الشاطئ</td>
                                <td class="py-2 px-4 border-b">٢٠ مارس ٢٠٢٥</td>
                                <td class="py-2 px-4 border-b">٨</td>
                                <td class="py-2 px-4 border-b">
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded">قيد الإعداد</span>
                                </td>
                                <td class="py-2 px-4 border-b">
                                    <a href="#" class="text-blue-600 hover:text-blue-800 ml-2">تعديل</a>
                                    <a href="#" class="text-red-600 hover:text-red-800">حذف</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg shadow">
                <h3 class="text-md font-semibold text-gray-800 mb-3">إدارة المتطوعين</h3>
                <p class="text-gray-600 mb-3">إدارة المتطوعين المشاركين في حملاتك التطوعية.</p>
                <a href="#" class="text-blue-600 hover:text-blue-800">عرض قائمة المتطوعين &rarr;</a>
            </div>
        </div>
    </div>
</div>
@endsection 