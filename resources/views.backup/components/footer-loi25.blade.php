<!-- resources/views/components/footer-loi25.blade.php -->
<footer class="bg-dark text-white py-4 mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5>Studios Unis</h5>
                <p class="text-muted">Système de gestion pour écoles d'arts martiaux</p>
            </div>
            
            <div class="col-md-4 mb-3">
                <h5>Conformité Loi 25</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('privacy-policy') }}" class="text-white-50 text-decoration-none">Politique de confidentialité</a></li>
                    <li><a href="{{ route('terms') }}" class="text-white-50 text-decoration-none">Conditions d'utilisation</a></li>
                    <li><a href="{{ route('data-collection') }}" class="text-white-50 text-decoration-none">Avis de collecte</a></li>
                    <li><a href="{{ route('access-rights') }}" class="text-white-50 text-decoration-none">Droits d'accès</a></li>
                </ul>
            </div>
            
            <div class="col-md-4 mb-3">
                <h5>Contact</h5>
                <p class="text-muted">
                    <a href="{{ route('contact') }}" class="text-white-50 text-decoration-none">Nous contacter</a>
                </p>
            </div>
        </div>
        
        <hr class="border-secondary">
        
        <div class="text-center">
            <small class="text-muted">© {{ date('Y') }} Studios Unis. Tous droits réservés.</small>
        </div>
    </div>
</footer>
