<?php

namespace App\Traits\ShopifyAPIs\GraphQL;

trait HasGraphQLRequest
{
    /**
     * @param string $schema
     * @param array $variables
     * @return array
     * @throws \Exception
     */
    public function graphQlRequest(string $schema, array $variables = [])
    {
        $response = $this->user->api()->graph($schema, $variables);

        if (!empty($response['errors'])) {
            throw new \Exception(var_export($response['errors'], true));
        }

        return $response['body']['container']['data'];
    }
}
