<?php

namespace App\ShopifyAPIs\GraphQL\Inventory;

class Schema
{
    public static function bulkToggleActivation(): string
    {
        return <<<'GRAPHQL'
            mutation inventoryBulkToggleActivation($inventoryItemId: ID!, $inventoryItemUpdates: [InventoryBulkToggleActivationInput!]!) {
              inventoryBulkToggleActivation(inventoryItemId: $inventoryItemId, inventoryItemUpdates: $inventoryItemUpdates) {
                inventoryItem {
                  id
                }
                userErrors {
                  field
                  message
                }
              }
            }
        GRAPHQL;
    }

    public static function adjustQuantities(): string
    {
        return <<<'GRAPHQL'
            mutation inventoryAdjustQuantities($input: InventoryAdjustQuantitiesInput!) {
              inventoryAdjustQuantities(input: $input) {
                inventoryAdjustmentGroup {
                  id
                  reason
                }
                userErrors {
                  field
                  message
                }
              }
            }
        GRAPHQL;
    }

    public static function setOnHandQuantities(): string
    {
        return <<<'GRAPHQL'
            mutation inventorySetOnHandQuantities($input: InventorySetOnHandQuantitiesInput!) {
              inventorySetOnHandQuantities(input: $input) {
                inventoryAdjustmentGroup {
                  id
                  reason
                }
                userErrors {
                  field
                  message
                }
              }
            }
        GRAPHQL;
    }
}
