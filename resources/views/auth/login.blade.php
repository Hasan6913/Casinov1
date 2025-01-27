<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100" style="background-color: #f8f9fa;">
    <div class="card shadow p-4" style="width: 400px;">
        <h3 class="text-center mb-4">Login</h3>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Šifra</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label class="form-check-label" for="remember">Zapamti me</label>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #6c757d; font-weight: bold;">Zaboravili ste šifru?</a>
                <a href="{{ route('register') }}" class="text-decoration-none" style="color: #6c757d; font-weight: bold;">Registracija</a>
            </div>
            <button type="submit" class="btn btn-dark w-100">LOG IN</button>
        </form>
    </div>
</body>
</html>
