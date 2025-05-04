@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-tr from-primary to-accent py-8">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-8">
        <h2 class="text-3xl font-extrabold text-accent text-center mb-2">ثبت نام در حسابیر</h2>
        <p class="text-gray-500 text-center mb-6">فرم ثبت نام زیر را تکمیل کنید</p>
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- نام و نام خانوادگی -->
            <div>
                <label for="name" class="block mb-1 font-bold text-gray-700">نام و نام خانوادگی</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-accent focus:ring-2 focus:ring-accent/30 transition text-right" />
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- ایمیل -->
            <div>
                <label for="email" class="block mb-1 font-bold text-gray-700">ایمیل</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-accent focus:ring-2 focus:ring-accent/30 transition text-right" />
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- پسورد -->
            <div>
                <label for="password" class="block mb-1 font-bold text-gray-700">رمز عبور</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-accent focus:ring-2 focus:ring-accent/30 transition text-right" />
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- تایید پسورد -->
            <div>
                <label for="password_confirmation" class="block mb-1 font-bold text-gray-700">تکرار رمز عبور</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-accent focus:ring-2 focus:ring-accent/30 transition text-right" />
            </div>

            <button type="submit"
                class="w-full py-3 bg-accent hover:bg-primary text-white font-bold rounded-lg shadow transition">ثبت نام</button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            قبلاً ثبت‌نام کردید؟
            <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">وارد شوید</a>
        </p>
    </div>
</div>
@endsection
