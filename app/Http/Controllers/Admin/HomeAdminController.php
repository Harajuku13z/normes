<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Support\HomePageDefaults;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeAdminController extends Controller
{
    public function index(): View
    {
        $keys = HomePageDefaults::keys();
        $labels = HomePageDefaults::labels();
        $saved = HomeSection::query()->pluck('updated_at', 'key');

        return view('admin.sections.index', compact('keys', 'labels', 'saved'));
    }

    public function edit(string $key): View
    {
        $defaults = HomePageDefaults::all();
        abort_unless(array_key_exists($key, $defaults), 404);

        $base = $defaults[$key];
        $row = HomeSection::query()->where('key', $key)->first();
        $merged = $row && is_array($row->payload)
            ? array_replace_recursive($base, $row->payload)
            : $base;

        $json = json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            $json = '{}';
        }

        return view('admin.sections.edit', [
            'key' => $key,
            'label' => HomePageDefaults::label($key),
            'payloadJson' => $json,
        ]);
    }

    public function update(Request $request, string $key): RedirectResponse
    {
        $defaults = HomePageDefaults::all();
        abort_unless(array_key_exists($key, $defaults), 404);

        $request->validate([
            'payload' => ['required', 'string'],
        ]);

        $decoded = json_decode($request->string('payload')->toString(), true);
        if (! is_array($decoded)) {
            return back()->withErrors(['payload' => 'JSON invalide. Vérifiez la syntaxe.'])->withInput();
        }

        HomeSection::query()->updateOrCreate(
            ['key' => $key],
            ['payload' => $decoded]
        );

        return redirect()->route('admin.section.edit', $key)->with('status', 'Section enregistrée.');
    }
}
