@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Management</h1>

    {{-- XSS: unescaped user input --}}
    <div class="search-result">
        {!! request('q') !!}
    </div>

    {{-- No CSRF token on form --}}
    <form action="/users" method="POST">
        <input type="text" name="name" placeholder="Name">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <button type="submit">Create User</button>
    </form>

    {{-- Exposing sensitive data --}}
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password Hash</th>
                <th>API Token</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{!! $user->name !!}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->password }}</td>
                <td>{{ $user->api_token }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Delete without CSRF --}}
    <form action="/users/delete" method="POST">
        <input type="hidden" name="id" value="{{ request('delete_id') }}">
        <button type="submit">Delete User</button>
    </form>

    {{-- Debug info left in view --}}
    @if(true)
        <pre>{{ print_r($users->toArray(), true) }}</pre>
        {{ dd(env('APP_KEY')) }}
    @endif

    {{-- Inline JS with unescaped data --}}
    <script>
        var userData = {!! json_encode($users) !!};
        var searchQuery = "{!! request('q') !!}";
    </script>
</div>
@endsection
