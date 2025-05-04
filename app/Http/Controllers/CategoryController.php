<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function create()
    {
        $personCategories = Category::where('type', 'person')->orderBy('title')->get(['id', 'title']);
        $productCategories = Category::where('type', 'product')->orderBy('title')->get(['id', 'title']);
        $serviceCategories = Category::where('type', 'service')->orderBy('title')->get(['id', 'title']);

        // آرایه انواع شخص و واحدها
        $personTypes = ['مشتری', 'تأمین‌کننده', 'کارمند', 'سهامدار', 'سایر'];
        $units = ['عدد', 'کیلوگرم', 'متر', 'لیتر', 'بسته', 'سایر'];

        return view('categories.create', compact(
            'personCategories',
            'productCategories',
            'serviceCategories',
            'personTypes',
            'units'
        ));
    }

    public function store(Request $request)
    {
        // تعیین نوع دسته‌بندی از route یا فرم
        $type = $request->input('type', $request->route('type', 'person'));
        // اعتبارسنجی
        $rules = [
            'title' => 'required|string|max:100',
            'code' => 'required|string|max:24|unique:categories,code',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
            'active' => 'nullable|boolean',
        ];

        // اعتبارسنجی فیلدهای اختصاصی هر نوع
        if ($type === 'person') {
            $rules['person_type'] = 'nullable|string|max:100';
        }
        if ($type === 'product') {
            $rules['unit'] = 'nullable|string|max:100';
            $rules['tax'] = 'nullable|numeric|min:0|max:100';
        }
        if ($type === 'service') {
            $rules['service_type'] = 'nullable|string|max:100';
            $rules['base_rate'] = 'nullable|numeric|min:0';
            $rules['tax'] = 'nullable|numeric|min:0|max:100';
        }

        $validated = $request->validate($rules);

        // ذخیره تصویر اگر وجود داشته باشد
        $imgPath = null;
        if ($request->hasFile('image')) {
            $imgPath = $request->file('image')->store('categories', 'public');
        }

        // ساخت داده برای ذخیره
        $data = [
            'title' => $validated['title'],
            'code' => $validated['code'],
            'type' => $type,
            'parent_id' => $validated['parent_id'] ?? null,
            'description' => $validated['description'] ?? null,
            'image' => $imgPath,
            'active' => $request->has('active') ? 1 : 0,
        ];

        // فیلدهای اختصاصی هر نوع
        if ($type === 'person') {
            $data['person_type'] = $validated['person_type'] ?? null;
        }
        if ($type === 'product') {
            $data['unit'] = $validated['unit'] ?? null;
            $data['tax'] = $validated['tax'] ?? null;
        }
        if ($type === 'service') {
            $data['service_type'] = $validated['service_type'] ?? null;
            $data['base_rate'] = $validated['base_rate'] ?? null;
            $data['tax'] = $validated['tax'] ?? null;
        }

        $cat = Category::create($data);

        return redirect()->back()->with('success', 'دسته‌بندی با موفقیت ثبت شد.');
    }

    public function ajaxSearch(Request $request)
    {
        $q = $request->input('q');
        if (!$q) {
            $popular = Category::withCount('persons')
                ->orderByDesc('persons_count')
                ->limit(5)
                ->get(['id', 'title']);
            if ($popular->count() < 5) {
                $recent = Category::orderByDesc('created_at')->limit(5 - $popular->count())->get(['id','title']);
                $cats = $popular->concat($recent)->unique('id')->values();
            } else {
                $cats = $popular;
            }
        } else {
            $cats = Category::where('title', 'like', "%{$q}%")
                ->orderByDesc('created_at')
                ->limit(8)
                ->get(['id','title']);
        }
        return response()->json($cats);
    }

    public function ajaxCreate(Request $request)
    {
        $request->validate(['title'=>'required|string|max:100']);
        $cat = Category::create(['title'=>$request->title]);
        return response()->json(['id'=>$cat->id, 'title'=>$cat->title]);
    }
}
