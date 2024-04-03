@extends('shopify-app::layouts.default')

@section('styles')
    <link href="{{ asset('assets/css/fa-icons.min.css') }}" rel="stylesheet">

    <meta name="shopify-api-key" content="{{ config('shopify-app.api_key')  }}" />
    <script src="https://cdn.shopify.com/shopifycloud/app-bridge.js"></script>
    <script>
        if (shopify) {
            window.shopifyAppBridge = shopify
        }
    </script>
@endsection

@section('content')
    @inertia
@endsection

@section('scripts')
    @parent
    @routes
    <script>
        Ziggy.url = '{{ env('APP_URL') }}'
    </script>
    @vite('resources/js/app.js')
    @inertiaHead

    {{--  Setup navigation menu: https://shopify.dev/docs/api/app-bridge-library/reference/navigation-menu --}}
    {{--    <ui-nav-menu>--}}
    {{--        <a href="/others">Others</a>--}}
    {{--    </ui-nav-menu>--}}

    <script>
        window.legacyAppBridge = app
    </script>
@endsection
