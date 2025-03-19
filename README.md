<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## تعليمات التحسينات

### 1. تحسينات الأداء

#### 1.1. استخدام التخزين المؤقت

تم إضافة تحسينات للأداء عبر التخزين المؤقت في WelcomeController للصفحة الرئيسية. يمكن تطبيق نفس المبدأ على باقي المتحكمات، مثلاً:

```php
// مثال للبيانات التي يمكن تخزينها مؤقتاً
$data = Cache::remember('cache_key', 3600, function () {
    // استعلام قاعدة البيانات الثقيل
    return Model::with('relation')->where(...)->get();
});
```

#### 1.2. معالجة الصور

تم إضافة خدمة `ImageService` لتحسين الصور قبل تخزينها. تحتاج إلى تثبيت مكتبة Intervention/Image:

```bash
composer require intervention/image
```

#### 1.3. التحميل البطيء للصور (Lazy Loading)

للتحسين، أضف السمة `loading="lazy"` إلى علامات الصور في الواجهات:

```html
<img src="{{ $image->url }}" alt="{{ $image->alt }}" loading="lazy">
```

### 2. تحسينات الأمان

#### 2.1. تنظيف المدخلات

تم تحسين تنظيف المدخلات في المتحكمات. يمكن استخدام مكتبة HTMLPurifier لتنظيف أفضل:

```bash
composer require mews/purifier
```

#### 2.2. التحقق من الصلاحيات (Authorization)

تأكد من استخدام `$this->authorize()` في جميع طرق المتحكمات التي تتطلب صلاحيات خاصة.

### 3. إعادة هيكلة الكود

#### 3.1. استخراج المتحكمات الكبيرة

يجب تقسيم AdminController إلى عدة متحكمات أصغر:

1. AdminUsersController
2. AdminCampaignsController
3. AdminOrganizationsController
4. AdminJobOffersController

#### 3.2. استخدام Actions/Services

لتحسين قابلية الاختبار والصيانة، استخدم نمط الأعمال (Actions/Services) لفصل المنطق:

```php
// Action/Service class
namespace App\Actions;

class CreateJobOfferAction
{
    public function execute(array $data)
    {
        // منطق إنشاء فرصة التطوع
    }
}

// في المتحكم
public function store(Request $request)
{
    // التحقق من المدخلات
    $action = new CreateJobOfferAction();
    $jobOffer = $action->execute($validatedData);
    
    return redirect()->route(...);
}
```

### 4. توصيات إضافية

1. **تحسين الواجهة للأجهزة المحمولة**: تأكد من أن جميع الصفحات متجاوبة ومناسبة للأجهزة المحمولة.
2. **تعدد اللغات**: ضف دعماً للغات المحلية الأخرى مثل الكردية.
3. **التوثيق**: أضف توثيقاً أفضل للأكواد.
4. **الاختبارات**: أضف اختبارات أتوماتيكية للوظائف الأساسية.
