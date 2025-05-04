@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-tr from-primary to-accent py-8">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-8">
        <h2 class="text-3xl font-extrabold text-primary text-center mb-2">ورود به حساب کاربری</h2>
        <p class="text-gray-500 text-center mb-6">لطفا وارد حساب خود شوید</p>
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- ایمیل -->
            <div>
                <label for="email" class="block mb-1 font-bold text-gray-700">ایمیل</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/30 transition text-right" />
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- پسورد -->
            <div>
                <label for="password" class="block mb-1 font-bold text-gray-700">رمز عبور</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/30 transition text-right" />
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- مرا به خاطر بسپار -->
            <div class="flex items-center justify-between mb-3">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded text-primary focus:ring-primary border-gray-300">
                    <span class="mr-2 text-sm text-gray-600">مرا به خاطر بسپار</span>
                </label>
                <a class="text-sm text-primary hover:underline" href="{{ route('password.request') }}">فراموشی رمز عبور؟</a>
            </div>

            <button type="submit"
                class="w-full py-3 bg-primary hover:bg-accent text-white font-bold rounded-lg shadow transition">ورود</button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            حساب کاربری ندارید؟
            <a href="{{ route('register') }}" class="text-accent font-semibold hover:underline">ثبت نام کنید</a>
        </p>
    </div>
</div>
@endsection
