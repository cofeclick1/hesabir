<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>حسابیر | نرم‌افزار حسابداری ساده</title>
    <link rel="icon" href="/favicon.ico">
    <!-- فونت آنجمن -->
    <link rel="stylesheet" href="fonts/fonts.css">
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                fontFamily: { 'sans': ['AnjomanMax', 'Tahoma', 'sans-serif'] },
                extend: {
                    colors: {
                        primary: '#2563eb', // آبی
                        accent: '#f59e42', // نارنجی
                        background: '#f9fafb',
                        dark: '#18181b',
                    }
                },
            },
            rtl: true,
        }
    </script>
    <style>
        body {
            font-family: 'AnjomanMax', Tahoma, sans-serif !important;
            background: #f9fafb;
        }
        h1, h2, h3 { font-weight: bold; }
        .hero-bg {
            background: linear-gradient(120deg, #2563eb 0%, #f59e42 100%);
            color: #fff;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <!-- هدر -->
    <header class="hero-bg py-8 shadow-lg">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-6">
            <div class="text-3xl md:text-4xl font-extrabold tracking-tight">
                <span class="text-white drop-shadow">حسابیر</span>
                <span class="text-accent ml-2">| نرم‌افزار حسابداری ساده</span>
            </div>
            <nav class="flex gap-4 mt-4 md:mt-0">
                <a href="{{ route('login') }}" class="py-2 px-5 text-lg rounded-lg bg-white text-primary font-semibold shadow hover:bg-accent hover:text-white transition">ورود</a>
                <a href="{{ route('register') }}" class="py-2 px-5 text-lg rounded-lg bg-accent text-white font-semibold shadow hover:bg-white hover:text-accent transition">ثبت نام</a>
            </nav>
        </div>
    </header>

    <!-- محتوای اصلی -->
    <main class="flex-grow flex flex-col items-center justify-center py-16">
        <section class="bg-white rounded-3xl shadow-xl p-8 md:p-16 w-full max-w-3xl text-center mb-10">
            <h1 class="text-4xl md:text-5xl mb-6 text-primary font-black">به حسابیر خوش آمدید!</h1>
            <p class="text-xl text-gray-700 mb-8 leading-relaxed">
                یک نرم‌افزار حسابداری ساده، حرفه‌ای و رایگان برای مدیریت مالی و حساب‌های شخصی یا کسب‌وکار کوچک شما!
                <br>
                <span class="text-accent font-bold">کاملاً فارسی، راست‌چین، با طراحی مدرن و کاربری بسیار آسان</span>
            </p>
            <div class="flex flex-col md:flex-row gap-4 justify-center mt-6">
                <a href="{{ route('register') }}" class="py-3 px-8 bg-primary text-white rounded-xl text-lg font-bold shadow-lg hover:bg-dark transition">شروع رایگان</a>
                <a href="{{ route('login') }}" class="py-3 px-8 bg-white border-2 border-primary text-primary rounded-xl text-lg font-bold shadow-lg hover:bg-primary hover:text-white transition">ورود کاربران</a>
            </div>
        </section>
        <section class="w-full max-w-4xl grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                <svg class="w-12 h-12 mb-3 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8c-1.1 0-2 .9-2 2m0 0v6m2-6c1.1 0 2 .9 2 2m0 0v6m-4 0h4m-2 0v-6"></path>
                </svg>
                <h3 class="text-xl font-bold mb-2 text-primary">مدیریت تراکنش‌ها</h3>
                <p class="text-gray-600 text-center">ثبت و مدیریت درآمدها و هزینه‌ها به سادگی چند کلیک و با رابط کاربری فارسی.</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                <svg class="w-12 h-12 mb-3 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 7v10c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2V7"></path>
                    <path d="M16 3h-8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z"></path>
                </svg>
                <h3 class="text-xl font-bold mb-2 text-accent">گزارش‌های مالی حرفه‌ای</h3>
                <p class="text-gray-600 text-center">مشاهده نمودار و گزارش‌های تحلیلی جذاب با یک کلیک برای تصمیم‌گیری بهتر.</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                <svg class="w-12 h-12 mb-3 text-dark" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3"></path>
                    <circle cx="12" cy="12" r="10"></circle>
                </svg>
                <h3 class="text-xl font-bold mb-2 text-dark">امنیت و سرعت</h3>
                <p class="text-gray-600 text-center">اطلاعات شما کاملاً امن، رمزگذاری شده و با سرعت عالی ذخیره و بازیابی می‌شوند.</p>
            </div>
        </section>
    </main>

    <!-- فوتر -->
    <footer class="text-center py-4 text-gray-500 bg-background border-t mt-12">
        ساخته شده با ❤️ توسط تیم حسابیر - تمامی حقوق محفوظ است © {{ date('Y') }}
    </footer>
</body>
</html>
