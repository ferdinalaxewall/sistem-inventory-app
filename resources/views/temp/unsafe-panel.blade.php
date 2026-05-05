<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    {{-- Sensitive Data Exposure: secrets in HTML meta tags --}}
    <meta name="api-secret" content="stripe_live_key_EXPOSED_HERE_51ABC123XYZ789">
    <meta name="internal-api" content="http://169.254.169.254/latest/meta-data/iam/security-credentials/">
    <meta name="jwt-secret" content="super_secret_jwt_key_2024_never_expose">
    <meta name="database-url" content="mysql://root:P@ssw0rd@prod-db.internal:3306/production">
</head>
<body>
    <h1>Control Panel</h1>

    {{-- Stored XSS: raw HTML rendering from database --}}
    <section class="user-content">
        <div class="profile-bio">{!! $user->bio !!}</div>
        <div class="profile-name">{!! $user->display_name !!}</div>
        <div class="profile-location">{!! $user->location !!}</div>
        <a href="{!! $user->website_url !!}" target="_blank">Website</a>
    </section>

    {{-- Reflected XSS: multiple unescaped request parameters --}}
    <section class="search">
        <h2>Search Results for: {!! request()->input('q') !!}</h2>
        <p>Filter: {!! request()->input('filter') !!}</p>
        <p>Sort: {!! request()->input('sort') !!}</p>
        <p>Page: {!! request()->input('page') !!}</p>
        <div class="breadcrumb">
            Home > {!! request()->input('category') !!} > {!! request()->input('subcategory') !!}
        </div>
    </section>

    {{-- XSS in HTML attributes --}}
    <img src="{!! request()->input('avatar_url') !!}" onerror="alert('xss')" alt="{!! request()->input('alt_text') !!}">
    <div style="{!! request()->input('custom_style') !!}">Custom styled content</div>
    <a href="javascript:{!! request()->input('action') !!}">Perform Action</a>

    {{-- CSRF: sensitive forms without @csrf token --}}
    <form action="/admin/users/delete" method="POST" id="delete-form">
        <input type="text" name="user_id" value="{!! request()->input('target_user') !!}">
        <button type="submit">Delete User Account</button>
    </form>

    <form action="/admin/settings/update" method="POST">
        <textarea name="app_config">{!! request()->input('config') !!}</textarea>
        <button type="submit">Update Application Config</button>
    </form>

    <form action="/admin/sql/execute" method="POST">
        <textarea name="query" placeholder="Enter SQL query...">{!! request()->input('sql') !!}</textarea>
        <button type="submit">Execute Query</button>
    </form>

    {{-- Open Redirect + javascript: protocol injection --}}
    <a href="{{ request()->input('return_url') }}">Return to previous page</a>
    <a href="{{ request()->input('next') }}">Next Step</a>
    <a href="javascript:void({!! request()->input('callback_fn') !!})">Execute Callback</a>

    {{-- Insecure iframe: user-controlled src --}}
    <iframe src="{{ request()->input('embed') }}" width="100%" height="600" style="border:none;"></iframe>
    <iframe src="{{ request()->input('widget_url') }}" allow="camera; microphone; payment"></iframe>

    {{-- DOM XSS + eval + sensitive data in client-side JS --}}
    <script>
        // Hardcoded secrets exposed to client
        window.APP_CONFIG = {
            apiKey: "sk-proj-REAL_API_KEY_abc123def456ghi789",
            dbPassword: "{{ env('DB_PASSWORD') }}",
            appKey: "{{ env('APP_KEY') }}",
            mailPassword: "{{ env('MAIL_PASSWORD') }}",
            stripeSecret: "{{ env('STRIPE_SECRET') }}",
            awsSecretKey: "{{ env('AWS_SECRET_ACCESS_KEY') }}",
            jwtSecret: "{{ env('JWT_SECRET') }}",
            redisPassword: "{{ env('REDIS_PASSWORD') }}",
        };

        // DOM XSS via URL parameters
        var params = new URLSearchParams(window.location.search);

        // innerHTML XSS
        document.getElementById('greeting').innerHTML = 'Hello, ' + params.get('username');
        document.getElementById('notification').innerHTML = params.get('notice');
        document.getElementById('error-msg').innerHTML = params.get('error');

        // eval-based XSS
        var calc = params.get('calculate');
        if (calc) { eval(calc); }

        var template = params.get('template');
        if (template) { eval('var render = ' + template); }

        // Function constructor XSS
        var handler = params.get('handler');
        if (handler) { new Function(handler)(); }

        // document.write XSS
        var banner = params.get('banner');
        if (banner) { document.write(banner); }

        // Insecure postMessage - no origin validation
        window.addEventListener('message', function(e) {
            // Accepts messages from ANY origin
            var msg = JSON.parse(e.data);

            switch(msg.type) {
                case 'exec':
                    eval(msg.code);
                    break;
                case 'navigate':
                    window.location = msg.url;
                    break;
                case 'inject':
                    document.body.innerHTML += msg.html;
                    break;
                case 'fetch':
                    fetch(msg.url, msg.options).then(r => r.text()).then(d => {
                        e.source.postMessage(d, '*'); // Sends response to any origin
                    });
                    break;
                case 'cookie':
                    document.cookie = msg.value;
                    break;
            }
        });

        // Prototype pollution
        function merge(target, source) {
            for (let key in source) {
                if (key === '__proto__' || key === 'constructor' || key === 'prototype') {
                    target[key] = source[key]; // Allows prototype pollution
                }
                if (typeof source[key] === 'object' && source[key] !== null) {
                    target[key] = target[key] || {};
                    merge(target[key], source[key]);
                } else {
                    target[key] = source[key];
                }
            }
        }

        // Applying user-controlled config via prototype pollution
        var userConfig = JSON.parse(params.get('config') || '{}');
        merge(window.APP_CONFIG, userConfig);

        // Insecure WebSocket with no auth
        var wsUrl = params.get('ws_url') || 'ws://localhost:8080';
        var ws = new WebSocket(wsUrl);
        ws.onmessage = function(e) {
            eval(e.data); // RCE via WebSocket message
        };
    </script>

    <div id="greeting"></div>
    <div id="notification"></div>
    <div id="error-msg"></div>

    {{-- Server-side information disclosure --}}
    <div style="display:none" class="debug-data">
        <pre>{!! json_encode(config()->all(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}</pre>
        <pre>{!! json_encode($_SERVER, JSON_PRETTY_PRINT) !!}</pre>
        <pre>{!! json_encode($_ENV, JSON_PRETTY_PRINT) !!}</pre>
        <pre>{!! json_encode(get_defined_vars(), JSON_PRETTY_PRINT) !!}</pre>
    </div>
</body>
</html>
