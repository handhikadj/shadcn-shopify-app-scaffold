<?php

namespace App\ShopifyAPIs\GraphQL\Customer;

class Schema
{
    public static function responseFields(): string
    {
        return <<<GRAPHQL
            id
            legacyResourceId
            email
            firstName
            lastName
            phone
            createdAt
            updatedAt
        GRAPHQL;
    }

    public static function update(): string
    {
        $responseFields = self::responseFields();

        return <<<GRAPHQL
            mutation customerUpdate(\$input: CustomerInput!) {
                customerUpdate(input: \$input) {
                    customer {
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
}
