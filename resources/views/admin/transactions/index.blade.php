<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Transaksi Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert Sukses --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Booking</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penerbangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi Manual</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                @forelse($transactions as $trx)
                                    <tr class="hover:bg-gray-50">
                                        {{-- Kode Booking --}}
                                        <td class="px-6 py-4 font-mono font-bold text-blue-600">
                                            {{ $trx->booking_code }}
                                            <div class="text-xs text-gray-400 font-sans mt-1">{{ $trx->created_at->format('d M Y H:i') }}</div>
                                        </td>

                                        {{-- User Info --}}
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-800">{{ $trx->user->name ?? 'Guest' }}</div>
                                            <div class="text-xs text-gray-500">{{ $trx->user->email ?? '-' }}</div>
                                        </td>

                                        {{-- Detail Flight --}}
                                        <td class="px-6 py-4">
                                            <div class="font-bold">{{ $trx->flight->airline->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-600">
                                                {{ $trx->flight->origin->iata_code ?? '?' }} &rarr; {{ $trx->flight->destination->iata_code ?? '?' }}
                                            </div>
                                        </td>

                                        {{-- Total Harga --}}
                                        <td class="px-6 py-4 font-bold text-gray-700">
                                            Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
                                            <div class="text-xs font-normal text-gray-400">{{ $trx->total_passengers }} Penumpang</div>
                                        </td>

                                        {{-- Status Badge --}}
                                        <td class="px-6 py-4 text-center">
                                            @if($trx->status == 'paid')
                                                <span class="px-2 py-1 text-xs font-bold text-green-700 bg-green-100 rounded-full">LUNAS</span>
                                            @elseif($trx->status == 'pending')
                                                <span class="px-2 py-1 text-xs font-bold text-yellow-700 bg-yellow-100 rounded-full">PENDING</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-bold text-red-700 bg-red-100 rounded-full">{{ strtoupper($trx->status) }}</span>
                                            @endif
                                        </td>

                                        {{-- Tombol Aksi --}}
                                        <td class="px-6 py-4 text-center">
                                            @if($trx->status == 'pending')
                                                <div class="flex justify-center gap-2">
                                                    {{-- Tombol Terima (Confirm) --}}
                                                    <form action="{{ route('admin.transactions.confirm', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengonfirmasi pembayaran ini secara manual?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded text-xs font-bold shadow transition" title="Konfirmasi Pembayaran">
                                                            <i class="fa-solid fa-check"></i> Terima
                                                        </button>
                                                    </form>

                                                    {{-- Tombol Tolak (Cancel) --}}
                                                    <form action="{{ route('admin.transactions.cancel', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1.5 rounded text-xs font-bold shadow transition" title="Batalkan Pesanan">
                                                            <i class="fa-solid fa-xmark"></i> Tolak
                                                        </button>
                                                    </form>
                                                </div>
                                            @elseif($trx->status == 'paid')
                                                <span class="text-xs text-gray-400 italic">Selesai</span>
                                            @else
                                                <span class="text-xs text-gray-400 italic">Dibatalkan</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                            <i class="fa-solid fa-receipt text-4xl mb-2"></i>
                                            <p>Belum ada transaksi masuk.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>