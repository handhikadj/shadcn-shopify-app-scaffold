<?php

namespace App\ShopifyAPIs\GraphQL\ScriptTag;

class Schema
{
    public static function create(): string
    {
        return <<<'GRAPHQL'
            mutation scriptTagCreate($input: ScriptTagInput!) {
              scriptTagCreate(input: $input) {
                scriptTag {
                  id
                  src
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
            mutation scriptTagDelete($id: ID!) {
              scriptTagDelete(id: $id) {
                deletedScriptTagId
                userErrors {
                  field
                  message
                }
              }
            }
        GRAPHQL;

    }
}
