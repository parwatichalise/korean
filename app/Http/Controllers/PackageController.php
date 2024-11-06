<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;


class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::paginate(10);
        return view('teacher.create.package', compact('packages'));
    }

    public function create()
    {
        $packages = Package::paginate(10);        
        return view('teacher.create.package', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric',
        ]);

        Package::create($request->only('name', 'price'));

        return redirect()->route('packages.index')->with('success', 'Package added successfully.');
    }

    public function edit(Package $package)
    {
        return view('teacher.create.package', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric',
        ]);

        $package->update($request->only('name', 'price'));

        return redirect()->route('packages.index')->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('packages.index')->with('success', 'Package deleted successfully.');
    }
}