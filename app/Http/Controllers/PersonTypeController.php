<?php

namespace App\Http\Controllers;

use App\Models\PersonType;
use Illuminate\Http\Request;

class PersonTypeController extends Controller
{
    public function index()
    {
        return response()->json(PersonType::all());
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|unique:person_types,title']);
        $type = PersonType::create(['title' => $request->title]);
        return response()->json($type, 201);
    }

    public function update(Request $request, PersonType $personType)
    {
        $request->validate(['title' => 'required|string|unique:person_types,title,' . $personType->id]);
        $personType->update(['title' => $request->title]);
        return response()->json($personType);
    }

    public function destroy(PersonType $personType)
    {
        $personType->delete();
        return response()->json(['success' => true]);
    }
}
