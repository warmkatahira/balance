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
    
    <div class="py-5 mx-5 grid grid-cols-12">
        <!-- 日別のグラフを表示 -->
        <div class="col-span-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg overflow-x-scroll relative">
                <div class="p-6 bg-white border-b border-gray-200">
                    <canvas id="sales_chart_daily" class="w-full"></canvas>
                </div>
            </div>
        </div>
        <!-- 月別のグラフを表示 -->
        <div class="col-start-10 col-span-3 grid grid-cols-12">
            <div class="col-span-12">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white border-b border-gray-200">
                        <canvas id="sales_chart_monthly" class="w-full"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-span-12">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white border-b border-gray-200">
                        <canvas id="expenses_chart_monthly" class="w-full"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- カテゴリ毎の合計 -->
    <div class="py-5 mx-5 grid grid-cols-12 grid-flow-col grid-rows-6 gap-4">
        <div class="row-span-3 col-span-4 grid grid-cols-12 bg-orange-100 pb-3 px-3 text-center rounded-lg border border-black text-sm">
            <p class="text-xl col-span-12 border-b-2 border-black py-3 mb-3">荷役</p>
            <p class="col-span-3">荷役売上</p>
            <p class="col-start-5 col-span-3">人件費</p>
            <p class="col-start-1 col-span-3">{{ number_format($total_amount['total_cargo_handling_amount']) }}円</p>
            <p class="col-span-1 py-1"><i class="las la-minus"></i></p>
            <p class="col-span-3">{{ number_format($total_amount['total_labor_costs']) }}円</p>
            <p class="col-span-1 py-1 text-right"><i class="las la-equals"></i></p>
            <p class="col-span-4">{{ number_format($total_amount['total_cargo_handling_amount'] - $total_amount['total_labor_costs']) }}円</p>
        </div>
        <div class="row-span-3 col-span-4 grid grid-cols-12 bg-orange-100 pb-3 px-3 text-center rounded-lg border border-black text-sm">
            <p class="text-xl col-span-12 border-b-2 border-black py-3 mb-3">運賃</p>
            <p class="col-span-3">運賃売上</p>
            <p class="col-start-5 col-span-3">運賃経費</p>
            <p class="col-start-1 col-span-3">{{ number_format($total_amount['total_fare_sales_amount']) }}円</p>
            <p class="col-span-1 py-1"><i class="las la-minus"></i></p>
            <p class="col-span-3">{{ number_format($total_amount['total_fare_expenses_amount']) }}円</p>
            <p class="col-span-1 py-1 text-right"><i class="las la-equals"></i></p>
            <p class="col-span-4">{{ number_format($total_amount['total_fare_sales_amount'] - $total_amount['total_fare_expenses_amount']) }}円</p>
        </div>
        <div class="row-span-3 col-span-4 grid grid-cols-12 bg-orange-100 pb-3 px-3 text-center rounded-lg border border-black text-sm">
            <p class="text-xl col-span-12 border-b-2 border-black py-3 mb-3">保管</p>
            <p class="col-span-3">保管売上</p>
            <p class="col-start-5 col-span-3">保管経費</p>
            <p class="col-start-1 col-span-3">{{ number_format($total_amount['total_storage_fee']) }}円</p>
            <p class="col-span-1 py-1"><i class="las la-minus"></i></p>
            <p class="col-span-3">{{ number_format($total_amount['total_storage_expenses']) }}円</p>
            <p class="col-span-1 py-1 text-right"><i class="las la-equals"></i></p>
            <p class="col-span-4">{{ number_format($total_amount['total_storage_fee'] - $total_amount['total_storage_expenses']) }}円</p>
        </div>
        <div class="row-span-3 col-span-4 grid grid-cols-12 bg-orange-100 pb-3 px-3 text-center rounded-lg border border-black text-sm">
            <p class="text-xl col-span-12 border-b-2 border-black py-3 mb-3">その他</p>
            <p class="col-span-3">その他売上</p>
            <p class="col-start-5 col-span-3">その他経費</p>
            <p class="col-start-1 col-span-3">{{ number_format($total_amount['total_other_sales_amount']) }}円</p>
            <p class="col-span-1 py-1"><i class="las la-minus"></i></p>
            <p class="col-span-3">{{ number_format($total_amount['total_other_expenses_amount']) }}円</p>
            <p class="col-span-1 py-1 text-right"><i class="las la-equals"></i></p>
            <p class="col-span-4">{{ number_format($total_amount['total_other_sales_amount'] - $total_amount['total_other_expenses_amount']) }}円</p>
        </div>
        <div class="row-span-6 col-span-4 grid grid-cols-12 bg-orange-100 pb-3 px-3 text-center rounded-lg border border-black">
            <p class="text-xl col-span-12 border-b-2 border-black pt-10">結果</p>
            <p class="col-span-3 py-10">売上合計</p>
            <p class="col-start-5 col-span-3 py-10">経費合計</p>
            <p class="col-start-1 col-span-3">{{ number_format($total_amount['total_sales']) }}円</p>
            <p class="col-span-1 py-1"><i class="las la-minus"></i></p>
            <p class="col-span-3">{{ number_format($total_amount['total_expenses']) }}円</p>
            <p class="col-span-1 py-1 text-right"><i class="las la-equals"></i></p>
            <p class="col-span-4">{{ number_format($total_amount['total_sales'] - $total_amount['total_expenses']) }}円</p>
        </div>
    </div>
    <!-- 収支一覧 -->
    <div class="py-5 mx-5 grid grid-cols-12">
        <table class="text-sm mb-5 col-start-4 col-span-6">
            <thead>
                <tr class="text-white bg-gray-600 border-gray-600">
                    <th class="p-2 px-2 w-2/12 text-left">収支期間</th>
                    <th class="p-2 px-2 w-2/12 text-right">売上</th>
                    <th class="p-2 px-2 w-2/12 text-right">経費</th>
                    <th class="p-2 px-2 w-2/12 text-right">利益</th>
                    <th class="p-2 px-2 w-2/12 text-right">利益率</th>
                    <th class="p-2 px-2 w-2/12 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($balances as $balance)
                    <tr class="hover:bg-teal-100">
                        <td class="p-1 px-2 border">{{ $balance->date }}</td>
                        <td class="p-1 px-2 border text-right">{{ number_format($balance->total_sales) }}円</td>
                        <td class="p-1 px-2 border text-right">{{ number_format($balance->total_expenses) }}円</td>
                        <td class="p-1 px-2 border text-right {{ $balance->total_profit < 0 ? 'text-red-400 font-bold bg-rose-100' : '' }}">{{ number_format($balance->total_profit) }}円</td>
                        <td class="p-1 px-2 border text-right {{ $balance->profit_per < 0 ? 'text-red-400 font-bold bg-rose-100' : '' }}">{{ round($balance->profit_per,2) }}%</td>
                        <td class="p-1 px-2 border text-center"><a href="{{ route('balance_list.detail', ['balance_id' => $balance->balance_id]) }}" class="bg-sky-400 text-white text-xs p-1 hover:bg-gray-400">詳細</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
