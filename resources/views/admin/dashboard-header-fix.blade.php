{{-- Ajouter ceci au début de dashboard.blade.php après @section('content') --}}
<button class="sidebar-toggle-btn" aria-label="Toggle sidebar" title="Toggle sidebar">
    <i class="fas fa-bars"></i>
</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.admin-sidebar');
    const main = document.querySelector('.admin-main');
    const toggleBtn = document.querySelector('.sidebar-toggle-btn');
    
    if (toggleBtn && sidebar && main) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('sidebar-collapsed');
            
            // Sauvegarder l'état
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebar-state', isCollapsed ? 'collapsed' : 'expanded');
            
            // Changer l'icône
            toggleBtn.innerHTML = isCollapsed ? '<i class="fas fa-chevron-right"></i>' : '<i class="fas fa-bars"></i>';
        });
        
        // Restaurer l'état sauvegardé
        const savedState = localStorage.getItem('sidebar-state');
        if (savedState === 'collapsed') {
            sidebar.classList.add('collapsed');
            main.classList.add('sidebar-collapsed');
            toggleBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
        }
    }
});
</script>
