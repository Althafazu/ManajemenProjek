<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-image: url('{{ asset('assets/images/IMG_Background.jpg') }}');             background-repeat: no-repeat;
            background-repeat: no-repeat;
            background-size: cover;
            font-family: 'Barlow', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center; /* Vertikal tengah */
            justify-content: center; /* Horizontal tengah */
        }
        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 100%;
            max-width: 400px; /* Maksimal lebar card */
        }
        .login-logo {
            display: block;
            margin: 0 auto 20px;
            width: 150px;
        }
        .login-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card login-card p-4">
                    <img src="assets\images\logo.png" alt="Logo" class="login-logo">
                    <h4 class="login-title">SISTEM MANAJEMEN PROYEK</h4>
                <form action="{{ route('login.process') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span> </label>
                                <input type="text" name="username" id="username" class="form-control" aria-describedby="username-help" autofocus placeholder="NIM / NPK">
                                @error('username')
                                    <span id="username-help" class="form-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span> </label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                @error('password')
                                    <span id="password-help" class="form-text text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">MASUK</button>
                        </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
