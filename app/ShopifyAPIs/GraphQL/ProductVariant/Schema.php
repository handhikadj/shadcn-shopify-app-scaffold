<?php

namespace App\ShopifyAPIs\GraphQL\ProductVariant;

use Str;
use App\ShopifyAPIs\GraphQL\Product\Schema as ProductSchema;

class Schema
{
    public static function responseFields(): string
    {
        return <<<GRAPHQL
          id
          barcode
          title
          price
          sku
          position
          inventoryQuantity
          inventoryItem {
            id
          }
        GRAPHQL;
    }

    private static function getInventoryLevelByLocationId(string|int $locationId): string
    {
        $locationId = Str::createShopifyGqlResourceId('Location', $locationId);

        return <<<QUERY
          inventoryLevel(locationId:"$locationId") {
             id
             quantities(names: ["available"]) {
                name
                quantity
             }
          }
        QUERY;
    }

    public static function all(string|int $productId)
    {
        $responseFields = self::responseFields();

        return <<<QUERY
          query {
            productVariants(first: 10, query: "product_id:$productId") {
              edges {
                node {
                  $responseFields
                }
              }
            }
          }
        QUERY;
    }

    public static function getDefault(string|int $productId, string|int|null $locationId = null): string
    {
        $locationQuery = $locationId ? self::getInventoryLevelByLocationId($locationId) : '';

        $responseFields = self::responseFields();

        return <<<QUERY
          query {
            productVariants(first: 1, query: "(product_id:$productId) AND (title:Default*)") {
              edges {
                node {
                  $responseFields
                  inventoryItem {
                    id
                    $locationQuery
                  }
                }
              }
            }
          }
        QUERY;
    }

    public static function create(): string
    {
        $responseFields = self::responseFields();

        return <<<GRAPHQL
            mutation productVariantCreate(\$input: ProductVariantInput!) {
              productVariantCreate(input: \$input) {
                productVariant {
                  $responseFields
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
        $responseFields = self::responseFields();
        $productResponseFields = ProductSchema::responseFields();

        return <<<GRAPHQL
            mutation productVariantUpdate(\$input: ProductVariantInput!) {
              productVariantUpdate(input: \$input) {
                productVariant {
                    $responseFields
                    product {
                        $productResponseFields
                    }
                }
                userErrors {
                  field
                  message
                }
              }
            }
        GRAPHQL;
    }

    public static function retrieve(): string
    {
        $responseFields = self::responseFields();
        $productResponseFields = ProductSchema::responseFields();

        return <<<GRAPHQL
            query productVariant(\$id: ID!) {
                productVariant(id: \$id) {
                    $responseFields
                    product {
                        $productResponseFields
                    }
                }
            }
        GRAPHQL;

    }

    public static function retrieveBySku(string|int|null $locationId = null): string
    {
        $locationQuery = $locationId ? self::getInventoryLevelByLocationId($locationId) : '';

        $responseFields = self::responseFields();
        $productResponseFields = ProductSchema::responseFields();

        return <<<GRAPHQL
            query productVariants(\$sku: String!) {
                productVariants(first: 1, query: \$sku) {
                    nodes {
                        $responseFields
                        inventoryItem {
                            id
                            $locationQuery
                        }
                        product {
                            $productResponseFields
                        }
                    }
                }
            }
        GRAPHQL;
    }

    public static function getMetafieldIdByNamespaceAndKey(): string
    {
        return <<<'GRAPHQL'
            query($id:ID!,$namespace:String!,$key:String!) {
                productVariant(id:$id) {
                    metafield(namespace:$namespace,key:$key) {
                        legacyResourceId
                        value
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
