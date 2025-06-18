<!-- resources/views/layouts/sidebar.blade.php -->
<div class="w-64 bg-gradient-to-b from-indigo-600 to-blue-400 shadow-lg fixed h-full flex flex-col">
    <div class="p-6 border-b border-white/20">
        <div class="flex justify-center">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('img/logo-qhse.png') }}" alt="Logo" style="width: 80px; height: 80px;" class="rounded-full shadow-md bg-white p-2">
            </a>
        </div>
    </div>
    
    <a href="{{ route('profile.edit') }}" class="p-6 border-b border-white/20 flex items-center space-x-3 hover:bg-white/10 transition">
        <div class="w-10 h-10 rounded-full bg-white/80 flex items-center justify-center text-indigo-700 font-bold text-lg shadow">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div>
            <div class="text-base font-semibold text-white">{{ Auth::user()->name }}</div>
            <div class="text-xs text-indigo-100">{{ Auth::user()->email }}</div>
        </div>
    </a>
    
    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="{{ route('dashboard') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/20' }}">Dashboard</a>
        @auth
            @if(Auth::user()->role === 'super-admin')
                <a href="{{ route('users.index') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/20' }}">Users</a>
            @endif
        @endauth
        <a href="{{ route('proyeks.index') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 text-white hover:bg-white/20">Data Proyek</a>
        <a href="{{ route('kriterias.index') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 text-white hover:bg-white/20">Data Kriteria</a>
        <a href="{{ route('subkriterias.index') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 text-white hover:bg-white/20">Data Sub-Kriteria</a>
        <a href="{{ route('penilaian.index') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('penilaian.index') || request()->routeIs('penilaian.create_edit') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/20' }}">Penilaian Proyek</a>
        <a href="{{ route('awards.ranking') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('awards.ranking') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/20' }}">Hasil Ranking</a>
        <a href="{{ route('awards.history') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('awards.history') || request()->routeIs('awards.history.detail') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/20' }}">Riwayat Ranking</a>
    </nav>
    <div class="mt-auto p-6 border-t border-white/20">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow transition-all duration-200">
                Logout
            </button>
        </form>
    </div>
</div>