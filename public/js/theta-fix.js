document.addEventListener('DOMContentLoaded', function() {
    // Forcer les liens à être cliquables
    const links = document.querySelectorAll('.theta-sidebar a');
    links.forEach(link => {
        link.style.pointerEvents = 'auto';
        link.style.cursor = 'pointer';
        
        // Ajouter un listener de secours
        link.addEventListener('click', function(e) {
            if (this.href && this.href !== '#') {
                window.location.href = this.href;
            }
        });
    });
    
    // Fix pour la sidebar
    const sidebar = document.querySelector('.theta-sidebar');
    if (sidebar) {
        sidebar.style.zIndex = '1000';
    }
    
    console.log('✅ Theta fixes appliqués');
});
