<!-- resources/views/layouts/sidebar.blade.php -->
<div class="w-64 bg-gradient-to-b from-indigo-600 to-blue-400 shadow-lg fixed h-full flex flex-col">
    <div class="p-6 border-b border-white/20">
        <div class="flex justify-center">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('img/logo-qhse.png') }}" alt="Logo" style="width: 80px; height: 80px;" class="rounded-full shadow-md bg-white p-2">
            </a>
        </div>
        <div class="mt-4 text-center">
            <span class="text-white font-bold text-lg leading-tight drop-shadow">Health Safety and Environment Awards</span>
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
    
    @php
        $user = Auth::user();
        $canKelolaRole = $user && $user->hasPermissionTo('kelola_role');
        $canAksesUser = $user && $user->hasPermissionTo('kelola_role');
    @endphp
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto max-h-screen sidebar-scroll-hide">
        <a href="{{ route('dashboard') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/20' }}">Dashboard</a>
        @can('kelola_periode')
        <a href="{{ route('periodes.index') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('periodes.*') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/20' }}">Manajemen Periode</a>
        @endcan
        @if($canAksesUser)
        <div x-data="{ open: {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'true' : 'false' }} }" class="mb-2">
            <button @click="open = !open" class="w-full flex items-center justify-between py-2 px-4 rounded-lg font-medium transition-all duration-200 text-white hover:bg-white/20 focus:outline-none">
                <span>Master Users</span>
                <svg :class="{ 'rotate-90': open }" class="w-4 h-4 ml-2 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </button>
            <div x-show="open" x-cloak class="pl-4 mt-1 space-y-1">
                <a href="{{ route('users.index') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/10' }}">Data User</a>
                @if($canKelolaRole)
                <a href="{{ route('roles.index') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('roles.*') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/10' }}">Data Role</a>
                @endif
            </div>
        </div>
        @endif
        <div x-data="{ open: {{ request()->routeIs('proyeks.*') || request()->routeIs('manajer-proyeks.*') || request()->routeIs('jenis-proyeks.*') ? 'true' : 'false' }} }" class="mb-2">
            <button @click="open = !open" class="w-full flex items-center justify-between py-2 px-4 rounded-lg font-medium transition-all duration-200 text-white hover:bg-white/20 focus:outline-none">
                <span>Master Proyek</span>
                <svg :class="{ 'rotate-90': open }" class="w-4 h-4 ml-2 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </button>
            <div x-show="open" x-cloak class="pl-4 mt-1 space-y-1">
                <a href="{{ route('proyeks.index') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('proyeks.*') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/10' }}">Data Proyek</a>
                <a href="{{ route('manajer-proyeks.index') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('manajer-proyeks.*') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/10' }}">Data Manajer Proyek</a>
                <a href="{{ route('jenis-proyeks.index') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('jenis-proyeks.*') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/10' }}">Data Jenis Proyek</a>
            </div>
        </div>
        <a href="{{ route('kriterias.index') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('kriterias.index') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/20' }}">Data Kriteria</a>
        <a href="{{ route('subkriterias.index') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('subkriterias.*') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/20' }}">Data Sub-Kriteria</a>
        @can('penilaian')
        <a href="{{ route('penilaian.index') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('penilaian.index') || request()->routeIs('penilaian.create_edit') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/20' }}">Penilaian Proyek</a>
        <a href="{{ route('awards.ranking') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('awards.ranking') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/20' }}">Hasil Ranking</a>
        @endcan
        <a href="{{ route('awards.history') }}" class="block py-2 px-4 rounded-lg font-medium transition-all duration-200 {{ request()->routeIs('awards.history') || request()->routeIs('awards.history.detail') ? 'bg-white/80 text-indigo-700 shadow' : 'text-white hover:bg-white/20' }}">Riwayat Ranking</a>
    </nav>
</div>