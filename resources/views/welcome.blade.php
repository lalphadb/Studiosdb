<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Studios Unis DB</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <div class="welcome-container">
        <h1 class="welcome-title">Studios Unis DB</h1>
        <div class="welcome-buttons">
            <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
            <a href="{{ route('register') }}" class="btn btn-secondary">S'inscrire</a>
        </div>
    </div>
</body>
</html>
