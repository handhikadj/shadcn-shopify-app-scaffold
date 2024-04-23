<?php

namespace App\ShopifyAPIs\GraphQL\ProductVariant;

use Str;

class Schema
{
    private static function getInventoryLevelByLocationId(string|int $locationId): string
    {
        $locationId = Str::createShopifyGqlResourceId('Location', $locationId);

        return <<<QUERY
          inventoryLevel(locationId:"$locationId") {
             id
             available
          }
        QUERY;
    }

    public static function getDefault(string|int $productId, string|int|null $locationId = null): string
    {
        $locationQuery = $locationId ? self::getInventoryLevelByLocationId($locationId) : '';

        return <<<QUERY
          query {
            productVariants(first: 1, query: "(product_id:$productId) AND (title:Default*)") {
              edges {
                node {
                  id
                  title
                  inventoryItem {
                    id
                    $locationQuery
                  }
                  inventoryQuantity
                }
              }
            }
          }
        QUERY;
    }

    public static function create(): string
    {
        return <<<'GRAPHQL'
            mutation productVariantCreate($input: ProductVariantInput!) {
              productVariantCreate(input: $input) {
                productVariant {
                  id
                  barcode
                  title
                  price
                  sku
                  position
                  inventoryQuantity
                }
                userErrors {
                  field
                  message
                }
              }
            }
        GRAPHQL;
    }

    public static function update(): string
    {
        return <<<'GRAPHQL'
            mutation productVariantUpdate($input: ProductVariantInput!) {
              productVariantUpdate(input: $input) {
                productVariant {
                  id
                  barcode
                  title
                  price
                  sku
                  position
                  inventoryQuantity
                }
                userErrors {
                  field
                  message
                }
              }
            }
        GRAPHQL;
    }

    public static function delete(): string
    {
        return <<<'GRAPHQL'
          mutation productVariantDelete($id: ID!) {
              productVariantDelete(id: $id) {
                deletedProductVariantId
                userErrors {
                  field
                  message
                }
              }
            }
        GRAPHQL;
    }
}
