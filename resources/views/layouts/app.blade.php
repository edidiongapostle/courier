<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100 min-h-screen flex flex-col">
        @if(Str::startsWith(Route::currentRouteName(), 'admin.'))
            @include('layouts.admin_navigation')
        @else
            @include('layouts.navigation')
        @endif
        <main class="flex-1">
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot ?? '' }}
            @endif
        </main>
        <footer class="bg-gray-800 text-gray-200 py-8 mt-12">
            <div class="container w-full max-w-full mx-auto px-4 flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                <div class="mb-4 md:mb-0 text-sm text-center md:text-left">
                    &copy; {{ date('Y') }} SWIFT SYNCH. All rights reserved.
                </div>
                <div class="flex flex-wrap justify-center md:justify-end space-x-6 text-sm">
                    <a href="{{ route('fraud-awareness') }}" class="hover:underline">Fraud Awareness</a>
                    <a href="{{ route('legal-notice') }}" class="hover:underline">Legal Notice</a>
                    <a href="{{ route('terms-of-use') }}" class="hover:underline">Terms of Use</a>
                    <a href="{{ route('privacy-notice') }}" class="hover:underline">Privacy Notice</a>
                    <a href="{{ route('accessibility') }}" class="hover:underline">Accessibility</a>
                </div>
            </div>
            <!-- Start of LiveChat (www.livechat.com) code -->
<script>
    window.__lc = window.__lc || {};
    window.__lc.license = 19250351;
    window.__lc.integration_name = "manual_onboarding";
    window.__lc.product_name = "livechat";
    ;(function(n,t,c){function i(n){return e._h?e._h.apply(null,n):e._q.push(n)}var e={_q:[],_h:null,_v:"2.0",on:function(){i(["on",c.call(arguments)])},once:function(){i(["once",c.call(arguments)])},off:function(){i(["off",c.call(arguments)])},get:function(){if(!e._h)throw new Error("[LiveChatWidget] You can't use getters before load.");return i(["get",c.call(arguments)])},call:function(){i(["call",c.call(arguments)])},init:function(){var n=t.createElement("script");n.async=!0,n.type="text/javascript",n.src="https://cdn.livechatinc.com/tracking.js",t.head.appendChild(n)}};!n.__lc.asyncInit&&e.init(),n.LiveChatWidget=n.LiveChatWidget||e}(window,document,[].slice))
</script>
<noscript><a href="https://www.livechat.com/chat-with/19250351/" rel="nofollow">Chat with us</a>, powered by <a href="https://www.livechat.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a></noscript>
<!-- End of LiveChat code -->

        </footer>
    </body>
</html>
