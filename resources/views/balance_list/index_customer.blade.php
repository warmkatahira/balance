<script src="{{ asset('js/customer_monthly_chart.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-1">
                <a href="{{ session('index_url') }}" class="inline-block text-center w-full bg-black text-white border font-semibold rounded hover:bg-gray-400 px-3 py-2">戻る</a>
            </div>
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                収支詳細
            </div>
            <div class="col-span-2">
                <p class="font-bold">拠点</p>
                <p class="font-bold py-1">{{ $customer->base->base_name }}</p>
            </div>
            <div class="col-span-2">
                <p class="font-bold">荷主名</p>
                <p class="font-bold py-1">{{ $customer->customer_name }}</p>
            </div>
        </div>
    </x-slot>
    <!-- グラフを表示 -->
    <div class="py-5 mx-5 grid grid-cols-12">
        <div class="col-span-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <canvas id="sales_chart" class="w-full"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- 収支一覧 -->
    <div class="py-5 mx-5 grid grid-cols-12">
        <table class="text-sm mb-5 col-span-7">
            <thead>
                <tr class="text-white bg-gray-600 border-gray-600">
                    <th class="p-2 px-2 w-3/12 text-left">収支期間</th>
                    <th class="p-2 px-2 w-2/12 text-right">売上</th>
                    <th class="p-2 px-2 w-2/12 text-right">経費</th>
                    <th class="p-2 px-2 w-2/12 text-right">利益</th>
                    <th class="p-2 px-2 w-3/12 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($balances as $balance)
                    <tr class="hover:bg-teal-100">
                        <td class="p-1 px-2 border">{{ $balance->date }}</td>
                        <td class="p-1 px-2 border text-right">{{ number_format($balance->total_sales) }}円</td>
                        <td class="p-1 px-2 border text-right">{{ number_format($balance->total_expenses) }}円</td>
                        <td class="p-1 px-2 border text-right {{ $balance->total_profit < 0 ? 'text-red-400 font-bold bg-rose-100' : '' }}">{{ number_format($balance->total_profit) }}円</td>
                        <td class="p-1 px-2 border text-center"><a href="{{ route('balance_list.detail', ['balance_id' => $balance->balance_id]) }}" class="bg-sky-400 text-white text-xs p-1 hover:bg-gray-400">詳細</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
