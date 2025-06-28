<x-app-layout>
    <x-slot name="title">HSE Awards | Tambah Role</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Role</h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-8">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Role</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Akses Fitur</label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($permissions as $perm)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" class="mr-2">
                                        {{ $perm->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex justify-end pt-4">
                            <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-gray-100 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-200">Batal</a>
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>