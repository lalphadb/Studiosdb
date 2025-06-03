<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des membres - {{ date('d/m/Y') }}</title>
    <style>
        * {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
        }
        body {
            margin: 20px;
        }
        h1 {
            font-size: 20px;
            color: #1e40af;
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #1e40af;
            color: white;
            padding: 8px 4px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
        }
        td {
            padding: 6px 4px;
            border-bottom: 1px solid #ddd;
            font-size: 9px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #10b981;
            color: white;
        }
        .badge-warning {
            background-color: #f59e0b;
            color: white;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 9px;
        }
    </style>
</head>
<body>
    <h1>Studios Unis - Liste des Membres</h1>
    <div class="info">
        Généré le {{ date('d/m/Y à H:i') }} | Total : {{ $membres->count() }} membres
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom complet</th>
                <th>Contact</th>
                <th>École</th>
                <th>Ceinture</th>
                <th>Statut</th>
                <th>Inscription</th>
            </tr>
        </thead>
        <tbody>
            @foreach($membres as $membre)
                <tr>
                    <td>{{ $membre->id }}</td>
                    <td>
                        <strong>{{ $membre->prenom }} {{ $membre->nom }}</strong>
                        @if($membre->date_naissance)
                            <br><small>{{ \Carbon\Carbon::parse($membre->date_naissance)->age }} ans</small>
                        @endif
                    </td>
                    <td>
                        {{ $membre->email ?? '-' }}<br>
                        {{ $membre->telephone ?? '-' }}
                    </td>
                    <td>{{ $membre->ecole->nom ?? 'Non assigné' }}</td>
                    <td>
                        {{ $membre->ceintures()->orderBy('ordre', 'desc')->first()->nom ?? 'Blanche' }}
                    </td>
                    <td>
                        <span class="badge {{ $membre->approuve ? 'badge-success' : 'badge-warning' }}">
                            {{ $membre->approuve ? 'Approuvé' : 'En attente' }}
                        </span>
                    </td>
                    <td>{{ $membre->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Ce document est confidentiel et contient des informations personnelles protégées.</p>
        <p>Studios Unis © {{ date('Y') }} - Tous droits réservés</p>
    </div>
</body>
</html>
