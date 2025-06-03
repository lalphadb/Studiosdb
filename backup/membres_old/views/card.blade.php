<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Carte Membre - {{ $membre->prenom }} {{ $membre->nom }}</title>
    <style>
        body { margin: 0; padding: 20px; }
        .card { width: 86mm; height: 54mm; background: #1e40af; color: white; padding: 10px; }
    </style>
</head>
<body>
    <div class="card">
        <h3>Studios Unis</h3>
        <p>{{ $membre->prenom }} {{ $membre->nom }}</p>
        <p>École: {{ $ecole->nom ?? 'N/A' }}</p>
        <p>Ceinture: {{ $ceinture->nom ?? 'Blanche' }}</p>
    </div>
</body>
</html>
