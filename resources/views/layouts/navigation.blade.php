<nav class="bg-white/5 backdrop-blur-lg border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">SU</span>
                    </div>
                    <span class="text-white font-semibold text-lg">Studios Unis</span>
                </a>
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-white transition-colors">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-300 hover:text-white transition-colors">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition-colors">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="btn-aurora text-sm px-4 py-2">
                        S'inscrire
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
