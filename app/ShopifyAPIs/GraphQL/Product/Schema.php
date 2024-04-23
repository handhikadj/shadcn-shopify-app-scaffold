<?php

namespace App\ShopifyAPIs\GraphQL\Product;

class Schema
{
    public static function getByIds()
    {
        return <<<'GRAPHQL'
            query Products($ids: [ID!]!) {
              nodes(ids: $ids) {
                ... on Product {
                  id
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
                }
              }
            }
        GRAPHQL;
    }

    public static function create(): string
    {
        return <<<'GRAPHQL'
            mutation productCreate($input: ProductInput!, $media: [CreateMediaInput!]) {
              productCreate(input: $input, media: $media) {
                product {
                  id
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
                }
                userErrors {
                  field
                  message
                }
              }
            }
        GRAPHQL;
    }

    public static function retrieve(string $id): string
    {
        return <<<GRAPHQL
            query {
              product(id: "$id") {
                id
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
}
