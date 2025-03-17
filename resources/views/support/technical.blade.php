<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('الدعم الفني') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-6">مركز الدعم الفني</h3>

                    <!-- قسم معلومات الاتصال -->
                    <div class="bg-blue-50 p-6 rounded-lg mb-8">
                        <h4 class="text-primary font-bold mb-4">اتصل بنا</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-envelope text-primary text-xl ml-3"></i>
                                    <div>
                                        <p class="font-semibold">البريد الإلكتروني:</p>
                                        <p>support@volunteer-platform.sy</p>
                                    </div>
                                </div>
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-phone-alt text-primary text-xl ml-3"></i>
                                    <div>
                                        <p class="font-semibold">رقم الهاتف:</p>
                                        <p>+963 911 234567</p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-clock text-primary text-xl ml-3"></i>
                                    <div>
                                        <p class="font-semibold">أوقات العمل:</p>
                                        <p>الأحد - الخميس: 9:00 ص - 5:00 م</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-comment-dots text-primary text-xl ml-3"></i>
                                    <div>
                                        <p class="font-semibold">الدردشة المباشرة:</p>
                                        <p>متاحة خلال ساعات العمل</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- قسم نموذج الاتصال -->
                    <div class="mb-8">
                        <h4 class="text-primary font-bold mb-4">ارسل لنا رسالة</h4>
                        <form action="{{ route('support.send') }}" method="POST" class="space-y-4">
                            @csrf

                            @if(session('success'))
                                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-4">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
                                    <ul class="list-disc pr-5">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">الاسم</label>
                                    <input type="text" name="name" id="name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" value="{{ auth()->user()->name ?? old('name') }}" required>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
                                    <input type="email" name="email" id="email" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" value="{{ auth()->user()->email ?? old('email') }}" required>
                                </div>
                            </div>

                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">الموضوع</label>
                                <input type="text" name="subject" id="subject" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" value="{{ old('subject') }}" required>
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">نوع المشكلة</label>
                                <select name="category" id="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" required>
                                    <option value="">-- اختر نوع المشكلة --</option>
                                    <option value="account" {{ old('category') == 'account' ? 'selected' : '' }}>مشكلة في الحساب</option>
                                    <option value="volunteer" {{ old('category') == 'volunteer' ? 'selected' : '' }}>مشكلة في التطوع</option>
                                    <option value="donation" {{ old('category') == 'donation' ? 'selected' : '' }}>مشكلة في التبرع</option>
                                    <option value="technical" {{ old('category') == 'technical' ? 'selected' : '' }}>مشكلة فنية</option>
                                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>أخرى</option>
                                </select>
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">الرسالة</label>
                                <textarea name="message" id="message" rows="6" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" required>{{ old('message') }}</textarea>
                            </div>

                            <div>
                                <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-6 rounded-md transition-colors">
                                    إرسال الرسالة
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- قسم الأسئلة الشائعة -->
                    <div>
                        <h4 class="text-primary font-bold mb-4">مشاكل شائعة وحلولها</h4>
                        <div class="space-y-4">
                            <div class="border-b pb-3">
                                <h5 class="font-semibold mb-2">لا يمكنني تسجيل الدخول، ماذا أفعل؟</h5>
                                <p>تأكد من صحة بريدك الإلكتروني وكلمة المرور. إذا نسيت كلمة المرور، استخدم خيار "نسيت كلمة المرور" في صفحة تسجيل الدخول. إذا استمرت المشكلة، تواصل معنا عبر البريد الإلكتروني.</p>
                            </div>
                            <div class="border-b pb-3">
                                <h5 class="font-semibold mb-2">كيف يمكنني تغيير معلومات حسابي؟</h5>
                                <p>يمكنك تعديل معلومات حسابك من خلال الضغط على اسمك في الزاوية العليا ثم اختيار "الملف الشخصي". ستجد هناك خيارات لتعديل بياناتك وتغيير كلمة المرور.</p>
                            </div>
                            <div class="border-b pb-3">
                                <h5 class="font-semibold mb-2">لا يمكنني التقديم لفرصة تطوع، ما المشكلة؟</h5>
                                <p>قد تكون الفرصة مغلقة أو انتهت مهلة التقديم. تأكد أيضًا من أنك قمت باستكمال ملفك الشخصي وأضفت معلومات الاتصال المطلوبة.</p>
                            </div>
                            <div>
                                <h5 class="font-semibold mb-2">هل يمكنني استرداد تبرعي؟</h5>
                                <p>بشكل عام، لا يمكن استرداد التبرعات بعد تأكيدها. في حالات استثنائية، يرجى التواصل مع فريق الدعم الفني خلال 24 ساعة من إجراء التبرع.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 