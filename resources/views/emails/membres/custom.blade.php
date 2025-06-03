<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Studios Unis' }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }
        .message {
            color: #555;
            white-space: pre-wrap;
        }
        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            font-size: 14px;
            color: #666;
            border-top: 1px solid #e9ecef;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 20px 0;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .social-links {
            margin-top: 20px;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #667eea;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Studios Unis</h1>
            <p style="margin: 10px 0 0; opacity: 0.9;">École de Karaté</p>
        </div>
        
        <div class="content">
            <p class="greeting">Bonjour {{ $membre->prenom }},</p>
            
            <div class="message">{{ $messageContent }}</div>
            
            @if(isset($actionUrl) && isset($actionText))
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $actionUrl }}" class="button">{{ $actionText }}</a>
            </div>
            @endif
            
            <div class="info-box">
                <strong>Votre école :</strong> {{ $membre->ecole->nom ?? 'Non assigné' }}<br>
                @if($membre->derniere_ceinture)
                <strong>Ceinture actuelle :</strong> {{ $membre->derniere_ceinture->nom }}
                @endif
            </div>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Studios Unis - Tous droits réservés</p>
            <p>
                Cet email vous a été envoyé car vous êtes membre de Studios Unis.<br>
                Pour toute question, contactez-nous à <a href="mailto:info@studiosunis.com">info@studiosunis.com</a>
            </p>
            
            <div class="social-links">
                <a href="#">Facebook</a>
                <a href="#">Instagram</a>
                <a href="#">Site Web</a>
            </div>
        </div>
    </div>
</body>
</html>
