<?php

namespace App\ShopifyAPIs\GraphQL\ProductVariant;

use Str;
use App\Models\User;
use GuzzleHttp\Promise\Promise;
use Illuminate\Support\Collection;
use App\Traits\ShopifyAPIs\ClassInstantiator;
use App\ShopifyAPIs\Abstracts\ShopifyAPIModel;
use App\Traits\ShopifyAPIs\GraphQL\HasGraphQLRequest;
use App\ShopifyAPIs\GraphQL\ProductVariant\Traits\ProductVariantGetters;

/**
 * @property string|float $price
 * @property string $sku
 * @property array $inventoryItem
 * @property array $product
 */
class ProductVariant extends ShopifyAPIModel
{
    use ClassInstantiator, HasGraphQLRequest, ProductVariantGetters;

    /**
     * @param string|int $productId
     * @return Collection<ProductVariant>
     * @throws \Exception
     */
    public function all(string|int $productId)
    {
        $response = $this->graphQlRequest(Schema::all($productId));

        return collect($response['productVariants']['edges'])
            ->map(function ($edge) {
                return $this->setAttributes($edge['node']);
            });
    }

    public function getDefault(string|int $productId, string|int|null $locationId = null): ?ProductVariant
    {
        $response = $this->graphQlRequest(Schema::getDefault($productId, $locationId));

        $response = data_get($response, 'productVariants.edges.0.node');

        return $this->setAttributes($response);
    }

    public function create(array $data): ?ProductVariant
    {
        try {
            $response = $this->graphQlRequest(Schema::create(), [
                'input' => $data,
            ]);
            $response = data_get($response, 'productVariantCreate.productVariant');

            return $this->setAttributes($response);
        } catch (\Exception $e) {
            return clone $this;
        }
    }

    public function update(array $data): ?ProductVariant
    {
        $response = $this->graphQlRequest(Schema::update(), [
            'input' => $data,
        ]);

        $response = data_get($response, 'productVariantUpdate.productVariant');

        return $this->setAttributes($response);
    }

    public function retrieve(string|int $id): ?ProductVariant
    {
        $id = Str::createShopifyGqlResourceId('ProductVariant', $id);

        $response = $this->graphQlRequest(Schema::retrieve(), [
            'id' => $id,
        ]);

        $response = data_get($response, 'productVariant');

        return $this->setAttributes($response);
    }

    public function retrieveBySku(string $sku, string|int|null $locationId = null): ?ProductVariant
    {
        $response = $this->graphQlRequest(Schema::retrieveBySku($locationId), [
            'sku' => $sku,
        ]);

        $response = data_get($response, 'productVariants.nodes.0');

        return $this->setAttributes($response);
    }

    public function getMetafieldByNamespaceAndKey(string|int $productVariantId, string $namespace, string $key)
    {
        $response = $this->graphQlRequest(Schema::getMetafieldIdByNamespaceAndKey(), [
            'id' => Str::createShopifyGqlResourceId('ProductVariant', $productVariantId),
            'namespace' => $namespace,
            'key' => $key,
        ]);

        return data_get($response, 'productVariant.metafield');
    }

    public function getMetafieldIdByNamespaceAndKey(string|int $productVariantId, string $namespace, string $key)
    {
        $response = $this->graphQlRequest(Schema::getMetafieldIdByNamespaceAndKey(), [
            'id' => Str::createShopifyGqlResourceId('ProductVariant', $productVariantId),
            'namespace' => $namespace,
            'key' => $key,
        ]);

        return data_get($response, 'productVariant.metafield.legacyResourceId');
    }

    public function delete(string $gid): array
    {
        return $this->graphQlRequest(Schema::delete(), [
            'id' => $gid,
        ]);
    }
}
