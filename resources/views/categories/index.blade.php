@extends('layouts.app')

@section('content')
<div class="container py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">لیست دسته‌بندی‌ها</h1>
        <a href="{{ route('categories.create') }}" class="bg-primary text-white px-4 py-2 rounded shadow">افزودن دسته‌بندی</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-right">#</th>
                    <th class="px-4 py-2 text-right">نام دسته</th>
                    <th class="px-4 py-2 text-right">کد</th>
                    <th class="px-4 py-2 text-right">دسته والد</th>
                    <th class="px-4 py-2 text-right">تصویر</th>
                    <th class="px-4 py-2 text-right">توضیحات</th>
                    <th class="px-4 py-2 text-right">تاریخ ایجاد</th>
                    <th class="px-4 py-2 text-right">عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $cat->title }}</td>
                        <td class="px-4 py-2">{{ $cat->code }}</td>
                        <td class="px-4 py-2">{{ $cat->parent ? $cat->parent->title : '-' }}</td>
                        <td class="px-4 py-2">
                            @if($cat->image)
                                <img src="{{ asset('storage/'.$cat->image) }}" class="w-12 h-12 object-cover rounded" alt="تصویر">
                            @else
                                <span class="text-gray-300">---</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ \Illuminate\Support\Str::limit($cat->description, 50) }}</td>
                        <td class="px-4 py-2">{{ \Morilog\Jalali\Jalalian::forge($cat->created_at)->format('Y/m/d H:i') }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('categories.edit', $cat) }}" class="text-blue-600 hover:underline">ویرایش</a>
                            <form action="{{ route('categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('حذف شود؟')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-gray-400 py-6">دسته‌بندی‌ای وجود ندارد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</div>
@endsection
