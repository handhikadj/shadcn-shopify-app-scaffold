<?php

namespace App\ShopifyAPIs\GraphQL\ProductVariant\Traits;

trait ProductVariantGetters
{
    public function getInventoryItemId(): string|int|null
    {
        return data_get($this->inventoryItem, 'id');
    }

    public function getAvailableQuantity(): int
    {
        return (int) data_get($this->inventoryItem, 'inventoryLevel.quantities.0.quantity', 0);
    }
}
