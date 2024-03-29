<script src="{{ asset('js/home.js') }}" defer></script>
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                ホーム
            </div>
            <form method="post" id="month_result_form" action="{{ route('home.search') }}" class="m-0 col-span-10 grid grid-cols-12 gap-4">
                @csrf
                <select id="base_select" name="base_select" class="rounded-lg text-sm col-span-2 col-start-7">
                    @foreach($bases as $base)
                        <option value="{{ $base->base_id }}" {{ session('base_id') == $base->base_id ? 'selected' : '' }}>{{ $base->base_name }}</option>
                    @endforeach
                </select>
                <input type="month" id="month_select" name="month_select" class="text-sm rounded-lg col-span-2 col-start-9" value="{{ session('nowDateYearMonth') }}">
                <input type="submit" id="disp" class="bg-black text-white text-sm font-bold text-center col-start-11 col-span-2 rounded-lg cursor-pointer hover:bg-gray-400" value="表示">
            </form>
        </div>
    </x-slot>
    <div class="py-5 mx-5 grid grid-cols-12">
        <div class="col-span-12 grid grid-cols-12 gap-4">
            <div class="col-span-2 rounded-lg text-center bg-black text-white">
                <p class="mt-3 font-bold">売上計画</p>
                <p class="text-2xl font-bold py-5">{{ is_null($sales_plan) == true ? 0 : number_format($sales_plan->sales_plan_amount) }}円</p>
            </div>
            <div class="col-start-3 col-span-2 rounded-lg text-center bg-black text-white">
                <p class="mt-3 font-bold">売上実績</p>
                <p class="text-2xl font-bold py-5">{{ is_null($base_result) == true ? 0 : number_format($base_result->total_sales) }}円</p>
            </div>
            <div class="col-span-2 rounded-lg text-center bg-black text-white">
                <p class="mt-3 font-bold">経費</p>
                <p class="text-2xl font-bold py-5">{{ is_null($base_result) == true ? 0 : number_format($base_result->total_expenses) }}円</p>
            </div>
            <div class="col-span-2 rounded-lg text-center bg-black text-white">
                <p class="mt-3 font-bold">利益</p>
                <p class="text-2xl font-bold py-5">{{ is_null($base_result) == true ? 0 : number_format($base_result->total_profit) }}円</p>
            </div>
            <div class="col-span-2 rounded-lg text-center bg-black text-white">
                <p class="mt-3 font-bold">月額経費</p>
                <p class="text-2xl font-bold py-5">{{ number_format($total_monthly_expenses_amount) }}円</p>
            </div>
            <div class="col-start-11 col-span-2 rounded-lg text-center bg-orange-400 text-white">
                <p class="mt-3">収支状況</p>
                <p class="text-2xl font-bold py-5">{{ number_format(is_null($base_result) == true ? 0 : $base_result->total_profit - $total_monthly_expenses_amount) }}円</p>
            </div>
        </div>
        <div class="col-span-7 grid grid-cols-12 grid-rows-12">
            <!-- 荷主毎の成績（売上順） -->
            <div class="col-span-12 mt-5 h-52 overflow-scroll overflow-x-hidden row-span-6">
                <p class="w-full font-bold">荷主成績</p>
                <table class="text-sm mb-5 w-full">
                    <thead>
                        <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                            <th class="p-2 px-2 w-6/12">荷主名</th>
                            <th class="p-2 px-2 w-2/12 text-right">売上金額</th>
                            <th class="p-2 px-2 w-2/12 text-right">経費金額</th>
                            <th class="p-2 px-2 w-2/12 text-right">利益金額</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($customer_results as $customer_result)
                            <tr>
                                <td class="p-1 px-2 border">{{ $customer_result->customer->customer_name }}</td>
                                <td class="p-1 px-2 border text-right">{{ number_format($customer_result->total_sales) }}</td>
                                <td class="p-1 px-2 border text-right">{{ number_format($customer_result->total_expenses) }}</td>
                                <td class="p-1 px-2 border text-right">{{ number_format($customer_result->total_profit) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- 荷主毎の成績（売上順） -->
            <div class="col-span-12 mt-5 h-52 overflow-scroll overflow-x-hidden row-span-6">
                <p class="w-full font-bold">月額経費</p>
                <table class="text-sm mb-5 w-full">
                    <thead>
                        <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                            <th class="p-2 px-2 w-8/12">経費名</th>
                            <th class="p-2 px-2 w-4/12 text-right">経費金額</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach($monthly_expenses as $monthly_expense)
                            <tr>
                                <td class="p-1 px-2 border">{{ $monthly_expense->expenses_item->expenses_item_name }}</td>
                                <td class="p-1 px-2 border text-right">{{ number_format($monthly_expense->expenses_amount) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- グラフを表示 -->
        <div class="col-start-9 col-span-4 mt-5">
            <div class="grid grid-cols-12 grid-rows-12">
                <div class="col-start-5 col-span-8 row-span-12 grid-rows-12">
                    <p id="balance_progress_per" class="col-span-12 row-span-2 bg-black text-white text-center font-bold text-2xl rounded-t-lg py-3"></p>
                    <div class="bg-white shadow-lg rounded-b-lg col-span-12 row-span-10">
                        <div id="congrats_balance_progress" class="congrats_balance_progress hidden">
                            <img src="{{ asset('images/congrats.svg') }}">
                        </div>
                        <canvas id="balance_progress_chart" class="w-full"></canvas>
                    </div>
                </div>
                <div class="col-start-5 col-span-8 row-span-12 grid-rows-12 mt-5">
                    <p id="sales_plan_progress_per" class="col-span-12 row-span-2 bg-black text-white text-center font-bold text-2xl rounded-t-lg py-3"></p>
                    <div class="bg-white shadow-lg rounded-b-lg col-span-12 row-span-10">
                        <div id="congrats_sales_plan_progress" class="congrats_sales_plan_progress hidden">
                            <img src="{{ asset('images/congrats.svg') }}">
                        </div>
                        <canvas id="sales_plan_progress_chart" class="w-full"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- 収支最新情報 -->
        <p class="col-span-12 text-2xl font-bold text-center mt-5 bg-blue-500 text-white rounded-t-lg py-2">収支最新情報</p>
        <div class="col-span-12 grid grid-cols-12 bg-sky-100 p-10 text-sm shadow-lg">
            <div class="col-span-12 grid grid-cols-12">
                <p class="col-span-2">日時</p>
                <p class="col-span-2">ユーザー</p>
                <p class="col-span-1">収支日</p>
                <p class="col-span-2">拠点</p>
                <p class="col-span-3">荷主名</p>
                <p class="col-span-1">区分</p>
            </div>
            @foreach($balance_lists as $balance_list)
                <div class="col-span-12 grid grid-cols-12 border-dotted border-t-2 border-blue-500 py-2 hover:bg-sky-300">
                    <p class="col-span-2">{{ $balance_list->updated_at }}</p>
                    <p class="col-span-2">{{ $balance_list->last_updated_user->name }}</p>
                    <p class="col-span-1">{{ $balance_list->balance_date }}</p>
                    <p class="col-span-2">{{ $balance_list->base->base_name }}</p>
                    <p class="col-span-3">{{ $balance_list->customer->customer_name }}</p>
                    <p class="col-span-1 pt-1">
                        @if($balance_list->created_at == $balance_list->updated_at)
                            <span class="bg-green-300 px-3 py-1 rounded-lg">登録</span>
                        @endif
                        @if($balance_list->created_at != $balance_list->updated_at)
                            <span class="bg-red-300 px-3 py-1 rounded-lg">修正</span>
                        @endif
                    </p>
                    <a href="{{ route('balance_list.detail', ['balance_id' => $balance_list->balance_id]) }}" class="bg-blue-500 text-white p-1 hover:bg-gray-400 text-center col-span-1">詳細</a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>