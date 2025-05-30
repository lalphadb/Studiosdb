<footer class="footer-loi25">
    <div class="footer-container">
        <div class="footer-content">
            <!-- Logo et conformité -->
            <div class="footer-section">
                <h3>Studios Unis</h3>
                <p class="compliance-badge">
                    <i class="fas fa-shield-alt"></i>
                    Conforme à la Loi 25
                </p>
                <p class="last-update">Dernière mise à jour: {{ now()->format('d F Y') }}</p>
            </div>
            
            <!-- Lien unique vers la politique -->
            <div class="footer-section">
                <h4>Protection des données</h4>
                <p><a href="{{ route('privacy-policy') }}">Politique de confidentialité complète</a></p>
                <p class="footer-text">Incluant les conditions d'utilisation, avis de collecte et droits d'accès</p>
            </div>
            
            <!-- Contact -->
            <div class="footer-section">
                <h4>Contact</h4>
                <p><a href="{{ route('contact') }}">Nous contacter</a></p>
                <p class="footer-text">Pour toute question concernant vos données personnelles</p>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Studios Unis. Tous droits réservés.</p>
        </div>
    </div>
</footer>

<style>
.footer-loi25 {
    background: var(--glass-bg);
    backdrop-filter: blur(var(--blur-amount));
    border-top: 1px solid var(--glass-border);
    margin-top: auto;
    padding: 2rem 0 1rem;
    margin-left: 260px; /* Décaler pour la sidebar */
    transition: margin-left 0.3s ease;
}

/* Quand la sidebar est rétractée */
.sidebar-collapsed + .footer-loi25,
.admin-main.sidebar-collapsed ~ .footer-loi25 {
    margin-left: 60px;
}

/* Mobile */
@media (max-width: 768px) {
    .footer-loi25 {
        margin-left: 0;
    }
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 1.5rem;
}

.footer-section h3,
.footer-section h4 {
    color: var(--text-primary);
    margin-bottom: 0.75rem;
    font-size: 1rem;
}

.footer-section p {
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.footer-section a {
    color: var(--accent-primary);
    text-decoration: none;
}

.footer-section a:hover {
    text-decoration: underline;
}

.footer-text {
    color: var(--text-muted);
    font-size: 0.8rem;
}

.compliance-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--accent-green);
    font-weight: 500;
}

.last-update {
    font-size: 0.75rem;
    color: var(--text-muted);
    font-style: italic;
}

.footer-bottom {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid var(--glass-border);
    color: var(--text-muted);
    font-size: 0.8rem;
}
</style>
