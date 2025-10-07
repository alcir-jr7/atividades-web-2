<?php

namespace App\Http\Controllers;

use App\Models\Motorcycle;
use Illuminate\Http\Request;

class MotorcycleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motorcycles = Motorcycle::all();
        return view('motorcycles.index', compact('motorcycles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('motorcycles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['has_abs'] = $request->has('has_abs'); // checkbox precisa de conversão
        Motorcycle::create($data);

        return redirect()->route('motorcycles.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Motorcycle $motorcycle)
    {
        return view('motorcycles.show', compact('motorcycle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Motorcycle $motorcycle)
    {
        return view('motorcycles.edit', compact('motorcycle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Motorcycle $motorcycle)
    {
        $data = $request->all();
        $data['has_abs'] = $request->has('has_abs'); // checkbox
        $motorcycle->update($data);

        return redirect()->route('motorcycles.index')->with('success', 'Motorcycle updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Motorcycle $motorcycle)
    {
        $motorcycle->delete();
        return redirect()->route('motorcycles.index')->with('success', 'Motorcycle deleted successfully.');
    }
}
