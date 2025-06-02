<div class="sidebar-footer" style="padding: 15px; border-top: 1px solid rgba(255,255,255,0.1); background: rgba(10,10,10,0.5); backdrop-filter: blur(10px);">
    <!-- Profil utilisateur glassmorphique -->
    <div class="user-profile" 
         style="background: rgba(255,255,255,0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 12px; margin-bottom: 10px; transition: all 0.3s ease; cursor: pointer;"
         onmouseover="this.style.background='rgba(255,255,255,0.05)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.2)'" 
         onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
        <div style="display: flex; align-items: center; gap: 12px;">
            <!-- Avatar avec gradient moderne -->
            <div class="user-avatar" 
                 style="width: 45px; height: 45px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 600; color: white; font-size: 16px; box-shadow: 0 4px 15px rgba(139,92,246,0.3); text-transform: uppercase;">
                {{ substr(auth()->user()->name ?? 'U', 0, 2) }}
            </div>
            <!-- Informations utilisateur -->
            <div style="flex: 1;">
                <div style="font-weight: 600; color: #ffffff; font-size: 14px; line-height: 1.2;">
                    {{ auth()->user()->name ?? 'Utilisateur' }}
                </div>
                <div style="font-size: 11px; color: #8b92a3; margin-top: 2px;">
                    {{ auth()->user()->role === 'admin' ? 'Super Admin' : 'Admin École' }}
                </div>
                <div style="display: flex; align-items: center; gap: 6px; margin-top: 4px;">
                    <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; display: inline-block; box-shadow: 0 0 10px rgba(16,185,129,0.5); animation: pulse 2s infinite;"></span>
                    <span style="font-size: 11px; color: #10b981;">En ligne</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bouton déconnexion stylisé -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" 
                style="width: 100%; padding: 12px; background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #ef4444; border-radius: 10px; cursor: pointer; font-weight: 500; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 14px;"
                onmouseover="this.style.background='rgba(239,68,68,0.2)'; this.style.borderColor='rgba(239,68,68,0.3)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(239,68,68,0.2)'" 
                onmouseout="this.style.background='rgba(239,68,68,0.1)'; this.style.borderColor='rgba(239,68,68,0.2)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <i class="bi bi-box-arrow-right"></i>
            Déconnexion
        </button>
    </form>
</div>
