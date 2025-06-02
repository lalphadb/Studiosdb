// Alpine.js data
function loginForm() {
    return {
        termsAccepted: false,
        acceptedTerms: localStorage.getItem('termsAccepted') === 'true',
        showTermsModal: false,
        showPrivacyModal: false,
        
        init() {
            // Vérifier si les termes ont déjà été acceptés
            if (this.acceptedTerms) {
                this.termsAccepted = true;
            }
        },
        
        handleSubmit(event) {
            if (this.termsAccepted && !this.acceptedTerms) {
                // Sauvegarder dans localStorage
                localStorage.setItem('termsAccepted', 'true');
                this.acceptedTerms = true;
            }
            
            // Ajouter classe loading au bouton
            const btn = event.target.closest('button');
            if (btn) {
                btn.classList.add('loading');
            }
        }
    }
}

// Gestion des tabs
function showTab(tabName) {
    // Cacher tous les formulaires
    document.querySelectorAll('.auth-form').forEach(form => {
        form.classList.remove('active');
    });
    
    // Retirer active de tous les tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Afficher le formulaire sélectionné
    document.getElementById(tabName + '-form').classList.add('active');
    
    // Activer le bon tab
    const activeBtn = Array.from(document.querySelectorAll('.tab-btn')).find(btn => {
        return btn.textContent.toLowerCase().includes(
            tabName.replace('-', ' ')
        );
    });
    
    if (activeBtn) {
        activeBtn.classList.add('active');
    }
    
    // Animation d'entrée
    const activeForm = document.getElementById(tabName + '-form');
    activeForm.style.opacity = '0';
    activeForm.style.transform = 'translateY(20px)';
    
    setTimeout(() => {
        activeForm.style.transition = 'all 0.3s ease';
        activeForm.style.opacity = '1';
        activeForm.style.transform = 'translateY(0)';
    }, 50);
}

// Charger les dates de portes ouvertes
async function loadPODates(ecoleId) {
    if (!ecoleId) return;
    
    const container = document.getElementById('po-dates');
    container.innerHTML = '<div class="loading">Chargement des dates...</div>';
    
    try {
        const response = await fetch(`/api/portes-ouvertes/dates/${ecoleId}`);
        const dates = await response.json();
        
        if (dates.length === 0) {
            container.innerHTML = '<p style="color: rgba(255,255,255,0.6); text-align: center;">Aucune date disponible pour cette école</p>';
            return;
        }
        
        container.innerHTML = '<h4 style="color: white; margin-bottom: 15px;">Sélectionnez une date :</h4>';
        
        dates.forEach(date => {
            const dateCard = document.createElement('label');
            dateCard.className = 'po-date-card';
            dateCard.innerHTML = `
                <input type="radio" name="po_date_id" value="${date.id}" required style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <strong style="color: white;">${formatDate(date.date)}</strong>
                        <br>
                        <small style="color: rgba(255,255,255,0.6);">${date.heure_debut} - ${date.heure_fin}</small>
                    </div>
                    <div style="text-align: right;">
                        <small style="color: ${date.places_restantes > 0 ? '#4caf50' : '#ff4757'};">
                            ${date.places_restantes > 0 ? date.places_restantes + ' places' : 'Complet'}
                        </small>
                    </div>
                </div>
            `;
            
            dateCard.addEventListener('click', function() {
                document.querySelectorAll('.po-date-card').forEach(card => {
                    card.classList.remove('selected');
                });
                this.classList.add('selected');
                this.querySelector('input').checked = true;
            });
            
            container.appendChild(dateCard);
        });
    } catch (error) {
        container.innerHTML = '<p style="color: #ff4757;">Erreur lors du chargement des dates</p>';
    }
}

// Formater la date
function formatDate(dateString) {
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('fr-FR', options);
}

// Animations au chargement
document.addEventListener('DOMContentLoaded', function() {
    // Animer les particules avec des trajectoires aléatoires
    const particles = document.querySelectorAll('.particle');
    particles.forEach(particle => {
        const randomX = Math.random() * 200 - 100;
        particle.style.setProperty('--random-x', randomX + 'px');
    });
    
    // Focus sur le premier champ
    const firstInput = document.querySelector('.auth-form.active .form-input');
    if (firstInput) {
        firstInput.focus();
    }
    
    // Gérer les messages d'erreur
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(msg => {
        setTimeout(() => {
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 300);
        }, 5000);
    });
});

// Empêcher le double-clic sur les boutons submit
document.querySelectorAll('.btn-submit').forEach(btn => {
    btn.addEventListener('click', function(e) {
        if (this.classList.contains('loading')) {
            e.preventDefault();
            return false;
        }
    });
});

// Effet de typing pour le placeholder
function typeWriter(element, text, speed = 100) {
    let i = 0;
    element.placeholder = '';
    
    function type() {
        if (i < text.length) {
            element.placeholder += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }
    
    type();
}

// Optionnel : ajouter un effet de typing sur certains champs
// typeWriter(document.querySelector('input[name="email"]'), 'votre@email.com', 80);
