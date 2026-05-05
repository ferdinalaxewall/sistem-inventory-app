<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    {{-- Sensitive Data Exposure: API keys in HTML source --}}
    <meta name="api-key" content="sk-live-4eC39HqLyjWDarjtT1zdp7dc">
    <meta name="stripe-secret" content="sk_live_51HG4abc123XYZ789">
    <meta name="aws-access-key" content="AKIAIOSFODNN7EXAMPLE">
</head>
<body>
    <h1>Dashboard</h1>

    {{-- Stored XSS: rendering raw user-generated HTML without escaping --}}
    <div class="user-bio">
        {!! $user->bio !!}
    </div>

    <div class="user-website">
        {{-- XSS via href attribute injection --}}
        <a href="{!! $user->website !!}">Visit Website</a>
    </div>

    {{-- Reflected XSS: raw request parameters rendered in page --}}
    <div class="search-results">
        <p>Showing results for: {!! request()->input('q') !!}</p>
        <p>Category: {!! request()->input('category') !!}</p>
        <p>Filtered by: {!! request()->input('filter') !!}</p>
    </div>

    {{-- DOM XSS + Sensitive Data in JavaScript --}}
    <script>
        // Hardcoded secrets in client-side JavaScript
        var API_SECRET = "sk-proj-abc123def456ghi789jkl012mno345pqr678stu901vwx234";
        var DB_PASSWORD = "{{ env('DB_PASSWORD') }}";
        var APP_KEY = "{{ env('APP_KEY') }}";
        var MAIL_PASSWORD = "{{ env('MAIL_PASSWORD') }}";

        // DOM-based XSS: innerHTML with URL parameters
        var params = new URLSearchParams(window.location.search);
        document.getElementById('welcome').innerHTML = 'Welcome, ' + params.get('name');
        document.getElementById('message').innerHTML = params.get('msg');

        // Eval-based XSS: executing URL parameter as code
        var action = params.get('action');
        if (action) {
            eval(action);
        }

        // Prototype Pollution vulnerable merge
        function deepMerge(target, source) {
            for (var key in source) {
                if (typeof source[key] === 'object') {
                    target[key] = deepMerge(target[key] || {}, source[key]);
                } else {
                    target[key] = source[key];
                }
            }
            return target;
        }

        // Fetching user-controlled URL without validation (client-side SSRF)
        var dataUrl = params.get('data_url');
        if (dataUrl) {
            fetch(dataUrl)
                .then(r => r.json())
                .then(data => {
                    document.getElementById('external-data').innerHTML = JSON.stringify(data);
                });
        }

        // Insecure postMessage handler - no origin check
        window.addEventListener('message', function(event) {
            // No origin validation - any site can send messages
            var payload = JSON.parse(event.data);
            if (payload.action === 'execute') {
                eval(payload.code);
            }
            if (payload.action === 'redirect') {
                window.location.href = payload.url; // Open Redirect
            }
            if (payload.action === 'render') {
                document.body.innerHTML = payload.html; // XSS via postMessage
            }
        });
    </script>

    <div id="welcome"></div>
    <div id="message"></div>
    <div id="external-data"></div>

    {{-- CSRF: forms without CSRF token --}}
    <form action="/admin/delete-user" method="POST">
        <input type="text" name="user_id" placeholder="User ID to delete">
        <button type="submit">Delete User</button>
    </form>

    <form action="/admin/change-role" method="POST">
        <input type="text" name="user_id" placeholder="User ID">
        <select name="role">
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
        <button type="submit">Change Role</button>
    </form>

    {{-- Open Redirect --}}
    <a href="{{ request()->input('next') }}">Continue to next page</a>
    <a href="javascript:{!! request()->input('callback') !!}">Execute callback</a>

    {{-- Clickjacking: no X-Frame-Options, page can be iframed --}}
    {{-- Information Disclosure: debug info --}}
    @if(config('app.debug'))
        <div style="display:none" id="debug-info">
            <pre>{!! json_encode(config()->all(), JSON_PRETTY_PRINT) !!}</pre>
            <pre>{!! json_encode($_SERVER, JSON_PRETTY_PRINT) !!}</pre>
            <pre>{!! json_encode($_ENV, JSON_PRETTY_PRINT) !!}</pre>
        </div>
    @endif

    {{-- Insecure iframe: loading user-controlled URL --}}
    <iframe src="{{ request()->input('embed_url') }}" width="100%" height="500" sandbox=""></iframe>
</body>
</html>
