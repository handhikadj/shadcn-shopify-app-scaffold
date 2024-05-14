<?php

namespace App\Traits;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasSettings
{
    public function setting(): HasOne
    {
        return $this->hasOne(Setting::class);
    }

    public function setSetting(string $key, $value)
    {
        $this->setting()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        return $this->getSetting($key);
    }

    public function getSetting(string $key, $default = null)
    {
        return $this->setting()->where('key', $key)?->first()?->value ?? $default;
    }

    public function firstOrNewSetting(string $key, $value)
    {
        $setting = $this->getSetting($key);

        if (!$setting) {
            $setting = $this->setSetting($key, $value);
        }

        return $setting;
    }

    public function deleteSetting(string $key)
    {
        $this->setting()->where('key', $key)->delete();
    }
}
