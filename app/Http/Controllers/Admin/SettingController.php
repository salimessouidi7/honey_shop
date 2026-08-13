<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;

class SettingController extends Controller
{
    public function index()
    {
        $features = Feature::orderBy('name')->get();
        return view('admin.settings.index', compact('features'));
    }

    public function toggle(Feature $feature)
    {
        $feature->update(['enabled' => !$feature->enabled]);

        $status = $feature->enabled ? 'enabled' : 'disabled';
        return back()->with('success', "{$feature->name} {$status}.");
    }
}
