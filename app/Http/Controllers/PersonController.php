<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Category;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function create()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        // پیدا کردن آخرین کد حسابداری (مثلاً چهار رقمی)
        $last = Person::orderBy('account_code', 'desc')->first();
        $suggestedCode = $last ? str_pad(((int) $last->account_code) + 1, 4, '0', STR_PAD_LEFT) : '0001';
        return view('persons.create', compact('categories', 'suggestedCode'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'account_code' => 'required|string|unique:people,account_code',
            'company' => 'nullable|string',
            'title' => 'nullable|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'nickname' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'type' => 'required|string',
            'credit' => 'nullable|numeric',
            'price_list' => 'nullable|string',
            'tax_type' => 'nullable|string',
            'national_id' => 'nullable|string',
            'economic_code' => 'nullable|string',
            'register_no' => 'nullable|string',
            'branch_code' => 'nullable|string',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'country' => 'nullable|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'phone' => 'nullable|string',
            'mobile' => 'nullable|string',
            'fax' => 'nullable|string',
            'phone1' => 'nullable|string',
            'phone2' => 'nullable|string',
            'phone3' => 'nullable|string',
            'email' => 'nullable|string',
            'website' => 'nullable|string',
            'birthday' => 'nullable|date',
            'marriage_date' => 'nullable|date',
            'join_date' => 'nullable|date',
            'avatar' => 'nullable|image|max:2048',
            'banks' => 'nullable|array',
            'banks.*.bank' => 'nullable|string',
            'banks.*.account' => 'nullable|string',
            'banks.*.card' => 'nullable|string',
            'banks.*.sheba' => 'nullable|string',
        ]);

        // ذخیره تصویر
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $person = Person::create($data);

        // ذخیره حساب های بانکی
        if ($request->banks) {
            foreach ($request->banks as $bank) {
                if (!empty(array_filter($bank))) {
                    $person->banks()->create($bank);
                }
            }
        }

        return redirect()->route('persons.create')->with('success', 'شخص با موفقیت ثبت شد.');
    }

    // route AJAX: دریافت آخرین کد حسابداری
    public function latestCode()
    {
        $last = Person::orderBy('account_code', 'desc')->first();
        $code = $last ? $last->account_code : '0000';
        return response()->json(['code' => $code]);
    }

    // route AJAX: افزودن دسته‌بندی
    public function addCategory(Request $request)
    {
        $title = $request->input('title');
        if (!$title) return response()->json(['success' => false]);

        $cat = Category::create(['title' => $title]);
        return response()->json(['success' => true, 'category' => $cat]);
    }
}
