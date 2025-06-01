<div class="back-button-container">
    <a href="{{ url()->previous() }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<style>
.back-button-container {
    margin-bottom: 2rem;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--glass-bg, rgba(255, 255, 255, 0.1));
    backdrop-filter: blur(10px);
    border: 1px solid var(--glass-border, rgba(255, 255, 255, 0.2));
    border-radius: 8px;
    color: var(--accent-primary, #00d4ff);
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 500;
}

.btn-back:hover {
    background: var(--glass-bg-hover, rgba(255, 255, 255, 0.15));
    transform: translateX(-5px);
    color: var(--accent-primary, #00d4ff);
    text-decoration: none;
}

.btn-back i {
    transition: transform 0.3s ease;
}

.btn-back:hover i {
    transform: translateX(-3px);
}
</style>
