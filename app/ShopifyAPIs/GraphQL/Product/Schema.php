<?php

namespace App\ShopifyAPIs\GraphQL\Product;

class Schema
{
    public static function responseFields(): string
    {
        return <<<GRAPHQL
            id
            legacyResourceId
            bodyHtml
            description
            descriptionHtml
            title
            handle
            productType
            status
            createdAt
            updatedAt
            vendor
            totalInventory
            tracksInventory
            tags
        GRAPHQL;
    }

    public static function getByIds()
    {
        $responseFields = self::responseFields();

        return <<<GRAPHQL
            query Products(\$ids: [ID!]!) {
              nodes(ids: \$ids) {
                ... on Product {
                  $responseFields
                }
              }
            }
        GRAPHQL;
    }

    public static function create(): string
    {
        $responseFields = self::responseFields();

        return <<<GRAPHQL
            mutation productCreate(\$input: ProductInput!, \$media: [CreateMediaInput!]) {
              productCreate(input: \$input, media: \$media) {
                product {
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

        return <<<GRAPHQL
            mutation productUpdate(\$input: ProductInput!) {
              productUpdate(input: \$input) {
                product {
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

    public static function retrieve(): string
    {
        $responseFields = self::responseFields();

        return <<<GRAPHQL
            query(\$id: ID!) {
              product(id: \$id) {
                $responseFields
              }
            }
        GRAPHQL;
    }

    public static function retrieveBySku(): string
    {
        $responseFields = self::responseFields();

        return <<<GRAPHQL
            query(\$sku: String!) {
                productVariants(first: 1, query: \$sku) {
                    nodes {
                        product {
                            $responseFields
                        }
                    }
                }
            }
        GRAPHQL;

    }

    public static function deleteAsync(): string
    {
        return <<<'GRAPHQL'
            mutation productDeleteAsync($productId: ID!) {
              productDeleteAsync(productId: $productId) {
                deleteProductId
                userErrors {
                  field
                  message
                }
              }
            }
        GRAPHQL;
    }

    public static function lastSynced(): string
    {
        $responseFields = self::responseFields();

        return <<<GRAPHQL
            query {
                products(first: 1, sortKey: CREATED_AT, reverse: true, query: "tag:edeaItemCode*") {
                    nodes {
                        $responseFields
                    }
                }
            }
        GRAPHQL;
    }

    public static function syncedEdeaProductsCount(): string
    {

        return <<<'GRAPHQL'
            query {
                productsCount(query: "tag:edeaItemCode*") {
                    count
                }
            }
        GRAPHQL;
    }

    public static function getMetafieldIdByNamespaceAndKey(): string
    {
        return <<<'GRAPHQL'
            query($id:ID!,$namespace:String!,$key:String!) {
                product(id:$id) {
                    metafield(namespace:$namespace,key:$key) {
                        legacyResourceId
                        value
                    }
                }
            }
        GRAPHQL;
    }
}
