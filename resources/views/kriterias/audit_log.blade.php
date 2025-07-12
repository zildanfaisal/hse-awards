<x-app-layout>
    <x-slot name="title">Audit Log Perubahan Kriteria</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Audit Log Perubahan Kriteria') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-2xl p-8">
                <h3 class="font-bold text-lg mb-4">Riwayat Perubahan Kriteria</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gray-100 text-center">
                            <tr>
                                <th class="px-3 py-2">Waktu</th>
                                <th class="px-3 py-2">User</th>
                                <th class="px-3 py-2">Kriteria</th>
                                <th class="px-3 py-2">Field</th>
                                <th class="px-3 py-2">Nilai Lama</th>
                                <th class="px-3 py-2">Nilai Baru</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100 text-center">
                            @forelse($logs as $log)
                            <tr>
                                <td class="px-3 py-2">{{ $log->changed_at ? $log->changed_at->format('d M Y H:i') : '-' }}</td>
                                <td class="px-3 py-2">{{ $log->user->name ?? '-' }}</td>
                                <td class="px-3 py-2">{{ $log->kriteria->nama_kriteria ?? '-' }}</td>
                                <td class="px-3 py-2">{{ $log->field }}</td>
                                <td class="px-3 py-2">{{ $log->old_value }}</td>
                                <td class="px-3 py-2">{{ $log->new_value }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data perubahan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $logs->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout> 