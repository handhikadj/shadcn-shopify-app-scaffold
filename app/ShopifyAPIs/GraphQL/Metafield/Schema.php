<?php

namespace App\ShopifyAPIs\GraphQL\Metafield;

class Schema
{
    public static function createMetafieldDefinitionGqlSchema(): string
    {
        return <<<'GQL'
            mutation CreateMetafieldDefinition($definition: MetafieldDefinitionInput!) {
               metafieldDefinitionCreate(definition: $definition) {
                  createdDefinition {
                    id
                    name
                    key
                    description
                    namespace
                  }
                  userErrors {
                    field
                    message
                    code
                  }
              }
            }
        GQL;
    }
}
