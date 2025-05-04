<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryOption;

class CategoryOptionController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');
        return response()->json(
            CategoryOption::where('type', $type)->orderBy('id')->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate(['type'=>'required','title'=>'required|max:100']);
        $option = CategoryOption::create($request->only('type','title'));
        return response()->json($option);
    }

    public function update(Request $request, $id)
    {
        $option = CategoryOption::findOrFail($id);
        $request->validate(['title'=>'required|max:100']);
        $option->update(['title' => $request->title]);
        return response()->json($option);
    }

    public function destroy($id)
    {
        $option = CategoryOption::findOrFail($id);
        $option->delete();
        return response()->json(['success'=>true]);
    }
}
