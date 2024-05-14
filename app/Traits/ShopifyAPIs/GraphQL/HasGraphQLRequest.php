<?php

namespace App\Traits\ShopifyAPIs\GraphQL;

trait HasGraphQLRequest
{
    public array $graphQlResponse;
    public bool $isGraphQlRequestError = false;

    /**
     * @param string $schema
     * @param array $variables
     * @return array
     * @throws \Exception
     */
    public function graphQlRequest(string $schema, array $variables = [])
    {
        $response = $this->user->api()->graph($schema, $variables);

        $this->graphQlResponse = $response;

        if (!empty($response['errors'])) {
            $this->isGraphQlRequestError = true;

            throw new \Exception(var_export($response['errors'], true));
        }

        return $response['body']['container']['data'];
    }

    public function getGraphQlResponse(): array
    {
        return $this->graphQlResponse;
    }

    public function isError(): bool
    {
        return $this->isGraphQlRequestError;
    }
}
