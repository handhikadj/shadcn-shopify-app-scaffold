<?php

namespace App\ShopifyAPIs\REST\Abstracts;

use Arr;
use ReflectionClass;
use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use App\Traits\ShopifyAPIs\REST\HasRESTRequest;

abstract class RESTModel implements Arrayable
{
    public array $original = [];

    public function __construct(public ?User $user = null)
    {
        $this->user = $user ?? auth()->user();
    }

    public function setAttributes(?array $attributes): self
    {
        if (!$attributes) {
            return clone $this;
        }

        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
            $this->original[$key] = $value;
        }

        return clone $this;
    }

    public function toArray(): array
    {
        return Arr::except(get_object_vars($this), ['user']);
    }

    public function getResourceName(): string
    {
        $name = (new ReflectionClass($this))->getShortName() . 's';
        return strtolower($name);
    }

    public function getSingularResourceName(): string
    {
        $name = (new ReflectionClass($this))->getShortName();
        return strtolower($name);
    }
}
