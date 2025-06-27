<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jobsheet;
use Illuminate\Http\Request;

class JobsheetController extends Controller
{
    public function index()
    {
        $items = Jobsheet::latest()->get();
        return view('admin.jobsheet.index', compact('items'));
    }

    public function create()
    {
        return view('admin.jobsheet.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required|integer',
        ]);

        Jobsheet::create($request->all());
        return redirect()->route('admin.jobsheet.index')->with('success', 'Jobsheet created.');
    }

    public function edit(Jobsheet $jobsheet)
    {
        return view('admin.jobsheet.edit', compact('jobsheet'));
    }

    public function update(Request $request, Jobsheet $jobsheet)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required|integer',
        ]);

        $jobsheet->update($request->all());
        return redirect()->route('admin.jobsheet.index')->with('success', 'Jobsheet updated.');
    }

    public function destroy(Jobsheet $jobsheet)
    {
        $jobsheet->delete();
        return redirect()->route('admin.jobsheet.index')->with('success', 'Deleted.');
    }
}
