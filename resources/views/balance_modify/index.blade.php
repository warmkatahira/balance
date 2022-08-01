<script src="{{ asset('js/balance_register.js') }}" defer></script>
<script src="{{ asset('js/balance_modify.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                収支修正
            </div>
            <div class="col-start-12 col-span-1">
                <button id="modify_enter" class="w-full text-indigo-500 border border-indigo-500 font-semibold rounded hover:bg-indigo-100 px-3 py-2">修正</button>
            </div>
        </div>
    </x-slot>
    <form method="post" id="balance_register_form" action="{{ route('balance_modify.modify') }}" class="m-0">
        @csrf
        <div class="p-5">
            <div class="grid grid-cols-12 bg-gray-300 p-5">
                <p class="col-span-12 text-xl mb-5 font-bold">対象</p>
                <label class="col-span-1 py-2">荷主</label>
                <input class="col-span-3 py-2 bg-transparent" value="{{ $balance->customer->customer_name }}" readonly>
                <input type="hidden" id="customer_select" value="{{ $balance->customer->customer_id }}">
                <label class="col-span-1 col-start-9 py-2">収支日</label>
                <input id="balance_date" class="col-span-2 py-2 bg-transparent" value="{{ $balance->balance_date }}" readonly>
            </div>
            <div id="fare_list_sales" class="grid grid-cols-12 bg-yellow-200 p-5 mt-5">
                <p class="col-span-4 text-xl mb-5 font-bold">売上<i class="las la-caret-right"></i>運賃関連</p>
                <select id="shipping_method_select" class="text-xs h-4/5 col-start-9 col-span-3">
                    <option value="0">配送方法を選択</option>
                    @foreach($shipping_methods as $shipping_method)
                        <option value="{{ $shipping_method->shipping_method_id }}">{{ $shipping_method->shipping_company.'【'.$shipping_method->shipping_method.'】（売上:'.$shipping_method->fare_unit_price.'円）（経費:'.$shipping_method->fare_expense.'円）' }}</option>
                    @endforeach
                </select>
                <button type="button" id="shipping_method_add" class="col-start-12 col-span-1 bg-black text-white hover:bg-gray-400 text-sm h-4/5">追加</button>
                @foreach($balance_fares as $balance_fare)
                    @if($balance_fare->fare_balance_category == 'sales')
                        <div id="{{ $balance_fare->shipping_method_name.'_fare_'.$balance_fare->fare_balance_category.'_div' }}" class="grid grid-cols-12 col-span-12 border-b-2 border-black pt-2 shipping_method_div">
                            <input class="font-bold text-sm col-span-2 py-3 bg-transparent" name="{{ 'shipping_method_name_'.$balance_fare->fare_balance_category.'[]' }}" value="{{ $balance_fare->shipping_method_name }}" readonly>
                            <input type="tel" id="{{ $balance_fare->shipping_method_name.'_box_quantity_'.$balance_fare->fare_balance_category }}" name="{{ 'box_quantity_'.$balance_fare->fare_balance_category.'[]' }}" class="text-sm col-span-1 text-right h-4/5 {{ 'fare_amount_'.$balance_fare->fare_balance_category.'_update' }} {{ 'box_quantity_'.$balance_fare->fare_balance_category }}" placeholder="個口" autocomplete="off" value="{{ $balance_fare->box_quantity }}">
                            <p class="text-sm col-span-1 text-left pt-5 ml-2">個口</p>
                            <p class="text-base col-span-1 py-3"><i class="las la-times"></i></p>
                            <input type="tel" id="{{ $balance_fare->shipping_method_name.'_fare_unit_price_'.$balance_fare->fare_balance_category }}" name="{{ 'fare_unit_price_'.$balance_fare->fare_balance_category.'[]' }}" class="text-sm col-span-1 text-right {{ 'fare_amount_'.$balance_fare->fare_balance_category.'_update' }} h-4/5" placeholder="単価" autocomplete="off" value="{{ $balance_fare->fare_unit_price }}">
                            <p class="text-sm col-span-1 text-left pt-5 ml-2">円</p>
                            <p class="text-base col-span-1 py-3"><i class="las la-equals"></i></p>
                            <input type="tel" id="{{ $balance_fare->shipping_method_name.'_fare_amount_'.$balance_fare->fare_balance_category }}" name="{{ 'fare_amount_'.$balance_fare->fare_balance_category.'[]' }}" class="text-sm col-span-2 text-right h-4/5 {{ 'fare_amount_'.$balance_fare->fare_balance_category }}" placeholder="金額" autocomplete="off" value="{{ $balance_fare->fare_amount }}">
                            <p class="text-sm col-span-1 text-left pt-5 ml-2">円</p>
                            <button type="button" id="{{ $balance_fare->shipping_method_name.'_fare_'.$balance_fare->fare_balance_category.'_delete_btn' }}" class="col-span-1 bg-red-600 text-white hover:bg-gray-400 {{ 'delete_shipping_method_'.$balance_fare->fare_balance_category }} h-4/5"><i class="las la-trash la-lg"></i></button>
                        </div>
                    @endif
                @endforeach
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
                    @foreach($cargo_handlings as $cargo_handling)
                        <option value="{{ $cargo_handling->cargo_handling_id }}">{{ $cargo_handling->cargo_handling_name.'【'.($cargo_handling->cargo_handling_note == null ? '' : $cargo_handling->cargo_handling_note).'】（単価:'.$cargo_handling->cargo_handling_unit_price.'円）' }}</option>
                    @endforeach
                </select>
                <button type="button" id="cargo_handling_add" class="col-start-12 col-span-1 bg-black text-white hover:bg-gray-400 text-sm h-4/5">追加</button>
                @foreach($balance_cargo_handlings as $balance_cargo_handling)
                    <div id="{{ $balance_cargo_handling->cargo_handling_name.'-'.$balance_cargo_handling->cargo_handling_unit_price.'_cargo_handling_div' }}" class="grid grid-cols-12 col-span-12 border-b-2 border-black pt-2 cargo_handling_div">
                        <input class="font-bold text-sm col-span-2 py-3 bg-transparent" name="cargo_handling_name[]" value="{{ $balance_cargo_handling->cargo_handling_name }}" readonly>
                        <input class="font-bold text-sm col-start-1 col-span-2 py-3 bg-transparent" name="cargo_handling_note[]" value="{{ $balance_cargo_handling->cargo_handling_note }}" readonly>
                        <input type="tel" id="{{ $balance_cargo_handling->cargo_handling_name.'_operation_quantity' }}" name="operation_quantity[]" class="text-sm col-span-1 text-right cargo_handling_amount_update h-4/5 operation_quantity" placeholder="作業数" autocomplete="off" value="{{ $balance_cargo_handling->operation_quantity }}">
                        <p class="text-sm col-span-1 text-left pt-5 ml-2">作業</p>
                        <p class="text-base col-span-1 py-3"><i class="las la-times"></i></p>
                        <input type="tel" id="{{ $balance_cargo_handling->cargo_handling_name.'_cargo_handling_unit_price' }}" name="cargo_handling_unit_price[]" class="text-sm col-span-1 text-right cargo_handling_amount_update h-4/5" placeholder="単価" autocomplete="off" value="{{ $balance_cargo_handling->cargo_handling_unit_price }}">
                        <p class="text-sm col-span-1 text-left pt-5 ml-2">円</p>
                        <p class="text-base col-span-1 py-3"><i class="las la-equals"></i></p>
                        <input type="tel" id="{{ $balance_cargo_handling->cargo_handling_name.'_cargo_handling_amount' }}" name="cargo_handling_amount[]" class="text-sm col-span-2 text-right h-4/5 cargo_handling_amount" placeholder="金額" autocomplete="off" value="{{ $balance_cargo_handling->cargo_handling_amount }}">
                        <p class="text-sm col-span-1 text-left pt-5 ml-2">円</p>
                        <button type="button" id="{{ $balance_cargo_handling->cargo_handling_name.'-'.$balance_cargo_handling->cargo_handling_unit_price.'_delete_btn' }}" class="col-span-1 bg-red-600 text-white hover:bg-gray-400 delete_cargo_handling h-4/5"><i class="las la-trash la-lg"></i></button>
                    </div>
                @endforeach
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
                    <input type="tel" id="storage_fee" class="col-start-9 col-span-2 text-right text-sm h-4/5 py-3 storage_fee int_validation" name="storage_fee" autocomplete="off" placeholder="保管売上" value="{{ $balance->storage_fee }}">
                    <p class="col-span-1 text-left text-sm pl-2 pt-5">円</p>
                </div>
                <div id="total_storage_fee_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                    <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                    <p class="col-start-9 col-span-2 text-right font-bold" id="total_storage_fee">{{ $balance->storage_fee }}</p>
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
                @foreach($balance_other_sales as $balance_other_sale)
                    <div id="{{ $balance_other_sale->other_sales_name.'_other_sales_div' }}" class="grid grid-cols-12 col-span-12 border-b-2 border-black pt-2">
                        <input name="other_sales_name[]" class="font-bold text-sm col-span-2 py-3 bg-transparent" value="{{ $balance_other_sale->other_sales_name }}" readonly>
                        <input name="other_sales_note[]" class="text-sm col-start-4 col-span-2 py-3 bg-transparent" value="{{ $balance_other_sale->other_sales_note }}" readonly>
                        <input type="tel" id="{{ $balance_other_sale->other_sales_name.'_other_sales_amount' }}" name="other_sales_amount[]" class="text-sm col-span-2 col-start-9 text-right other_sales_amount_update h-4/5 other_sales_amount" value="{{ $balance_other_sale->other_sales_amount }}" placeholder="金額" autocomplete="off">
                        <p class="text-sm col-span-1 col-start-11 text-left pt-5 ml-2">円</p>
                        <button type="button" id="{{ $balance_other_sale->other_sales_name.'_other_sales_delete_btn' }}" class="col-span-1 col-start-12 bg-red-600 text-white hover:bg-gray-400 delete_other_sales h-4/5"><i class="las la-trash la-lg"></i></button>
                    </div>
                @endforeach
                <div id="total_other_sales_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                    <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                    <p class="col-start-9 col-span-2 text-right font-bold" id="total_other_sales_amount"></p>
                    <p class="col-start-11 col-span-1 text-left font-bold text-sm pl-2 pt-2">円</p>
                </div>
            </div>
            <div id="fare_list_expenses" class="grid grid-cols-12 bg-orange-200 p-5 mt-5">
                <p class="col-span-4 text-xl mb-5 font-bold">経費<i class="las la-caret-right"></i>運賃関連</p>
                @foreach($balance_fares as $balance_fare)
                    @if($balance_fare->fare_balance_category == 'expenses')
                        <div id="{{ $balance_fare->shipping_method_name.'_fare_'.$balance_fare->fare_balance_category.'_div' }}" class="grid grid-cols-12 col-span-12 border-b-2 border-black pt-2 shipping_method_div">
                            <input class="font-bold text-sm col-span-2 py-3 bg-transparent" name="{{ 'shipping_method_name_'.$balance_fare->fare_balance_category.'[]' }}" value="{{ $balance_fare->shipping_method_name }}" readonly>
                            <input type="tel" id="{{ $balance_fare->shipping_method_name.'_box_quantity_'.$balance_fare->fare_balance_category }}" name="{{ 'box_quantity_'.$balance_fare->fare_balance_category.'[]' }}" class="text-sm col-span-1 text-right h-4/5 {{ 'fare_amount_'.$balance_fare->fare_balance_category.'_update' }} {{ 'box_quantity_'.$balance_fare->fare_balance_category }}" placeholder="個口" autocomplete="off" value="{{ $balance_fare->box_quantity }}">
                            <p class="text-sm col-span-1 text-left pt-5 ml-2">個口</p>
                            <p class="text-base col-span-1 py-3"><i class="las la-times"></i></p>
                            <input type="tel" id="{{ $balance_fare->shipping_method_name.'_fare_unit_price_'.$balance_fare->fare_balance_category }}" name="{{ 'fare_unit_price_'.$balance_fare->fare_balance_category.'[]' }}" class="text-sm col-span-1 text-right {{ 'fare_amount_'.$balance_fare->fare_balance_category.'_update' }} h-4/5" placeholder="単価" autocomplete="off" value="{{ $balance_fare->fare_unit_price }}">
                            <p class="text-sm col-span-1 text-left pt-5 ml-2">円</p>
                            <p class="text-base col-span-1 py-3"><i class="las la-equals"></i></p>
                            <input type="tel" id="{{ $balance_fare->shipping_method_name.'_fare_amount_'.$balance_fare->fare_balance_category }}" name="{{ 'fare_amount_'.$balance_fare->fare_balance_category.'[]' }}" class="text-sm col-span-2 text-right h-4/5 {{ 'fare_amount_'.$balance_fare->fare_balance_category }}" placeholder="金額" autocomplete="off" value="{{ $balance_fare->fare_amount }}">
                            <p class="text-sm col-span-1 text-left pt-5 ml-2">円</p>
                        </div>
                    @endif
                @endforeach
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
                    @foreach($balance_labor_costs as $balance_labor_cost)
                        <input name="labor_cost_name[]" class="text-sm col-span-2 font-bold py-3 bg-transparent" value="{{ $balance_labor_cost->labor_cost_name }}" readonly>
                        <input type="tel" id="{{ $balance_labor_cost->labor_cost_name }}_working_time" class="col-span-1 text-right text-sm h-4/5 py-3 labor_costs_update working_time int_validation" name="working_time[]" autocomplete="off" placeholder="時間" value="{{ $balance_labor_cost->working_time }}">
                        <p class="text-sm col-span-1 text-left pt-5 ml-2">時間</p>
                        <p class="text-base col-span-1 py-3"><i class="las la-times"></i></p>
                        <input type="tel" id="{{ $balance_labor_cost->labor_cost_name }}_hourly_wage" class="col-span-1 text-right text-sm h-4/5 py-3 labor_costs_update int_validation" name="hourly_wage[]" autocomplete="off" placeholder="時給" value="{{ $balance_labor_cost->hourly_wage }}">
                        <p class="text-sm col-span-1 text-left pt-5 ml-2">円</p>
                        <p class="text-base col-span-1 py-3"><i class="las la-equals"></i></p>
                        <input type="tel" id="{{ $balance_labor_cost->labor_cost_name }}_labor_costs" class="col-span-2 text-right text-sm h-4/5 py-3 labor_costs int_validation" name="labor_costs[]" autocomplete="off" placeholder="金額" value="{{ $balance_labor_cost->labor_costs }}">
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
                    <input type="tel" id="storage_expenses" class="col-start-9 col-span-2 text-right text-sm h-4/5 py-3 storage_expenses int_validation" name="storage_expenses" autocomplete="off" placeholder="保管経費" value="{{ $balance->storage_expenses }}">
                    <p class="col-span-1 text-left text-sm pl-2 pt-5">円</p>
                </div>
                <div id="total_storage_expenses_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                    <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                    <p class="col-start-9 col-span-2 text-right font-bold" id="total_storage_expenses">{{ $balance->storage_expenses }}</p>
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
                @foreach($balance_other_expenses as $balance_other_expense)
                    <div id="{{ $balance_other_expense->other_expenses_name.'_other_expenses_div' }}" class="grid grid-cols-12 col-span-12 border-b-2 border-black pt-2">
                        <input name="other_expenses_name[]" class="font-bold text-sm col-span-2 py-3 bg-transparent" value="{{ $balance_other_expense->other_expenses_name }}" readonly>
                        <input name="other_expenses_note[]" class="text-sm  col-start-4 col-span-2 py-3 bg-transparent" value="{{ $balance_other_expense->other_expenses_note }}" readonly>
                        <input type="tel" id="{{ $balance_other_expense->other_expenses_name.'_other_expenses_amount' }}" name="other_expenses_amount[]" class="text-sm col-span-2 col-start-9 text-right other_expenses_amount_update h-4/5 other_expenses_amount" value="{{ $balance_other_expense->other_expenses_amount }}" placeholder="金額" autocomplete="off">
                        <p class="text-sm col-span-1 col-start-11 text-left pt-5 ml-2">円</p>
                        <button type="button" id="{{ $balance_other_expense->other_expenses_name.'_other_expenses_delete_btn' }}" class="col-span-1 col-start-12 bg-red-600 text-white hover:bg-gray-400 delete_other_expenses h-4/5"><i class="las la-trash la-lg"></i></button>
                    </div>
                @endforeach
                <div id="total_other_expenses_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                    <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                    <p class="col-start-9 col-span-2 text-right font-bold" id="total_other_expenses_amount"></p>
                    <p class="col-start-11 col-span-1 text-left font-bold text-sm pl-2 pt-2">円</p>
                </div>
            </div>
            <div class="grid grid-cols-12 bg-purple-200 p-5 mt-5">
                <p class="col-span-12 text-xl mb-5 font-bold">その他</p>
                <label class="col-span-1 py-5">備考</label>
                <textarea name="balance_note" class="col-span-11" autocomplete="off" placeholder="コメントがあれば入力して下さい。（255文字以内）">{{ $balance->balance_note }}</textarea>
            </div>
        </div>
    </form>
</x-app-layout>
