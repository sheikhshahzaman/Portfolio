<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::orderBy('order')->get();

        return Inertia::render('Admin/Languages/Index', [
            'languages' => $languages,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Languages/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:languages,code',
            'name' => 'required|string|max:100',
            'native_name' => 'required|string|max:100',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        // If setting as default, unset other defaults
        if ($request->is_default) {
            Language::where('is_default', true)->update(['is_default' => false]);
        }

        Language::create($validated);

        return redirect()->route('admin.languages.index')
            ->with('success', 'Language created successfully.');
    }

    public function edit(Language $language)
    {
        return Inertia::render('Admin/Languages/Edit', [
            'language' => $language,
        ]);
    }

    public function update(Request $request, Language $language)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:languages,code,' . $language->id,
            'name' => 'required|string|max:100',
            'native_name' => 'required|string|max:100',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        // If setting as default, unset other defaults
        if ($request->is_default && !$language->is_default) {
            Language::where('is_default', true)->update(['is_default' => false]);
        }

        $language->update($validated);

        return redirect()->route('admin.languages.index')
            ->with('success', 'Language updated successfully.');
    }

    public function destroy(Language $language)
    {
        // Prevent deleting default language
        if ($language->is_default) {
            return back()->with('error', 'Cannot delete the default language.');
        }

        $language->delete();

        return redirect()->route('admin.languages.index')
            ->with('success', 'Language deleted successfully.');
    }
}
