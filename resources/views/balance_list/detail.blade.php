<script src="{{ asset('js/balance_detail_chart.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-1">
                <a href="{{ session('previous_url') }}" class="inline-block text-center w-full bg-black text-white border font-semibold rounded hover:bg-gray-400 px-3 py-2">戻る</a>
            </div>
            <div class="col-span-4">
                <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                    収支詳細
                </div>
            </div>
            <div class="col-start-9 col-span-2 rounded-lg text-center">
                <p class="font-bold">登録者</p>
                <p class="font-bold py-1 text-sm">{{ $balance->user->name }}<br><span class="">{{ $balance->created_at }}</span></p>
            </div>
            <div class="col-start-11 col-span-2 rounded-lg text-center">
                <p class="font-bold">最終更新者</p>
                <p class="font-bold py-1 text-sm">{{ $balance->last_updated_user->name }}<br><span class="">{{ $balance->updated_at }}</span></p>
            </div>
        </div>
    </x-slot>
    <div class="py-5 mx-5 grid grid-cols-12">
        <div class="col-span-12 grid grid-cols-12 gap-4 mb-5">
            <div class="col-span-2 rounded-lg text-center bg-black text-white">
                <p class="mt-3 font-bold">拠点</p>
                <p class="font-bold py-5 text-sm">{{ $balance->base->base_name }}</p>
            </div>
            <div class="col-span-2 rounded-lg text-center bg-black text-white">
                <p class="mt-3 font-bold">収支日</p>
                <p class="font-bold py-5">{{ $balance->balance_date }}</p>
            </div>
            <div class="col-span-2 rounded-lg text-center bg-black text-white">
                <p class="mt-3 font-bold">荷主名</p>
                <p class="font-bold py-5 text-sm">{{ $balance->customer->customer_name }}</p>
            </div>
            <div class="col-span-2 rounded-lg text-center bg-black text-white">
                <p class="mt-3 font-bold">売上</p>
                <p class="font-bold py-5 text-2xl">{{ number_format($balance->sales) }}円</p>
            </div>
            <div class="col-span-2 rounded-lg text-center bg-black text-white">
                <p class="mt-3 font-bold">経費</p>
                <p class="font-bold py-5 text-2xl">{{ number_format($balance->expenses) }}円</p>
            </div>
            <div class="col-span-2 rounded-lg text-center bg-black text-white">
                <p class="mt-3 font-bold">利益</p>
                <p class="font-bold py-5 text-2xl">{{ number_format($balance->profit) }}円</p>
            </div>
        </div>
        <!-- 収支情報を表示 -->
        <div class="col-span-7 text-sm">
            <div class="grid grid-cols-12 py-2 bg-gray-600 text-white text-base font-bold">
                <p class="col-span-12 text-center">売上</p>
            </div>
            <!-- （売上）運賃関連 -->
            @if(count($balance_fare_sales))
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <label class="col-span-3 font-bold">売上<i class="las la-caret-right"></i>運賃関連</label>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <p class="col-start-2 col-span-3 border-b-2 border-gray-400">配送方法</p>
                    <p class="col-span-2 text-right border-b-2 border-gray-400">個口数</p>
                    <p class="col-span-2 text-right border-b-2 border-gray-400">運賃単価</p>
                    <p class="col-span-3 text-right border-b-2 border-gray-400">金額</p>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    @foreach($balance_fare_sales as $balance_fare)
                        <p class="col-start-2 col-span-3">{{ $balance_fare->shipping_method_name }}</p>
                        <p class="col-span-2 text-right">{{ number_format($balance_fare->box_quantity) }}個口</p>
                        <p class="col-span-2 text-right">{{ number_format($balance_fare->fare_unit_price) }}円</p>
                        <p class="col-span-3 text-right">{{ number_format($balance_fare->fare_amount) }}円</p>
                    @endforeach
                </div>
                <div class="grid grid-cols-12 py-1 border-y-2 border-gray-400 bg-yellow-200">
                    <p class="col-start-2 col-span-3">合計</p>
                    <p class="col-start-5 col-span-2 text-right">{{ number_format($total_amount['total_sales_box_quantity']) }}個口</p>
                    <p class="col-start-9 col-span-3 text-right">{{ number_format($total_amount['total_fare_sales_amount']) }}円</p>
                </div>
            @endif
            <!-- （売上）荷役関連 -->
            @if(count($balance_cargo_handlings))
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <label class="col-span-3 font-bold">売上<i class="las la-caret-right"></i>荷役関連</label>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <p class="col-start-2 col-span-3 border-b-2 border-gray-400">荷役名</p>
                    <p class="col-span-2 text-right border-b-2 border-gray-400">作業数</p>
                    <p class="col-span-2 text-right border-b-2 border-gray-400">荷役単価</p>
                    <p class="col-span-3 text-right border-b-2 border-gray-400">金額</p>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    @foreach($balance_cargo_handlings as $balance_cargo_handling)
                        <p class="col-start-2 col-span-3">{{ $balance_cargo_handling->cargo_handling_name.'【'.$balance_cargo_handling->cargo_handling_note.'】' }}</p>
                        <p class="col-span-2 text-right">{{ number_format($balance_cargo_handling->operation_quantity) }}作業</p>
                        <p class="col-span-2 text-right">{{ number_format($balance_cargo_handling->cargo_handling_unit_price) }}円</p>
                        <p class="col-span-3 text-right">{{ number_format($balance_cargo_handling->cargo_handling_amount) }}円</p>
                    @endforeach
                </div>
                <div class="grid grid-cols-12 py-1 border-y-2 border-gray-400 bg-yellow-200">
                    <p class="col-start-2 col-span-3">合計</p>
                    <p class="col-start-5 col-span-2 text-right">{{ number_format($total_amount['total_operation_quantity']) }}作業</p>
                    <p class="col-start-9 col-span-3 text-right">{{ number_format($total_amount['total_cargo_handling_amount']) }}円</p>
                </div>
            @endif
            <!-- （売上）保管関連 -->
            @if($balance->storage_fee != 0)
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <label class="col-span-3 font-bold">売上<i class="las la-caret-right"></i>保管関連</label>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <p class="col-start-2 col-span-10 text-right border-b-2 border-gray-400">金額</p>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <p class="col-start-9 col-span-3 text-right">{{ number_format($balance->storage_fee) }}円</p>
                </div>
                <div class="grid grid-cols-12 py-1 border-y-2 border-gray-400 bg-yellow-200">
                    <p class="col-start-2 col-span-3">合計</p>
                    <p class="col-start-9 col-span-3 text-right">{{ number_format($balance->storage_fee) }}円</p>
                </div>
            @endif
            <!-- （売上）その他 -->
            @if(count($balance_other_sales))
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <label class="col-span-3 font-bold">売上<i class="las la-caret-right"></i>その他</label>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <p class="col-start-2 col-span-2 border-b-2 border-gray-400">売上名</p>
                    <p class="col-start-4 col-span-5 border-b-2 border-gray-400">備考</p>
                    <p class="col-start-9 col-span-3 text-right border-b-2 border-gray-400">金額</p>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    @foreach($balance_other_sales as $balance_other_sale)
                        <p class="col-start-2 col-span-2">{{ $balance_other_sale->other_sales_name }}</p>
                        <p class="col-start-4 col-span-5">{{ $balance_other_sale->other_sales_note }}</p>
                        <p class="col-start-9 col-span-3 text-right">{{ number_format($balance_other_sale->other_sales_amount) }}円</p>
                    @endforeach
                </div>
                <div class="grid grid-cols-12 py-1 border-y-2 border-gray-400 bg-yellow-200">
                    <p class="col-start-2 col-span-3">合計</p>
                    <p class="col-start-9 col-span-3 text-right">{{ number_format($total_amount['total_other_sales_amount']) }}円</p>
                </div>
            @endif
            <!-- 売上合計 -->
            <div class="grid grid-cols-12 py-3 border-b-2 border-gray-400 bg-orange-200 text-base font-bold">
                <p class="col-start-2 col-span-3">売上合計</p>
                <p class="col-start-9 col-span-3 text-right">{{ number_format($balance->sales) }}円</p>
            </div>
            <div class="grid grid-cols-12 py-2 bg-gray-600 text-white text-base font-bold">
                <p class="col-span-12 text-center">経費</p>
            </div>
            @if(count($balance_fare_expenses))
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <label class="col-span-3 font-bold">経費<i class="las la-caret-right"></i>運賃関連</label>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <p class="col-start-2 col-span-3 border-b-2 border-gray-400">配送方法</p>
                    <p class="col-span-2 text-right border-b-2 border-gray-400">個口数</p>
                    <p class="col-span-2 text-right border-b-2 border-gray-400">運賃単価</p>
                    <p class="col-span-3 text-right border-b-2 border-gray-400">金額</p>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    @foreach($balance_fare_expenses as $balance_fare)
                        <p class="col-start-2 col-span-3">{{ $balance_fare->shipping_method_name }}</p>
                        <p class="col-span-2 text-right">{{ number_format($balance_fare->box_quantity) }}個口</p>
                        <p class="col-span-2 text-right">{{ number_format($balance_fare->fare_unit_price) }}円</p>
                        <p class="col-span-3 text-right">{{ number_format($balance_fare->fare_amount) }}円</p>
                    @endforeach
                </div>
                <div class="grid grid-cols-12 py-1 border-y-2 border-gray-400 bg-yellow-200">
                    <p class="col-start-2 col-span-3">合計</p>
                    <p class="col-start-5 col-span-2 text-right">{{ number_format($total_amount['total_expenses_box_quantity']) }}個口</p>
                    <p class="col-start-9 col-span-3 text-right">{{ number_format($total_amount['total_fare_expenses_amount']) }}円</p>
                </div>
            @endif
            <!-- （経費）人件費関連 -->
            @if(count($balance_labor_costs))
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <label class="col-span-3 font-bold">経費<i class="las la-caret-right"></i>人件費関連</label>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <p class="col-start-2 col-span-3 border-b-2 border-gray-400">人件費区分</p>
                    <p class="col-span-2 text-right border-b-2 border-gray-400">労働時間</p>
                    <p class="col-span-2 text-right border-b-2 border-gray-400">時給単価</p>
                    <p class="col-span-3 text-right border-b-2 border-gray-400">金額</p>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    @foreach($balance_labor_costs as $balance_labor_cost)
                        <p class="col-start-2 col-span-3">{{ $balance_labor_cost->labor_cost_name }}</p>
                        <p class="col-span-2 text-right">{{ $balance_labor_cost->working_time }}時間</p>
                        <p class="col-span-2 text-right">{{ number_format($balance_labor_cost->hourly_wage) }}円</p>
                        <p class="col-span-3 text-right">{{ number_format($balance_labor_cost->labor_costs) }}円</p>
                    @endforeach
                </div>
                <div class="grid grid-cols-12 py-1 border-y-2 border-gray-400 bg-yellow-200">
                    <p class="col-start-2 col-span-3">合計</p>
                    <p class="col-start-5 col-span-2 text-right">{{ $total_amount['total_working_time'] }}時間</p>
                    <p class="col-start-9 col-span-3 text-right">{{ number_format($total_amount['total_labor_costs_amount']) }}円</p>
                </div>
            @endif
            <!-- （経費）保管関連 -->
            @if($balance->storage_expenses != 0)
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <label class="col-span-3 font-bold">経費<i class="las la-caret-right"></i>保管関連</label>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <p class="col-start-2 col-span-10 text-right border-b-2 border-gray-400">金額</p>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <p class="col-start-9 col-span-3 text-right">{{ number_format($balance->storage_expenses) }}円</p>
                </div>
                <div class="grid grid-cols-12 py-1 border-y-2 border-gray-400 bg-yellow-200">
                    <p class="col-start-2 col-span-3">合計</p>
                    <p class="col-start-9 col-span-3 text-right">{{ number_format($balance->storage_expenses) }}円</p>
                </div>
            @endif
            <!-- （経費）その他 -->
            @if(count($balance_other_expenses))
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <label class="col-span-3 font-bold">経費<i class="las la-caret-right"></i>その他</label>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    <p class="col-start-2 col-span-2 border-b-2 border-gray-400">経費名</p>
                    <p class="col-start-4 col-span-5 border-b-2 border-gray-400">備考</p>
                    <p class="col-start-9 col-span-3 text-right border-b-2 border-gray-400">金額</p>
                </div>
                <div class="grid grid-cols-12 pt-2 bg-white">
                    @foreach($balance_other_expenses as $balance_other_expense)
                        <p class="col-start-2 col-span-2">{{ $balance_other_expense->other_expenses_name }}</p>
                        <p class="col-start-4 col-span-5">{{ $balance_other_expense->other_expenses_note }}</p>
                        <p class="col-start-9 col-span-3 text-right">{{ number_format($balance_other_expense->other_expenses_amount) }}円</p>
                    @endforeach
                </div>
                <div class="grid grid-cols-12 py-1 border-y-2 border-gray-400 bg-yellow-200">
                    <p class="col-start-2 col-span-3">合計</p>
                    <p class="col-start-9 col-span-3 text-right">{{ number_format($total_amount['total_other_expenses_amount']) }}円</p>
                </div>
            @endif
            <!-- 経費合計 -->
            <div class="grid grid-cols-12 py-3 border-b-2 border-gray-400 bg-orange-200 text-base font-bold">
                <p class="col-start-2 col-span-3">経費合計</p>
                <p class="col-start-9 col-span-3 text-right">{{ number_format($balance->expenses) }}円</p>
            </div>
            <div class="grid grid-cols-12 py-2 bg-gray-600 text-white text-base font-bold">
                <p class="col-span-12 text-center">その他</p>
            </div>
            <!-- その他 -->
            <div class="grid grid-cols-12 pt-2 border-b-2 border-gray-400 bg-white">
                <label class="col-span-3 font-bold">備考</label>
                <div class="col-span-12 grid grid-cols-12 pt-2">
                    <p class="col-start-2 col-span-12">{!! nl2br(e($balance->balance_note)) !!}</p>
                </div>
            </div>
        </div>
        <!-- グラフを表示 -->
        <div class="col-start-9 col-span-4">
            <div class="col-span-12 grid grid-cols-12 grid-rows-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg col-span-12 row-span-1">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <canvas id="sales_chart" class="w-full"></canvas>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg col-span-12 row-span-1">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <canvas id="expenses_chart" class="w-full"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>