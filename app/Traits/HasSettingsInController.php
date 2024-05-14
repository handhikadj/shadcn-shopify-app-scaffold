<?php

namespace App\Traits;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

trait HasSettingsInController
{
    public function index($type)
    {
        $user = auth()->user();

        return Inertia::render('Settings/' . ucfirst($type), [
            'title' => ucfirst($type) . ' Settings',
            $type . '_settings' => $user->getSetting($type)
        ]);
    }

    public function update(Request $request)
    {
        $this->saveSettings($request);

        return back();
    }

    private function saveSettings(Request $request, ?User $user = null)
    {
        $user = $user ?? auth()->user();

        foreach ($request->all() as $key => $value) {
            $user->setSetting($key, $value);
        }
    }
}
