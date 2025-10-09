<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TranslationKey;
use App\Models\Language;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TranslationKeyController extends Controller
{
    public function index(Request $request)
    {
        $languageId = $request->get('language_id');
        $group = $request->get('group');

        // Get all languages for filter dropdown
        $languages = Language::orderBy('is_default', 'desc')
            ->orderBy('order')
            ->get();

        // Default to English if no language selected
        if (!$languageId) {
            $defaultLang = Language::where('is_default', true)->first();
            $languageId = $defaultLang ? $defaultLang->id : $languages->first()->id;
        }

        // Build query
        $query = TranslationKey::where('language_id', $languageId);

        if ($group) {
            $query->where('group', $group);
        }

        $translationKeys = $query->orderBy('group')
            ->orderBy('key')
            ->paginate(50);

        // Get unique groups for filter
        $groups = TranslationKey::where('language_id', $languageId)
            ->distinct()
            ->pluck('group')
            ->sort()
            ->values();

        return Inertia::render('Admin/TranslationKeys/Index', [
            'translationKeys' => $translationKeys,
            'languages' => $languages,
            'groups' => $groups,
            'currentLanguageId' => (int) $languageId,
            'currentGroup' => $group,
        ]);
    }

    public function create(Request $request)
    {
        $languages = Language::orderBy('is_default', 'desc')
            ->orderBy('order')
            ->get();

        $groups = TranslationKey::distinct()
            ->pluck('group')
            ->sort()
            ->values();

        return Inertia::render('Admin/TranslationKeys/Create', [
            'languages' => $languages,
            'groups' => $groups,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255',
            'language_id' => 'required|exists:languages,id',
            'value' => 'required|string',
            'group' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Check if key already exists for this language
        $exists = TranslationKey::where('key', $validated['key'])
            ->where('language_id', $validated['language_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'key' => 'This translation key already exists for the selected language.'
            ]);
        }

        TranslationKey::create($validated);

        return redirect()->route('admin.translation-keys.index')
            ->with('success', 'Translation key created successfully.');
    }

    public function edit(TranslationKey $translationKey)
    {
        $languages = Language::orderBy('is_default', 'desc')
            ->orderBy('order')
            ->get();

        $groups = TranslationKey::distinct()
            ->pluck('group')
            ->sort()
            ->values();

        return Inertia::render('Admin/TranslationKeys/Edit', [
            'translationKey' => $translationKey,
            'languages' => $languages,
            'groups' => $groups,
        ]);
    }

    public function update(Request $request, TranslationKey $translationKey)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255',
            'language_id' => 'required|exists:languages,id',
            'value' => 'required|string',
            'group' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Check if key already exists for this language (excluding current record)
        $exists = TranslationKey::where('key', $validated['key'])
            ->where('language_id', $validated['language_id'])
            ->where('id', '!=', $translationKey->id)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'key' => 'This translation key already exists for the selected language.'
            ]);
        }

        $translationKey->update($validated);

        return redirect()->route('admin.translation-keys.index')
            ->with('success', 'Translation key updated successfully.');
    }

    public function destroy(TranslationKey $translationKey)
    {
        $translationKey->delete();

        return back()->with('success', 'Translation key deleted successfully.');
    }

    /**
     * Copy all translation keys from one language to another
     */
    public function copyToLanguage(Request $request)
    {
        $validated = $request->validate([
            'source_language_id' => 'required|exists:languages,id',
            'target_language_id' => 'required|exists:languages,id|different:source_language_id',
        ]);

        $sourceKeys = TranslationKey::where('language_id', $validated['source_language_id'])->get();

        $created = 0;
        foreach ($sourceKeys as $sourceKey) {
            $exists = TranslationKey::where('key', $sourceKey->key)
                ->where('language_id', $validated['target_language_id'])
                ->exists();

            if (!$exists) {
                TranslationKey::create([
                    'key' => $sourceKey->key,
                    'language_id' => $validated['target_language_id'],
                    'value' => $sourceKey->value, // Copy source value as placeholder
                    'group' => $sourceKey->group,
                    'description' => $sourceKey->description,
                ]);
                $created++;
            }
        }

        return back()->with('success', "Successfully copied {$created} translation keys.");
    }

    /**
     * Bulk update translation keys
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'translations' => 'required|array',
            'translations.*.id' => 'required|exists:translation_keys,id',
            'translations.*.value' => 'required|string',
        ]);

        $updated = 0;
        foreach ($validated['translations'] as $translation) {
            $key = TranslationKey::find($translation['id']);
            if ($key) {
                $key->update(['value' => $translation['value']]);
                $updated++;
            }
        }

        return back()->with('success', "Successfully updated {$updated} translations.");
    }

    /**
     * Get translation data for a specific group and language
     * Returns default language values alongside selected language
     */
    public function getGroupTranslations(Request $request)
    {
        $languageId = $request->get('language_id');
        $group = $request->get('group');

        $defaultLanguage = Language::where('is_default', true)->first();

        // Get default language keys
        $defaultKeys = TranslationKey::where('language_id', $defaultLanguage->id)
            ->where('group', $group)
            ->get()
            ->keyBy('key');

        // Get selected language translations
        $selectedKeys = TranslationKey::where('language_id', $languageId)
            ->where('group', $group)
            ->get()
            ->keyBy('key');

        $result = [];
        foreach ($defaultKeys as $key => $defaultTranslation) {
            $result[] = [
                'key' => $key,
                'default_value' => $defaultTranslation->value,
                'translation' => $selectedKeys->get($key),
                'description' => $defaultTranslation->description,
            ];
        }

        return response()->json($result);
    }
}
