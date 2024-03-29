<script src="{{ asset('js/balance_register.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                収支登録
            </div>
        </div>
    </x-slot>
    <form method="post" id="balance_register_form" action="{{ route('balance_register.register') }}" class="m-0">
        @csrf
        <div class="p-5">
            <div class="grid grid-cols-12 bg-gray-300 p-5">
                <p class="col-span-12 text-xl mb-5 font-bold">対象</p>
                <label class="col-span-1 py-2">荷主</label>
                <select id="customer_select"  name="customer_id" class="col-span-3 text-sm">
                    <option value="0">荷主を選択</option>
                    @foreach($own_base_customers as $customer)
                        <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                    @endforeach
                </select>
                <label class="col-span-1 col-start-9 py-2">収支日</label>
                <input type="date" id="balance_date" name="balance_date" class="col-span-2 text-sm" autocomplete="off" required>
            </div>
            <div id="fare_list_sales" class="grid grid-cols-12 bg-yellow-200 p-5 mt-5">
                <p class="col-span-4 text-xl mb-5 font-bold">売上<i class="las la-caret-right"></i>運賃関連</p>
                <select id="shipping_method_select" class="text-xs h-4/5 col-start-9 col-span-3">
                    <option value="0">配送方法を選択</option>
                </select>
                <button type="button" id="shipping_method_add" class="col-start-12 col-span-1 bg-black text-white hover:bg-gray-400 text-sm h-4/5">追加</button>
                <div id="total_fare_sales_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                    <p class="col-span-2 text-right font-bold">個口合計</p>
                    <p class="col-span-1 text-right font-bold" id="total_box_quantity_sales"></p>
                    <p class="col-span-1 text-left font-bold text-xs pl-2 pt-2">個口</p>
                    <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                    <p class="col-start-9 col-span-2 text-right font-bold" id="total_fare_sales"></p>
                    <p class="col-start-11 col-span-1 text-left font-bold text-sm pl-2 pt-2">円</p>
                </div>
            </div>
            <div id="cargo_handling_list" class="grid grid-cols-12 bg-yellow-200 p-5 mt-5">
                <p class="col-span-4 text-xl mb-5 font-bold">売上<i class="las la-caret-right"></i>荷役関連</p>
                <select id="cargo_handling_select" name="cargo_handling_id" class="text-xs h-4/5 col-start-9 col-span-3">
                    <option value="0">荷役を選択</option>
                </select>
                <button type="button" id="cargo_handling_add" class="col-start-12 col-span-1 bg-black text-white hover:bg-gray-400 text-sm h-4/5">追加</button>
                <div id="total_cargo_handling_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                    <p class="col-span-2 text-right font-bold">作業合計</p>
                    <p class="col-span-1 text-right font-bold" id="total_operation_quantity"></p>
                    <p class="col-span-1 text-left font-bold text-xs pl-2 pt-2">作業</p>
                    <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                    <p class="col-start-9 col-span-2 text-right font-bold" id="total_cargo_handling"></p>
                    <p class="col-start-11 col-span-1 text-left font-bold text-sm pl-2 pt-2">円</p>
                </div>
            </div>
            <div class="grid grid-cols-12 bg-yellow-200 p-5 mt-5">
                <p class="col-span-4 text-xl mb-5 font-bold">売上<i class="las la-caret-right"></i>保管関連</p>
                <div class="col-span-12 grid grid-cols-12 border-b-2 border-black">
                    <p class="text-sm col-span-2 font-bold py-3">保管費</p>
                    <p id="storage_fee_detail" class="text-sm col-span-6 py-3"></p>
                    <input type="tel" id="storage_fee" class="col-start-9 col-span-2 text-right text-sm h-4/5 py-3 storage_fee int_validation" name="storage_fee" autocomplete="off" placeholder="保管売上">
                    <p class="col-span-1 text-left text-sm pl-2 pt-5">円</p>
                </div>
                <div id="total_storage_fee_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                    <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                    <p class="col-start-9 col-span-2 text-right font-bold" id="total_storage_fee"></p>
                    <p class="col-start-11 col-span-1 text-left font-bold text-sm pl-2 pt-2">円</p>
                </div>
            </div>
            <div id="other_sales_list" class="grid grid-cols-12 bg-yellow-200 p-5 mt-5">
                <p class="col-span-4 text-xl mb-5 font-bold">売上<i class="las la-caret-right"></i>その他</p>
                <select id="other_sales_select" class="text-xs h-4/5 col-start-9 col-span-3">
                    <option value="0">その他売上を選択</option>
                    @foreach($sales_items as $sales_item)
                        <option value="{{ $sales_item->sales_item_id }}">{{ $sales_item->sales_item_name }}</option>
                    @endforeach
                </select>
                <button type="button" id="other_sales_add" class="col-start-12 col-span-1 bg-black text-white hover:bg-gray-400 text-sm h-4/5">追加</button>
                <div id="total_other_sales_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                    <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                    <p class="col-start-9 col-span-2 text-right font-bold" id="total_other_sales_amount"></p>
                    <p class="col-start-11 col-span-1 text-left font-bold text-sm pl-2 pt-2">円</p>
                </div>
            </div>
            <div id="fare_list_expenses" class="grid grid-cols-12 bg-orange-200 p-5 mt-5">
                <p class="col-span-4 text-xl mb-5 font-bold">経費<i class="las la-caret-right"></i>運賃関連</p>
                <div id="total_fare_expenses_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                    <p class="col-span-2 text-right font-bold">個口合計</p>
                    <p class="col-span-1 text-right font-bold" id="total_box_quantity_expenses"></p>
                    <p class="col-span-1 text-left font-bold text-xs pl-2 pt-2">個口</p>
                    <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                    <p class="col-start-9 col-span-2 text-right font-bold" id="total_fare_expenses"></p>
                    <p class="col-start-11 col-span-1 text-left font-bold text-sm pl-2 pt-2">円</p>
                </div>
            </div>
            <div class="grid grid-cols-12 bg-orange-200 p-5 mt-5">
                <p class="col-span-4 text-xl mb-5 font-bold">経費<i class="las la-caret-right"></i>人件費関連</p>
                <div id="total_fare_expenses_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                    @foreach($labor_costs as $labor_cost)
                        <input name="labor_cost_name[]" class="text-sm col-span-2 font-bold py-3 bg-transparent" value="{{ $labor_cost->labor_cost_name }}" readonly tabIndex = "-1">
                        <input type="tel" id="{{ $labor_cost->labor_cost_name }}_working_time" class="col-span-1 text-right text-sm h-4/5 py-3 labor_costs_update working_time int_validation" name="working_time[]" autocomplete="off" placeholder="時間">
                        <p class="text-sm col-span-1 text-left pt-5 ml-2">時間</p>
                        <p class="text-base col-span-1 py-3"><i class="las la-times"></i></p>
                        <input type="tel" id="{{ $labor_cost->labor_cost_name }}_hourly_wage" class="col-span-1 text-right text-sm h-4/5 py-3 labor_costs_update int_validation" name="hourly_wage[]" autocomplete="off" placeholder="時給" value="{{ $labor_cost->hourly_wage }}">
                        <p class="text-sm col-span-1 text-left pt-5 ml-2">円</p>
                        <p class="text-base col-span-1 py-3"><i class="las la-equals"></i></p>
                        <input type="tel" id="{{ $labor_cost->labor_cost_name }}_labor_costs" class="col-span-2 text-right text-sm h-4/5 py-3 labor_costs int_validation" name="labor_costs[]" autocomplete="off" placeholder="金額">
                        <p class="text-sm col-span-2 text-left pt-5 ml-2">円</p>
                    @endforeach
                </div>
                <div id="total_labor_costs_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                    <p class="col-span-2 text-right font-bold">時間合計</p>
                    <p class="col-span-1 text-right font-bold" id="total_working_time"></p>
                    <p class="col-span-1 text-left font-bold text-xs pl-2 pt-2">時間</p>
                    <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                    <p class="col-start-9 col-span-2 text-right font-bold" id="total_labor_costs"></p>
                    <p class="col-start-11 col-span-1 text-left font-bold text-sm pl-2 pt-2">円</p>
                </div>
            </div>
            <div class="grid grid-cols-12 bg-orange-200 p-5 mt-5">
                <p class="col-span-4 text-xl mb-5 font-bold">経費<i class="las la-caret-right"></i>保管関連</p>
                <div class="col-span-12 grid grid-cols-12 border-b-2 border-black">
                    <p class="text-sm col-span-2 font-bold py-3">保管費</p>
                    <p id="storage_expenses_detail" class="text-sm col-span-6 py-3"></p>
                    <input type="tel" id="storage_expenses" class="col-start-9 col-span-2 text-right text-sm h-4/5 py-3 storage_expenses int_validation" name="storage_expenses" autocomplete="off" placeholder="保管経費">
                    <p class="col-span-1 text-left text-sm pl-2 pt-5">円</p>
                </div>
                <div id="total_storage_expenses_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                    <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                    <p class="col-start-9 col-span-2 text-right font-bold" id="total_storage_expenses"></p>
                    <p class="col-start-11 col-span-1 text-left font-bold text-sm pl-2 pt-2">円</p>
                </div>
            </div>
            <div id="other_expenses_list" class="grid grid-cols-12 bg-orange-200 p-5 mt-5">
                <p class="col-span-4 text-xl mb-5 font-bold">経費<i class="las la-caret-right"></i>その他</p>
                <select id="other_expenses_select" class="text-xs h-4/5 col-start-9 col-span-3">
                    <option value="0">その他経費を選択</option>
                    @foreach($expenses_items as $expenses_item)
                        <option value="{{ $expenses_item->expenses_item_id }}">{{ $expenses_item->expenses_item_name }}</option>
                    @endforeach
                </select>
                <button type="button" id="other_expenses_add" class="col-start-12 col-span-1 bg-black text-white hover:bg-gray-400 text-sm h-4/5">追加</button>
                <div id="total_other_expenses_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                    <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                    <p class="col-start-9 col-span-2 text-right font-bold" id="total_other_expenses_amount"></p>
                    <p class="col-start-11 col-span-1 text-left font-bold text-sm pl-2 pt-2">円</p>
                </div>
            </div>
            <div class="grid grid-cols-12 bg-purple-200 p-5 mt-5">
                <p class="col-span-12 text-xl mb-5 font-bold">その他</p>
                <label class="col-span-1 py-5">備考</label>
                <textarea name="balance_note" class="col-span-11" autocomplete="off" placeholder="コメントがあれば入力して下さい。（255文字以内）"></textarea>
            </div>
        </div>
    </form>
    <!-- 登録ボタンをフッター固定 -->
    <div class="col-start-12 col-span-1 sticky bottom-0 px-5 mb-5">
        <button id="register_enter" class="w-full text-white bg-indigo-500 border border-indigo-500 font-semibold rounded hover:bg-indigo-100 hover:text-black px-3 py-2">登録</button>
    </div>
</x-app-layout>
