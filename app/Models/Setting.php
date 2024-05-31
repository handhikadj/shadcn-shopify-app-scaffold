<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function setValue(string $key, $value)
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);

        return self::getValue($key);
    }

    public static function getValue(string $key, $default = null)
    {
        return self::where('key', $key)?->first()?->value ?? $default;
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => unserialize($value),
            set: fn ($value) => serialize($value),
        );
    }
}
