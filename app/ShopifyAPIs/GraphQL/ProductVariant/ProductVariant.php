<?php

namespace App\ShopifyAPIs\GraphQL\ProductVariant;

use Str;
use App\Models\User;
use GuzzleHttp\Promise\Promise;
use App\Traits\ShopifyAPIs\ClassInstantiator;
use App\ShopifyAPIs\Abstracts\ShopifyAPIModel;
use App\Traits\ShopifyAPIs\GraphQL\HasGraphQLRequest;

/**
 * @property array $inventoryItem
 */
class ProductVariant extends ShopifyAPIModel
{
    use ClassInstantiator, HasGraphQLRequest;

    // public function __construct(private ?User $user = null)
    // {
    //     $this->user = $user ?? auth()->user();
    // }

    public function getDefault(string|int $productId, string|int|null $locationId = null): ProductVariant
    {
        $response = $this->graphQlRequest(Schema::getDefault($productId, $locationId));

        return $this->setAttributes($response['productVariants']['edges'][0]['node'] ?? []);
    }

    public function create(array $data): ProductVariant
    {
        $response = $this->graphQlRequest(Schema::create(), [
            'input' => $data,
        ]);

        return $this->setAttributes($response['productVariantCreate']['productVariant']);
    }

    public function update(array $data): ProductVariant
    {
        $response = $this->graphQlRequest(Schema::update(), [
            'input' => $data,
        ]);

        return $this->setAttributes($response['productVariantUpdate']['productVariant']);
    }

    public function delete(string $gid): array
    {
        return $this->graphQlRequest(Schema::delete(), [
            'id' => $gid,
        ]);
    }
}
