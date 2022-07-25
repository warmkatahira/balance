<script src="{{ asset('js/home.js') }}" defer></script>
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
                <p class="mt-3">売上</p>
                <p class="text-2xl font-bold py-5">{{ is_null($base_result) == true ? 0 : number_format($base_result->total_sales) }}円</p>
            </div>
            <div class="col-span-2 rounded-lg text-center bg-black text-white">
                <p class="mt-3">経費</p>
                <p class="text-2xl font-bold py-5">{{ is_null($base_result) == true ? 0 : number_format($base_result->total_expenses) }}円</p>
            </div>
            <div class="col-span-2 rounded-lg text-center bg-black text-white">
                <p class="mt-3">利益</p>
                <p class="text-2xl font-bold py-5">{{ is_null($base_result) == true ? 0 : number_format($base_result->total_profit) }}円</p>
            </div>
            <div class="col-span-2 rounded-lg text-center bg-black text-white">
                <p class="mt-3">月額経費</p>
                <p class="text-2xl font-bold py-5">{{ number_format($total_monthly_expenses_amount) }}円</p>
            </div>
            <div class="col-start-11 col-span-2 rounded-lg text-center bg-amber-600 text-white">
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
                <p id="progress_per" class="col-span-12 row-span-2 bg-black text-white text-center font-bold text-2xl rounded-t-lg py-3"></p>
                <div class="bg-white shadow-lg rounded-b-lg col-span-12 row-span-10">
                    <canvas id="progress_chart" class="w-full"></canvas>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>