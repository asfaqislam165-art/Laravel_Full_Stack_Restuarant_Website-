@extends('layouts.admin')

@section('content')
<!-- 9 Live Database Statistics Cards -->


<!-- Real Monthly Orders vs Target Chart -->
<div class="border border-[#173C32]/15 bg-white p-6 shadow-xs">
    <div class="flex justify-between items-center">
        <h2 class="text-base font-bold text-[#173C32]">Monthly Orders Performance (Last 6 Months)</h2>
        <span class="text-xs text-gray-500">Live MySQL Data</span>
    </div>
    <div class="mt-4 h-64">
        <canvas id="orders-target-combo-chart" role="img"></canvas>
    </div>
</div>

<!-- Live Filterable Recent Orders Table (Real Database Records) -->
<div class="border border-[#173C32]/15 bg-white p-6 shadow-xs">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-base font-bold text-[#173C32]">Recent Orders</h2>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <!-- Instant Search Input -->
            <div class="relative">
                <input type="text" id="order-search-input" placeholder="Search order #, name, phone..."
                       class="w-full border-gray-300 py-1.5 text-sm text-gray-900 sm:w-64 pr-9 focus:border-[#C6A15B] focus:ring-[#C6A15B]" />
                <span class="pointer-events-none absolute inset-y-0 right-0 grid w-8 place-content-center text-gray-400">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </span>
            </div>

            <!-- Payment Status Filter Tabs -->
            <div class="inline-flex border border-gray-200 p-0.5 text-xs font-semibold">
                <button type="button" data-order-status-filter="all" aria-pressed="true" class="bg-[#173C32] text-[#C6A15B] px-3 py-1">All</button>
                <button type="button" data-order-status-filter="paid" aria-pressed="false" class="px-3 py-1 text-gray-600">Paid</button>
                <button type="button" data-order-status-filter="unpaid" aria-pressed="false" class="px-3 py-1 text-gray-600">Unpaid</button>
                <button type="button" data-order-status-filter="refunded" aria-pressed="false" class="px-3 py-1 text-gray-600">Refunded</button>
            </div>
        </div>
    </div>

    <div class="mt-4 overflow-x-auto">
        <table class="min-w-full divide-y-2 divide-gray-200 text-sm">
            <thead class="text-left text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-3 py-3">Order #</th>
                    <th class="px-3 py-3">Customer</th>
                    <th class="px-3 py-3">Date</th>
                    <th class="px-3 py-3">Order Status</th>
                    <th class="px-3 py-3">Payment</th>
                    <th class="px-3 py-3">Amount</th>
                    <th class="px-3 py-3">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                @forelse($recentOrders as $order)
                <tr data-order-row data-order-status="{{ strtolower($order->payment_status) }}" class="hover:bg-[#F7F3EA]/60">
                    <td class="px-3 py-3 font-bold text-[#173C32] whitespace-nowrap">{{ $order->order_number }}</td>
                    <td class="px-3 py-3 whitespace-nowrap">
                        {{ $order->customer_name }}
                        <span class="block text-xs text-gray-500">{{ $order->phone }}</span>
                    </td>
                    <td class="px-3 py-3 text-gray-600 whitespace-nowrap">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="px-3 py-3 whitespace-nowrap">
                        <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-800">
                            {{ $order->order_status }}
                        </span>
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap">
                        @if($order->payment_status === 'Paid')
                            <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700">Paid</span>
                        @elseif($order->payment_status === 'Refunded')
                            <span class="rounded-full bg-gray-200 px-2.5 py-0.5 text-xs font-semibold text-gray-700">Refunded</span>
                        @else
                            <span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-700">Unpaid</span>
                        @endif
                    </td>
                    <td class="px-3 py-3 font-bold whitespace-nowrap">${{ number_format($order->total, 2) }}</td>
                    <td class="px-3 py-3 whitespace-nowrap">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-[#173C32] font-bold underline hover:text-[#C6A15B]">Manage</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-3 py-6 text-center text-gray-500">No orders placed yet.</td>
                </tr>
                @endforelse

                <tr id="orders-empty-row" class="hidden">
                    <td class="px-3 py-6 text-center text-gray-600" colspan="7">No orders match your filter.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js"></script>
<script>
    const chartLabels = @json($chartLabels);
    const chartData = @json($chartOrderCounts);
    const ordersTargetComboChartCanvas = document.getElementById('orders-target-combo-chart');

    new Chart(ordersTargetComboChartCanvas, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [
                {
                    type: 'bar',
                    label: 'Actual Orders',
                    data: chartData,
                    backgroundColor: '#173C32',
                    hoverBackgroundColor: '#244D40',
                    borderRadius: 4,
                    maxBarThickness: 36,
                    order: 2,
                },
                {
                    type: 'line',
                    label: 'Monthly Goal',
                    data: [50, 60, 75, 90, 100, 120],
                    borderColor: '#C6A15B',
                    backgroundColor: '#C6A15B',
                    borderWidth: 2,
                    borderDash: [6, 4],
                    pointRadius: 3,
                    fill: false,
                    order: 1,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { position: 'bottom' } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, ticks: { precision: 0 } },
            },
        },
    });

    // Live Search & Payment Filter Script
    const orderSearchInput = document.getElementById('order-search-input');
    const orderStatusFilterButtons = document.querySelectorAll('[data-order-status-filter]');
    const orderRows = document.querySelectorAll('[data-order-row]');
    const ordersEmptyRow = document.getElementById('orders-empty-row');
    let selectedOrderStatusFilter = 'all';

    function refreshOrderRows() {
        const searchTerm = orderSearchInput.value.trim().toLowerCase();
        let visibleRowCount = 0;

        orderRows.forEach((row) => {
            const matchesSearch = row.textContent.toLowerCase().includes(searchTerm);
            const matchesStatus = selectedOrderStatusFilter === 'all' || row.dataset.orderStatus === selectedOrderStatusFilter;
            const isVisible = matchesSearch && matchesStatus;

            row.classList.toggle('hidden', !isVisible);
            if (isVisible) visibleRowCount++;
        });

        ordersEmptyRow.classList.toggle('hidden', visibleRowCount > 0 || orderRows.length === 0);
    }

    orderSearchInput.addEventListener('input', refreshOrderRows);

    orderStatusFilterButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            selectedOrderStatusFilter = btn.dataset.orderStatusFilter;
            orderStatusFilterButtons.forEach((other) => {
                const active = other === btn;
                other.setAttribute('aria-pressed', String(active));
                other.classList.toggle('bg-[#173C32]', active);
                other.classList.toggle('text-[#C6A15B]', active);
                other.classList.toggle('text-gray-600', !active);
            });
            refreshOrderRows();
        });
    });
</script>
@endsection