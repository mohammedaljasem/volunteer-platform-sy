<!DOCTYPE html>
<html lang="ar" dir="rtl" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة التطوع الأولى في سوريا</title>
    <!-- Bootstrap RTL CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Cairo Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* تنسيقات الوضع الفاتح */
        :root {
            --bg-color: #fff;
            --text-color: #333;
            --card-bg: #fff;
            --card-border: #e5e7eb;
            --feature-icon-bg: #f8f9fa;
            --feature-icon-color: #1a237e;
            --bg-pattern: #f8f9fa;
            --heading-color: #212529;
            --footer-bg: #343a40;
            --footer-text: rgba(255,255,255,0.8);
            --footer-link: rgba(255,255,255,0.7);
            --progress-bg: #e9ecef;
        }
        
        /* تنسيقات الوضع الداكن */
        @media (prefers-color-scheme: dark) {
            :root {
                --bg-color: #1f2937;
                --text-color: #e5e7eb;
                --card-bg: #111827;
                --card-border: #374151;
                --feature-icon-bg: #374151;
                --feature-icon-color: #818cf8;
                --bg-pattern: #111827;
                --heading-color: #f3f4f6;
                --footer-bg: #111827;
                --footer-text: rgba(229,231,235,0.8);
                --footer-link: rgba(229,231,235,0.7);
                --progress-bg: #4b5563;
            }
            
            body {
                background-color: var(--bg-color);
                color: var(--text-color);
            }
            
            .card {
                background-color: var(--card-bg);
                border-color: var(--card-border);
            }
            
            .bg-light {
                background-color: #374151 !important;
            }
            
            .text-dark {
                color: var(--text-color) !important;
            }
            
            .text-muted {
                color: #9ca3af !important;
            }
            
            .btn-outline-primary {
                color: #818cf8;
                border-color: #818cf8;
            }
            
            .btn-outline-primary:hover {
                background-color: #818cf8;
                color: #111827;
            }
            
            .btn-primary {
                background-color: #4f46e5;
                border-color: #4f46e5;
            }
            
            .progress-bar {
                background-color: #4f46e5;
            }
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            color: var(--text-color);
            background-color: var(--bg-color);
        }
        
        h1, h2, h3, h4, h5, h6 {
            color: var(--heading-color);
        }
        
        /* تنسيق القسم الرئيسي (Hero Section) */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1567958451986-2de4110ba79a?auto=format&fit=crop&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 7rem 0;
            margin-bottom: 3rem;
            position: relative;
        }
        
        /* شرائح العرض */
        .carousel-item {
            height: 500px;
            background-size: cover;
            background-position: center;
        }
        
        .carousel-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            text-align: center;
        }
        
        .carousel-caption {
            position: relative;
            right: auto;
            left: auto;
            bottom: auto;
            padding: 0 15%;
        }
        
        /* تنسيق بطاقات الميزات */
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
            height: 100%;
            background-color: var(--card-bg);
            border-color: var(--card-border);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background-color: var(--feature-icon-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--feature-icon-color);
        }
        
        /* تنسيق بطاقات الحملات */
        .campaign-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 10px;
            overflow: hidden;
            height: 100%;
            background-color: var(--card-bg);
            border-color: var(--card-border);
        }
        
        .campaign-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .campaign-image {
            height: 200px;
            object-fit: cover;
        }
        
        .progress {
            height: 10px;
            border-radius: 5px;
            background-color: var(--progress-bg);
        }
        
        /* شريط الخدمات */
        .services-strip {
            background: linear-gradient(45deg, #1a237e, #3949ab);
            padding: 3rem 0;
            color: white;
            margin: 4rem 0;
        }
        
        .service-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        /* خلفية الصفحة */
        .bg-pattern {
            background-color: var(--bg-pattern);
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%231a237e' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        /* تذييل الصفحة */
        footer {
            background-color: var(--footer-bg);
            color: var(--footer-text);
            padding: 3rem 0 1rem;
        }
        
        footer h5 {
            color: white;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        footer ul {
            list-style: none;
            padding: 0;
        }
        
        footer ul li {
            margin-bottom: 0.5rem;
        }
        
        footer a {
            color: var(--footer-link);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        footer a:hover {
            color: white;
            text-decoration: none;
        }
        
        /* نموذج الاشتراك */
        .subscribe-form .form-control {
            border-top-right-radius: 0.25rem !important;
            border-bottom-right-radius: 0.25rem !important;
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
            background-color: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.1);
            color: white;
        }
        
        .subscribe-form .btn {
            border-top-left-radius: 0.25rem !important;
            border-bottom-left-radius: 0.25rem !important;
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }
        
        /* شريط التنقل */
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            background-color: var(--card-bg) !important;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--heading-color) !important;
        }
        
        .navbar-nav .nav-link {
            color: var(--text-color);
            font-weight: 500;
            padding: 0.5rem 1rem;
        }
        
        .navbar-nav .nav-item.active .nav-link, 
        .navbar-nav .nav-link:hover {
            color: #1a237e;
        }
        
        @media (prefers-color-scheme: dark) {
            .navbar-nav .nav-item.active .nav-link, 
            .navbar-nav .nav-link:hover {
                color: #818cf8;
            }
        }
        
        /* أزرار */
        .btn-primary, .btn-outline-primary:hover {
            background-color: #1a237e;
            border-color: #1a237e;
        }
        
        .btn-outline-primary {
            color: #1a237e;
            border-color: #1a237e;
        }
        
        /* السمة العامة للتطبيق */
        .text-primary {
            color: #1a237e !important;
        }
        
        @media (prefers-color-scheme: dark) {
            .text-primary {
                color: #818cf8 !important;
            }
        }
        
        /* تأثيرات التمرير */
        .reveal {
            position: relative;
            transform: translateY(50px);
            opacity: 0;
            transition: all 1s ease;
        }
        
        .reveal.active {
            transform: translateY(0);
            opacity: 1;
        }
        
        /* الاحتواء السريع */
        .quick-stats {
            padding: 3rem 0;
            background-color: var(--card-bg);
            border-top: 1px solid var(--card-border);
            border-bottom: 1px solid var(--card-border);
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a237e;
            margin-bottom: 0.5rem;
            line-height: 1;
        }
        
        @media (prefers-color-scheme: dark) {
            .stat-number {
                color: #818cf8;
            }
        }
        
        .stat-text {
            font-size: 1rem;
            color: var(--text-color);
        }
        
        /* تنسيقات الاستجابة */
        @media (max-width: 768px) {
            .hero-section, .carousel-item {
                height: auto;
                min-height: 500px;
            }
            
            .carousel-caption {
                padding: 0 5%;
            }
            
            .carousel-caption h1 {
                font-size: 1.8rem;
            }
            
            .stat-number {
                font-size: 2rem;
            }
        }
        
        /* زر العودة لأعلى */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #1a237e;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: opacity 0.3s, visibility 0.3s;
            opacity: 0;
            visibility: hidden;
            z-index: 1000;
        }
        
        @media (prefers-color-scheme: dark) {
            .back-to-top {
                background: #4f46e5;
            }
        }
        
        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }
        
        .back-to-top:hover {
            background: #0e1442;
            color: white;
        }
        
        /* معالجة مشكلة التنقل بين الصفحات في الوضع الداكن */
        .navbar-light .navbar-brand,
        .navbar-light .navbar-nav .nav-link {
            color: var(--text-color);
        }
        
        .navbar-light .navbar-toggler-icon {
            filter: invert(0);
        }
        
        @media (prefers-color-scheme: dark) {
            .navbar-light .navbar-toggler-icon {
                filter: invert(1);
            }
        }
    </style>
    
    <!-- Dark mode toggle script -->
    <script>
        // تحقق من الوضع المحفوظ
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body>
    <!-- شريط التنقل -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">منصة التطوع</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">الرئيسية</a>
                    </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('ads.index') }}">الحملات التطوعية</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('job-offers.index') }}">فرص التطوع</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('organizations.index') }}">المنظمات</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('map') }}">خريطة المواقع</a>
                        </li>
                </ul>
                
                <div>
                    @auth
                        <div class="d-flex align-items-center">
                            <span class="text-light me-3">مرحباً {{ Auth::user()->name }}</span>
                            <div class="dropdown">
                                <button class="btn btn-outline-light dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-1"></i> حسابي
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>لوحة التحكم</a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-edit me-2"></i>الملف الشخصي</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="dropdown-item p-0">
                                            @csrf
                                            <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light me-2">تسجيل الدخول</a>
                        <a href="{{ route('register') }}" class="btn btn-light">إنشاء حساب</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- شرائح العرض (Carousel) -->
    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('{{ asset('images/sliders/Volunteering-platform.jpg') }}')">
                <div class="carousel-overlay">
                    <div class="carousel-caption">
                        <h1 class="display-4 fw-bold">منصة التطوع الأولى في سوريا</h1>
                        <p class="lead">انضم إلينا وكن جزءًا من التغيير الإيجابي في المجتمع السوري</p>
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg mt-3">لوحة التحكم</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg mt-3">ابدأ الآن</a>
                        @endauth
                    </div>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('{{ asset('images/sliders/bac-g-imge-welcome.jpg') }}')">
                <div class="carousel-overlay">
                    <div class="carousel-caption">
                        <h1 class="display-4 fw-bold">ساعد في إعادة إعمار سوريا</h1>
                        <p class="lead">انضم إلى حملات التطوع لمساعدة المتضررين وإعادة بناء المجتمع</p>
                        @auth
                            <a href="{{ route('ads.index') }}" class="btn btn-primary btn-lg mt-3">استعرض الحملات</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg mt-3">سجل للمساعدة</a>
                        @endauth
                    </div>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('{{ asset('images/sliders/an-opportunity.jpg') }}')">
                <div class="carousel-overlay">
                    <div class="carousel-caption">
                        <h1 class="display-4 fw-bold">فرص تطوع متاحة</h1>
                        <p class="lead">ساهم بوقتك ومهاراتك في المشاريع التي تناسب اهتماماتك</p>
                        @auth
                            <a href="{{ route('job-offers.index') }}" class="btn btn-primary btn-lg mt-3">استعرض الفرص</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-3">سجل دخول للتطوع</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- قسم الإحصائيات -->
    <section class="bg-pattern py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <i class="fas fa-hands-helping text-primary mb-3 fa-3x"></i>
                        <h2 class="mb-0 fw-bold text-primary">{{ $stats['activeUsersCount'] }}</h2>
                        <p class="text-muted">متطوع نشط</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <i class="fas fa-bullhorn text-primary mb-3 fa-3x"></i>
                        <h2 class="mb-0 fw-bold text-primary">{{ $stats['campaignsCount'] }}</h2>
                        <p class="text-muted">حملة تطوعية</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <i class="fas fa-donate text-primary mb-3 fa-3x"></i>
                        <h2 class="mb-0 fw-bold text-primary">{{ number_format($stats['totalDonations']) }}</h2>
                        <p class="text-muted">ليرة سورية</p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <i class="fas fa-map-marked-alt text-primary mb-3 fa-3x"></i>
                        <h2 class="mb-0 fw-bold text-primary">{{ $stats['citiesCount'] }}</h2>
                        <p class="text-muted">محافظة</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- قسم الميزات -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center section-title">مميزات المنصة</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <img src="{{ asset('images/syria/Donate-easily.png') }}" class="card-img-top" alt="ميزة التبرع">
                        <div class="card-body text-center">
                            <div class="feature-icon">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                            <h4 class="card-title mb-3">تبرع بسهولة</h4>
                            <p class="card-text">قدم تبرعاتك بطرق دفع آمنة ومتنوعة، وتابع تأثير تبرعك على المستفيدين.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <img src="{{ asset('images/syria/Participate-as-a-volunteer.jpg') }}" class="card-img-top" alt="ميزة التطوع">
                        <div class="card-body text-center">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4 class="card-title mb-3">شارك كمتطوع</h4>
                            <p class="card-text">ابحث عن فرص التطوع المناسبة لمهاراتك ووقتك، وكن جزءًا من العمل المجتمعي.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <img src="{{ asset('images/syria/Earn-points-and-badges.jpg') }}" class="card-img-top" alt="ميزة المكافآت">
                        <div class="card-body text-center">
                            <div class="feature-icon">
                                <i class="fas fa-award"></i>
                            </div>
                            <h4 class="card-title mb-3">اكسب النقاط والشارات</h4>
                            <p class="card-text">احصل على نقاط مقابل نشاطاتك التطوعية وتبرعاتك، واجمع شارات مميزة تعكس مساهماتك.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- شريط الخدمات -->
    <section class="services-strip">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3">
                    <i class="fas fa-heartbeat service-icon"></i>
                    <h5>حملات صحية</h5>
                </div>
                <div class="col-md-3">
                    <i class="fas fa-graduation-cap service-icon"></i>
                    <h5>حملات تعليمية</h5>
                </div>
                <div class="col-md-3">
                    <i class="fas fa-home service-icon"></i>
                    <h5>إعادة إعمار</h5>
                </div>
                <div class="col-md-3">
                    <i class="fas fa-seedling service-icon"></i>
                    <h5>مشاريع بيئية</h5>
                </div>
            </div>
        </div>
    </section>

    <!-- قسم الحملات المميزة -->
    <section class="py-5 bg-pattern">
        <div class="container">
            <h2 class="text-center section-title">حملات مميزة</h2>
            <div class="row g-4">
                @foreach($featuredCampaigns as $campaign)
                <div class="col-md-4">
                    <div class="card campaign-card h-100">
                        <img src="{{ $campaign->image_url }}" class="card-img-top campaign-image" alt="{{ $campaign->title }}">
                        <div class="card-body">
                            <h5 class="card-title mb-3">{{ $campaign->title }}</h5>
                            <p class="card-text mb-3">{{ Str::limit($campaign->description, 100) }}</p>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>{{ number_format($campaign->current_amount) }} ل.س</span>
                                    <span>{{ $campaign->goal_amount > 0 ? round(($campaign->current_amount / $campaign->goal_amount) * 100) : 0 }}%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width:{{ $campaign->goal_amount > 0 ? min(100, round(($campaign->current_amount / $campaign->goal_amount) * 100)) : 0 }}%"></div>
                                </div>
                                <div class="text-muted small mt-1">
                                    <span>من أصل {{ number_format($campaign->goal_amount) }} ل.س</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <a href="{{ route('ads.show', $campaign->id) }}" class="btn btn-primary d-block">المزيد من التفاصيل</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('ads.index') }}" class="btn btn-outline-primary btn-lg">استعراض جميع الحملات</a>
            </div>
        </div>
    </section>

    <!-- قسم تسجيل النشرة البريدية -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-8">
                    <h2 class="section-title">ابق على اطلاع</h2>
                    <p class="mb-4">اشترك في نشرتنا البريدية للحصول على آخر أخبار الحملات والمشاريع التطوعية</p>
                    
                    @if(session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($errors->has('email'))
                        <div class="alert alert-danger mb-4">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <form action="{{ route('newsletter.subscribe') }}" method="POST">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="البريد الإلكتروني" required value="{{ old('email') }}">
                                    <button class="btn btn-primary" type="submit">اشتراك</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- قسم فرص التطوع -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center section-title">فرص تطوع متاحة</h2>
            <div class="row text-center mb-5">
                <div class="col-md-8 mx-auto">
                    <p class="lead">تصفح فرص التطوع المتاحة والتي تناسب مهاراتك واهتماماتك</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row g-4">
                        @forelse($jobOffers as $offer)
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ $offer->image_url }}" class="card-img-top campaign-image" alt="{{ $offer->title }}" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">{{ $offer->title }}</h5>
                                    <p class="mb-2">
                                        <i class="fas fa-calendar-alt me-2 text-muted"></i> 
                                        {{ $offer->start_date ? $offer->start_date->format('Y-m-d') : 'غير محدد' }} - 
                                        {{ $offer->deadline ? $offer->deadline->format('Y-m-d') : 'غير محدد' }}
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-map-marker-alt me-2 text-muted"></i> 
                                        {{ $offer->city ? $offer->city->name : 'غير محدد' }}
                                    </p>
                                    <div class="mb-2">
                                        <span class="badge bg-primary">{{ $offer->organization->name }}</span>
                                    </div>
                                    <p class="card-text">{{ Str::limit($offer->description, 100) }}</p>
                                    <a href="{{ route('job-offers.show', $offer->id) }}" class="btn btn-outline-primary mt-2">التفاصيل والتقديم</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center">
                            <div class="alert alert-info">
                                لا توجد فرص تطوع متاحة حالياً، الرجاء المحاولة لاحقاً.
                            </div>
                        </div>
                        @endforelse
                    </div>
                    <div class="text-center mt-5">
                        <a href="{{ route('job-offers.index') }}" class="btn btn-primary">عرض جميع فرص التطوع</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- قسم الخريطة -->
    <section class="py-5 bg-pattern">
        <div class="container">
            <h2 class="text-center section-title">خريطة المواقع</h2>
            <div class="row text-center mb-5">
                <div class="col-md-8 mx-auto">
                    <p class="lead">استعرض الحملات والمنظمات على الخريطة للعثور على فرص تطوع قريبة منك</p>
                    <a href="{{ route('map') }}" class="btn btn-primary mt-3">استعرض الخريطة الكاملة</a>
                </div>
            </div>
        </div>
    </section>

    <!-- قسم الشركاء والداعمين -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center section-title">شركاؤنا</h2>
            <div class="row justify-content-center align-items-center mt-5">
                <div class="col-6 col-md-2 mb-4 text-center">
                    <a href="https://www.unicef.org/ar" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('images/partners/unicef.svg') }}" alt="اليونيسف" class="img-fluid" style="max-height: 80px;">
                    </a>
                </div>
                <div class="col-6 col-md-2 mb-4 text-center">
                    <a href="https://www.unhcr.org/ar/" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('images/partners/unhcr.svg') }}" alt="مفوضية الأمم المتحدة لشؤون اللاجئين" class="img-fluid" style="max-height: 80px;">
                    </a>
                </div>
                <div class="col-6 col-md-2 mb-4 text-center">
                    <a href="https://sarc.sy/ar/" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('images/partners/syrian-red-crescent.svg') }}" alt="الهلال الأحمر السوري" class="img-fluid" style="max-height: 80px;">
                    </a>
                </div>
                <div class="col-6 col-md-2 mb-4 text-center">
                    <a href="https://www.undp.org/ar/syria" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('images/partners/undp.svg') }}" alt="برنامج الأمم المتحدة الإنمائي" class="img-fluid" style="max-height: 80px;">
                    </a>
                </div>
                <div class="col-6 col-md-2 mb-4 text-center">
                    <a href="https://www.wfp.org/ar" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('images/partners/wfp.svg') }}" alt="برنامج الغذاء العالمي" class="img-fluid" style="max-height: 80px;">
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- تذييل الصفحة -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5>منصة التطوع</h5>
                    <p>منصة متكاملة للحملات التطوعية والتبرعات في سوريا، نهدف إلى بناء مجتمع متكاتف وداعم.</p>
                    <div class="mt-3">
                        <a href="#" class="me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>روابط سريعة</h5>
                    <ul>
                        <li><a href="/">الرئيسية</a></li>
                        <li><a href="{{ route('ads.index') }}">الحملات التطوعية</a></li>
                        <li><a href="{{ route('job-offers.index') }}">فرص التطوع</a></li>
                        <li><a href="{{ route('organizations.index') }}">المنظمات</a></li>
                        <li><a href="{{ route('map') }}">خريطة المواقع</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>المنصة</h5>
                    <ul>
                        <li><a href="{{ route('login') }}">تسجيل الدخول</a></li>
                        <li><a href="{{ route('register') }}">إنشاء حساب</a></li>
                        <li><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>المساعدة والدعم</h5>
                    <ul>
                        <li><a href="{{ route('support.faq') }}">الأسئلة الشائعة</a></li>
                        <li><a href="{{ route('support.terms') }}">شروط الاستخدام</a></li>
                        <li><a href="{{ route('support.privacy') }}">سياسة الخصوصية</a></li>
                        <li><a href="{{ route('support.technical') }}">الدعم الفني</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-secondary">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} منصة التطوع. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



