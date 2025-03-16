@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">مرحباً، {{ Auth::user()->name }}</h1>
        
        <div class="mt-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-3">لوحة التحكم الرئيسية</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-green-50 p-4 rounded-lg shadow">
                    <h3 class="text-md font-semibold text-green-800 mb-2">الحملات التطوعية المتاحة</h3>
                    <p class="text-gray-600">استعرض الحملات التطوعية المتاحة وانضم إليها.</p>
                    <a href="#" class="mt-3 inline-block text-sm text-green-600 hover:text-green-800">عرض الحملات &rarr;</a>
                </div>
                
                <div class="bg-blue-50 p-4 rounded-lg shadow">
                    <h3 class="text-md font-semibold text-blue-800 mb-2">حسابي الشخصي</h3>
                    <p class="text-gray-600">تحديث بياناتك الشخصية وتفضيلات الإشعارات.</p>
                    <a href="#" class="mt-3 inline-block text-sm text-blue-600 hover:text-blue-800">تعديل الحساب &rarr;</a>
                </div>
                
                <div class="bg-purple-50 p-4 rounded-lg shadow">
                    <h3 class="text-md font-semibold text-purple-800 mb-2">نشاطاتي</h3>
                    <p class="text-gray-600">عرض سجل نشاطاتك والحملات التي شاركت بها.</p>
                    <a href="#" class="mt-3 inline-block text-sm text-purple-600 hover:text-purple-800">عرض النشاطات &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 