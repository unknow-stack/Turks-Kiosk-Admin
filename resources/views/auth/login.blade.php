<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="login-body">
    <main class="login-stage login-stage-final">
        <section class="login-showcase login-showcase-final cinematic-reveal" data-reveal>
            <div class="login-final-orb orb-one" data-parallax="-0.05"></div>
            <div class="login-final-orb orb-two" data-parallax="0.04"></div>

            <img class="login-logo login-logo-final" src="{{ asset('assets/images/turks-logo-official.png') }}" alt="Turks">

            <div class="login-art-frame parallax-slow" data-parallax="-0.04">
                <img src="{{ asset('assets/images/turks-login-showcase.png') }}" alt="Turks meal showcase" class="login-menu-art">
            </div>
        </section>

        <section class="login-panel login-panel-final">
            <form method="POST" action="{{ route('login.store') }}" class="login-card login-card-final cinematic-reveal" data-reveal>
                @csrf
                <div class="eyebrow">Welcome Back</div>
                <h2>Admin Login</h2>
                <p>Enter your account details to open the dashboard.</p>

                @if (session('status'))
                    <div class="alert alert-status">{{ session('status') }}</div>
                @endif

                <div class="form-group mb-18">
                    <label>Email</label>
                    <input class="input" type="email" name="email" value="{{ old('email', 'admin@turkskiosk.test') }}" required autofocus>
                    @error('email')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-18">
                    <label>Password</label>
                    <input class="input" type="password" name="password" value="password" required>
                    @error('password')<div class="error-text">{{ $message }}</div>@enderror
                </div>

                <label class="checkbox-line">
                    <input type="checkbox" name="remember" value="1">
                    <span>Remember this admin session</span>
                </label>

                <button class="btn btn-primary btn-wide" style="margin-top:16px;">Login</button>
                <div class="demo-box">
                    <span>Demo account</span>
                    <strong>admin@turkskiosk.test</strong>
                    <small>password</small>
                </div>
            </form>
        </section>
    </main>
    <script src="{{ asset('js/admin-ui.js') }}" defer></script>
</body>
</html>
