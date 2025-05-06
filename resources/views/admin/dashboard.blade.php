<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ダッシュボード
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white p-6 rounded shadow">
            <div class="flex flex-wrap gap-4 justify-center">
                <!-- 円グラフ（左） -->
                <div class="w-full md:w-1/3">
                    <h3 class="text-lg font-semibold mb-4 text-center">参加・キャンセル割合</h3>
                    <div class="w-35 h-35 mx-auto">
                        <canvas id="pieChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- 棒グラフ（右） -->
                <div class="w-full md:w-2/3">
                    <h3 class="text-lg font-semibold mb-4 text-center">イベントごとの参加者数</h3>
                    <div style="height: 500px;">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js scripts -->
    <script>
        const ctx = document.getElementById('barChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($participationData->pluck('title')),
                datasets: [{
                    label: '参加者数',
                    data: @json($participationData->pluck('count')),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['参加済み', 'キャンセル済み'],
                datasets: [{
                    data: [{{ $cancelStats->joined }}, {{ $cancelStats->canceled }}],
                    backgroundColor: ['#4CAF50', '#F44336']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
</x-app-layout>
