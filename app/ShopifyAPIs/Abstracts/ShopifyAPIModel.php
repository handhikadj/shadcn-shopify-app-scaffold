<?php

namespace App\ShopifyAPIs\Abstracts;

use Arr;
use Str;
use ReflectionClass;
use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;

abstract class ShopifyAPIModel implements Arrayable
{
    public array $original = [];

    public string $id; // gid://shopify/Product/8682722918711
    public string $gid; // gid://shopify/Product/8682722918711
    public int $resource_id; // the last part of the id: 8682722918711

    public function __construct(public ?User $user = null)
    {
        $this->user = $user ?? auth()->user();
    }

    public function setAttributes(?array $attributes): self
    {
        if (!$attributes) return clone $this;

        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
            $this->original[$key] = $value;
        }

        $this->gid = $this->id;
        $this->original['gid'] = $this->id;

        $this->resource_id = (int) Str::getShopifyGqlResourceId($this->id);
        $this->original['resource_id'] = $this->resource_id;

        return clone $this;
    }

    public function hasAttributes(): bool
    {
        return !empty($this->original);
    }

    public function isEmpty(): bool
    {
        return empty($this->original);
    }

    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    public function toArray(): array
    {
        return $this->original;
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
