<?php

namespace App\Providers;

use Arr;
use Str;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Str::macro('createShopifyGqlResourceId', function (string $resourceName, string $id): string {
            return !Str::contains($id, "gid://shopify") ? "gid://shopify/$resourceName/$id" : $id;
        });
        Str::macro('getShopifyGqlResourceId', function (string $url): string {
            return !Str::contains($url, "gid://shopify") ? $url : Str::afterLast($url, '/');
        });

        Arr::macro('recursive', function ($obj) {
            if (is_object($obj) || is_array($obj)) {
                $ret = (array) $obj;
                foreach ($ret as &$item) {
                    //recursively process EACH element regardless of type
                    $item = Arr::recursive($item);
                }

                return $ret;
            }

            return $obj;
        });

        LogViewer::auth(fn ($request) => true);

        Collection::macro('setRestModelAttributes', function ($restModel) {
            return $this->map(fn ($item) => $restModel->setAttributes($item));
        });
    }
}
