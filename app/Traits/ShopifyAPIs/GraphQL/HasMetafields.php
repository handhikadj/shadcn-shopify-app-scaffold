<?php

namespace App\Traits\ShopifyAPIs\GraphQL;

trait HasMetafields
{
    public function getMetafieldId($key)
    {
        $metafieldNodes = data_get($this, 'metafields.nodes', []);

        if (!$metafieldNodes) {
            return null;
        }

        $metafield = collect($metafieldNodes)->firstWhere('key', $key);

        return data_get($metafield, 'id');
    }

    public function getMetafieldValue($key)
    {
        $metafieldNodes = data_get($this, 'metafields.nodes', []);

        if (!$metafieldNodes) {
            return null;
        }

        $metafield = collect($metafieldNodes)->firstWhere('key', $key);

        return data_get($metafield, 'value');
    }

    public function hasMetafield($key): bool
    {
        $metafieldNodes = data_get($this, 'metafields.nodes', []);

        if (!$metafieldNodes) {
            return false;
        }

        return collect($metafieldNodes)->contains('key', $key);
    }
}
