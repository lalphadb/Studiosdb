<footer class="footer-loi25">
    <div class="footer-content">
        <div class="footer-links">
            <a href="{{ route('privacy-policy') }}">
                <i class="bi bi-shield-check"></i> Politique de confidentialité
            </a>
            <a href="{{ route('terms') }}">
                <i class="bi bi-file-text"></i> Conditions d'utilisation
            </a>
            <a href="{{ route('data-collection') }}">
                <i class="bi bi-lock"></i> Avis de collecte
            </a>
            <a href="{{ route('access-rights') }}">
                <i class="bi bi-person-check"></i> Droits d'accès
            </a>
            <a href="{{ route('contact') }}">
                <i class="bi bi-envelope"></i> Contact
            </a>
        </div>
        <div class="footer-copyright">
            <p>&copy; {{ date('Y') }} Studios Unis. Tous droits réservés. | Conforme à la Loi 25 du Québec</p>
            <p class="text-muted" style="font-size: 12px; margin-top: 5px;">
                Nous respectons votre vie privée conformément à la Loi modernisant des dispositions législatives en matière de protection des renseignements personnels
            </p>
        </div>
    </div>
</footer>

<style>
.footer-loi25 {
    background: rgba(10, 10, 10, 0.9);
    backdrop-filter: blur(20px);
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    padding: 30px 0;
    margin-top: 50px;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    text-align: center;
}

.footer-links {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 20px;
}

.footer-links a {
    color: #b4b4c6;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 5px;
}

.footer-links a:hover {
    color: #00d4ff;
}

.footer-copyright {
    font-size: 13px;
    color: #7c7c94;
}

.footer-copyright p {
    margin: 5px 0;
}
</style>
