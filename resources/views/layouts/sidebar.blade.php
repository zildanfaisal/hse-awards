<!-- resources/views/layouts/sidebar.blade.php -->
<div class="w-64 bg-white shadow-md fixed h-full">
    <div class="p-4 border-b">
        <div class="text-xl font-bold">Logo</div>
    </div>
    
    <div class="p-4 border-b">
        <a href="{{ route('profile.edit') }}" class="block hover:bg-gray-50 rounded -mx-2 -my-1 px-2 py-1">
            <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
        </a>
    </div>
    
    <nav class="mt-4">
        <a href="{{ route('dashboard') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-gray-100 font-medium' : '' }}">Dashboard</a>
        @auth
            @if(Auth::user()->role === 'super-admin')
                <a href="{{ route('users.index') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('users.*') ? 'bg-gray-100 font-medium' : '' }}">Users</a>
            @endif
        @endauth
        <a href="{{ route('proyeks.index') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100">Data Proyek</a>
        <a href="{{ route('kriterias.index') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100">Data Kriteria</a>
        <a href="{{ route('subkriterias.index') }}" class="block py-2 px-4 text-gray-700 hover:bg-gray-100">Data Sub-Kriteria</a>
    </nav>
    
    <div class="absolute bottom-0 w-full p-4 border-t">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left text-gray-700 hover:text-gray-900">
                Logout
            </button>
        </form>
    </div>
</div>