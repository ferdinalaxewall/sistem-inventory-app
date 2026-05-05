<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Debug Panel</title>
    {{-- Sensitive Data in HTML source --}}
    <meta name="internal-endpoint" content="http://169.254.169.254/latest/meta-data/">
    <meta name="admin-token" content="eyJhbGciOiJIUzI1NiJ9.eyJyb2xlIjoiYWRtaW4ifQ.FAKE_BUT_PATTERN">
    <meta name="db-connection" content="mysql://root:password123@db.internal:3306/production">
</head>
<body>
    <h1>Debug Panel</h1>

    {{-- Stored XSS: raw user content from database --}}
    <section class="user-data">
        <div class="bio">{!! $user->bio !!}</div>
        <div class="signature">{!! $user->signature !!}</div>
        <span class="nickname">{!! $user->nickname !!}</span>
        <a href="{!! $user->profile_url !!}">Profile Link</a>
    </section>

    {{-- Reflected XSS: unescaped request parameters everywhere --}}
    <section class="dynamic-content">
        <h2>Results for: {!! request()->input('query') !!}</h2>
        <p>Category: {!! request()->input('cat') !!}</p>
        <p>Status: {!! request()->input('status') !!}</p>
        <p>Message: {!! request()->input('msg') !!}</p>
        <div class="path">
            {!! request()->input('breadcrumb') !!}
        </div>
    </section>

    {{-- XSS in attributes --}}
    <img src="{!! request()->input('img_src') !!}" onerror="{!! request()->input('onerror') !!}">
    <div id="dynamic" data-config="{!! request()->input('config') !!}"></div>
    <input type="text" value="{!! request()->input('prefill') !!}" onfocus="{!! request()->input('onfocus') !!}">
    <a href="javascript:{!! request()->input('js_action') !!}">Run Action</a>
    <div style="background-image: url('{!! request()->input('bg_url') !!}')"></div>

    {{-- CSRF: destructive forms without protection --}}
    <form action="/api/admin/drop-table" method="POST">
        <input name="table" value="{!! request()->input('table') !!}">
        <button>Drop Table</button>
    </form>

    <form action="/api/admin/reset-password" method="POST">
        <input name="user_id" value="{!! request()->input('uid') !!}">
        <input name="new_password" value="hacked123">
        <button>Reset Password</button>
    </form>

    <form action="/api/admin/grant-role" method="POST">
        <input name="user_id" value="{!! request()->input('uid') !!}">
        <input name="role" value="super_admin">
        <button>Grant Admin</button>
    </form>

    {{-- Open Redirect --}}
    <a href="{{ request()->input('redirect') }}">Continue</a>
    <a href="{{ request()->input('callback_url') }}">Callback</a>
    <meta http-equiv="refresh" content="0;url={{ request()->input('auto_redirect') }}">

    {{-- Insecure iframes --}}
    <iframe src="{{ request()->input('frame_src') }}" allow="camera;microphone;payment;usb" style="width:100%;height:500px;border:none;"></iframe>

    {{-- Client-side vulnerabilities --}}
    <script>
        // Secrets exposed to client-side
        window.__DEBUG__ = {
            appKey: "{{ env('APP_KEY') }}",
            dbHost: "{{ env('DB_HOST') }}",
            dbUser: "{{ env('DB_USERNAME') }}",
            dbPass: "{{ env('DB_PASSWORD') }}",
            dbName: "{{ env('DB_DATABASE') }}",
            mailPass: "{{ env('MAIL_PASSWORD') }}",
            redisPass: "{{ env('REDIS_PASSWORD') }}",
            pusherSecret: "{{ env('PUSHER_APP_SECRET') }}",
            sessionSecret: "{{ config('app.key') }}",
        };

        // DOM XSS via URL params
        var p = new URLSearchParams(window.location.search);

        // innerHTML injection
        ['output', 'alert-box', 'status-bar', 'user-greeting', 'error-display'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.innerHTML = p.get(id) || '';
        });

        // eval-based XSS
        var code = p.get('exec');
        if (code) eval(code);

        var fn = p.get('fn');
        if (fn) new Function(fn)();

        var timeout_code = p.get('delayed');
        if (timeout_code) setTimeout(timeout_code, 100);

        var interval_code = p.get('repeat');
        if (interval_code) setInterval(interval_code, 1000);

        // document.write XSS
        var inject = p.get('inject');
        if (inject) document.write(inject);

        // Insecure postMessage - accepts from any origin, executes arbitrary code
        window.addEventListener('message', function(event) {
            // No origin check whatsoever
            try {
                var cmd = JSON.parse(event.data);
                if (cmd.eval) eval(cmd.eval);
                if (cmd.navigate) window.location = cmd.navigate;
                if (cmd.html) document.body.innerHTML = cmd.html;
                if (cmd.cookie) document.cookie = cmd.cookie;
                if (cmd.fetch_url) {
                    fetch(cmd.fetch_url, { credentials: 'include' })
                        .then(r => r.text())
                        .then(d => event.source.postMessage(d, '*'));
                }
                if (cmd.storage_key) {
                    event.source.postMessage(localStorage.getItem(cmd.storage_key), '*');
                }
            } catch(e) {}
        });

        // Prototype pollution
        function unsafeMerge(target, source) {
            Object.keys(source).forEach(function(key) {
                if (typeof source[key] === 'object' && source[key] !== null) {
                    if (!target[key]) target[key] = {};
                    unsafeMerge(target[key], source[key]);
                } else {
                    target[key] = source[key];
                }
            });
        }
        var userInput = JSON.parse(p.get('settings') || '{}');
        unsafeMerge({}, userInput); // Pollutes Object.prototype

        // WebSocket RCE
        var wsEndpoint = p.get('ws') || 'ws://localhost:9090';
        var socket = new WebSocket(wsEndpoint);
        socket.onmessage = function(e) { eval(e.data); };

        // Leaking auth tokens via Referer
        if (p.get('track')) {
            var img = new Image();
            img.src = p.get('track') + '?token=' + document.cookie + '&url=' + window.location.href;
        }
    </script>

    <div id="output"></div>
    <div id="alert-box"></div>
    <div id="status-bar"></div>
    <div id="user-greeting"></div>
    <div id="error-display"></div>

    {{-- Full server config dump --}}
    <div style="display:none" id="server-dump">
        <pre>{!! json_encode(config()->all(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}</pre>
        <pre>{!! json_encode($_SERVER, JSON_PRETTY_PRINT) !!}</pre>
        <pre>{!! json_encode($_ENV, JSON_PRETTY_PRINT) !!}</pre>
        <pre>{!! json_encode(get_defined_vars(), JSON_PRETTY_PRINT) !!}</pre>
        <pre>{!! phpinfo() !!}</pre>
    </div>
</body>
</html>
