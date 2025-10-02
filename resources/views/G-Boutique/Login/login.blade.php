<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 400px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            background: #fff;
            padding: 30px;
            text-align: center;
        }
        .login-card img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 20px;
            object-fit: cover;
            border: 4px solid #1cc88a;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <!-- 🔵 Image ronde -->
        <img src="{{ asset('img/logo/logo.jpg') }}" alt="Logo">

        <h4 class="mb-4">Connexion</h4>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- 🔑 Formulaire de connexion -->
        <form method="POST" action="{{ route('login.post') }}">
            @csrf


            <div class="mb-3 text-start">
                <label class="form-label">Adresse email</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>

        <p class="mt-3 mb-0"><a href="#">Mot de passe oublié ?</a></p>
    </div>
</body>
</html>
