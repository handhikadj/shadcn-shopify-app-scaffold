<?php

namespace App\ShopifyAPIs\GraphQL\Product;

use Str;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Traits\ShopifyAPIs\ClassInstantiator;
use App\ShopifyAPIs\Abstracts\ShopifyAPIModel;
use App\Traits\ShopifyAPIs\GraphQL\HasGraphQLRequest;

/**
 * @property int $totalInventory
 * @property array $tags
 */
class Product extends ShopifyAPIModel
{
    use ClassInstantiator, HasGraphQLRequest;

    public function getByIds(array $ids): Collection
    {
        $response = $this->graphQlRequest(Schema::getByIds(), [
            'ids' => collect($ids)->map(fn ($id) => Str::createShopifyGqlResourceId('Product', $id))->toArray(),
        ]);

        return collect($response['nodes'])->map(fn ($node) => $this->setAttributes($node));
    }

    public function create(array $input, ?array $mediaData = null): Product
    {
        $variables = [
            'input' => $input,
        ];

        if ($mediaData) {
            $variables['media'] = $mediaData;
        }

        try {
            $response = $this->graphQlRequest(Schema::create(), $variables);

            $response = data_get($response, 'productCreate.product');

            return $this->setAttributes($response);
        } catch (\Exception $e) {
            return clone $this;
        }
    }

    public function update(array $input): Product
    {
        $variables = [
            'input' => $input,
        ];

        $response = $this->graphQlRequest(Schema::update(), $variables);

        $response = data_get($response, 'productUpdate.product');

        return $this->setAttributes($response);
    }

    public function retrieve(string|int $id): Product
    {
        $id = Str::createShopifyGqlResourceId('Product', $id);

        $response = $this->graphQlRequest(Schema::retrieve(), [
            'id' => $id,
        ]);

        return $this->setAttributes($response['product']);
    }

    public function retrieveBySku(string|int $sku): Product
    {
        $response = $this->graphQlRequest(Schema::retrieveBySku(), [
            'sku' => (string) $sku,
        ]);

        $response = data_get($response, 'productVariants.nodes.0.product');

        return $this->setAttributes($response);
    }

    public function lastSynced(): Product
    {
        $response = $this->graphQlRequest(Schema::lastSynced());

        $response = data_get($response, 'products.nodes.0');

        return $this->setAttributes($response);
    }

    public function syncedEdeaProductsCount(): int
    {
        $response = $this->graphQlRequest(Schema::syncedEdeaProductsCount());

        return data_get($response, 'productsCount.count', 0);
    }

    public function getMetafieldIdByNamespaceAndKey(string|int $productId, string $namespace, string $key)
    {
        $response = $this->graphQlRequest(Schema::getMetafieldIdByNamespaceAndKey(), [
            'id' => Str::createShopifyGqlResourceId('Product', $productId),
            'namespace' => $namespace,
            'key' => $key,
        ]);

        return data_get($response, 'product.metafield.legacyResourceId');
    }

    public function deleteAsync(int $id)
    {
        $this->graphQlRequest(Schema::deleteAsync(), [
            'productId' => Str::createShopifyGqlResourceId('Product', $id)
        ]);
    }
}
