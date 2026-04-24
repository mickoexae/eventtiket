<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tiket Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3">ID Order</th>
                            <th class="px-6 py-3">Tanggal Order</th>
                            <th class="px-6 py-3">Total</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
    {{-- Pastikan ada @foreach di sini --}}
    @foreach($orders as $order) 
    <tr class="border-b">
        <td class="py-4 text-sm font-bold text-gray-600">#ORD-{{ $order->id_order }}</td>
        <td class="text-sm text-gray-500">{{ $order->tanggal_order }}</td>
        <td class="font-bold text-green-600">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
        <td>
            <span class="px-2 py-1 rounded text-xs font-black {{ $order->status == 'paid' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                {{ strtoupper($order->status) }}
            </span>
        </td>
        <td class="text-blue-600 font-bold">
            {{-- Ini tombol detail yang kita bahas tadi --}}
            <a href="{{ route('user.order.detail', $order->id_order) }}" class="hover:underline">Detail</a>
        </td>
    </tr>
    @endforeach
</tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>