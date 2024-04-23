<?php

namespace App\ShopifyAPIs\GraphQL\Inventory;

use Str;
use Log;
use App\Models\User;
use App\Traits\ShopifyAPIs\ClassInstantiator;
use App\ShopifyAPIs\Abstracts\ShopifyAPIModel;
use App\Traits\ShopifyAPIs\GraphQL\HasGraphQLRequest;

class Inventory extends ShopifyAPIModel
{
    use ClassInstantiator, HasGraphQLRequest;

    // public function __construct(private ?User $user = null)
    // {
    //     $this->user = $user ?? auth()->user();
    // }

    public function bulkToggleActivation(string $inventoryItemId, array $inventoryItemUpdates): Inventory
    {
        $variables = [
            'inventoryItemId' => $inventoryItemId,
            'inventoryItemUpdates' => $inventoryItemUpdates
        ];

        $response = $this->graphQlRequest(Schema::bulkToggleActivation(), $variables);

        return $this->setAttributes($response['inventoryBulkToggleActivation']['inventoryItem']);
    }

    public function adjustQuantities(array $data)
    {
        $this->graphQlRequest(Schema::adjustQuantities(), [
            'input' => $data
        ]);
    }

    public function setOnHandQuantities(array $data): Inventory
    {
        $response = $this->graphQlRequest(Schema::setOnHandQuantities(), [
            'input' => $data
        ]);

        return $this->setAttributes($response['inventorySetOnHandQuantities']['inventoryAdjustmentGroup']);
    }
}
