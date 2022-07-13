<script src="{{ asset('js/modal.js') }}" defer></script>
<script src="{{ asset('js/balance_register_modal.js') }}" defer></script>
<script src="{{ asset('js/balance_delete.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                収支登録
            </div>
            <div class="inline-block col-span-1 col-start-12">
                <button id="openRegisterModal" class="cursor-pointer p-2 px-8"><i class="las la-plus-square la-2x"></i></button>
            </div>
        </div>
    </x-slot>
    <div class="py-12 mx-5 grid grid-cols-12">
        <div class="inline-block col-span-12">
            <!-- 収支一覧 -->
            <table class="text-sm mb-5 w-full">
                <thead>
                    <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                        <th class="p-2 px-2 w-1/12"><a href="{{ route('customer.sort', ['sort_column' => 'register_user_id', 'direction' => ($sort_column != 'register_user_id' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">登録者</a>{{ strpos(url()->full(), 'sort/register_user_id') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2 w-1/12"><a href="{{ route('customer.sort', ['sort_column' => 'balance_base_id', 'direction' => ($sort_column != 'balance_base_id' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">拠点</a>{{ strpos(url()->full(), 'sort/balance_base_id') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2 w-1/12"><a href="{{ route('customer.sort', ['sort_column' => 'balance_date', 'direction' => ($sort_column != 'balance_date' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">収支日</a>{{ strpos(url()->full(), 'sort/balance_date') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2 w-5/12"><a href="{{ route('customer.sort', ['sort_column' => 'customer_name', 'direction' => ($sort_column != 'customer_name' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">荷主名</a>{{ strpos(url()->full(), 'sort/customer_name') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2 w-1/12"><a href="{{ route('customer.sort', ['sort_column' => 'sales', 'direction' => ($sort_column != 'sales' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">売上</a>{{ strpos(url()->full(), 'sort/sales') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2 w-1/12"><a href="{{ route('customer.sort', ['sort_column' => 'expenses', 'direction' => ($sort_column != 'expenses' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">経費</a>{{ strpos(url()->full(), 'sort/expenses') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2 w-1/12"><a href="{{ route('customer.sort', ['sort_column' => 'profit', 'direction' => ($sort_column != 'profit' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">利益</a>{{ strpos(url()->full(), 'sort/profit') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2 w-1/12 text-center">処理</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($balances as $balance)
                        <tr id="{{ $balance->balance_id }}" class="XXXopenEditModalXXX">
                            <td class="p-1 px-2 border">{{ $balance->user->name }}</td>
                            <td class="p-1 px-2 border">{{ $balance->base->base_name }}</td>
                            <td class="p-1 px-2 border">{{ $balance->balance_date }}</td>
                            <td class="p-1 px-2 border">{{ $balance->customer->customer_name }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($balance->sales) }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($balance->expenses) }}</td>
                            <td class="p-1 px-2 border text-right {{ $balance->profit < 0 ? 'text-red-400 font-bold bg-rose-100' : '' }}">{{ number_format($balance->profit) }}</td>
                            <td class="p-1 px-2 border text-center"><a href="{{ route('balance.detail_index', ['balance_id' => $balance->balance_id]) }}" class="bg-sky-400 text-white text-xs p-1 hover:bg-gray-400">詳細</a><a href="{{ route('balance.delete', ['balance_id' => $balance->balance_id]) }}" class="delete_balance bg-red-400 text-white text-xs p-1 hover:bg-gray-400 ml-8">削除</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- 登録用モーダル -->
    <div id="register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-10 mx-auto shadow-lg rounded-md bg-white max-w-5xl">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4>収支登録画面</h4>
                <button class="closeRegisterModal"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-5">
                <form method="post" action="{{ route('balance_register.register') }}" class="m-0">
                    @csrf
                    <div class="grid grid-cols-12 bg-gray-200 p-5">
                        <p class="col-span-12 text-xl mb-5 font-bold">対象</p>
                        <label class="col-span-1 py-2">荷主</label>
                        <select id="customer_select"  name="customer_id" class="col-span-5">
                            <option value="0">荷主を選択</option>
                            @foreach($own_base_customers as $customer)
                                <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                            @endforeach
                        </select>
                        <label class="col-span-1 col-start-9 py-2">収支日</label>
                        <input type="date" name="balance_date" class="col-span-3" autocomplete="off" required>
                    </div>
                    <div id="fare_list_sales" class="grid grid-cols-12 bg-yellow-200 p-5 mt-5">
                        <p class="col-span-4 text-xl mb-5 font-bold">売上<i class="las la-caret-right"></i>運賃関連</p>
                        <select id="shipping_method_select" class="text-xs h-4/5 col-start-7 col-span-5">
                            <option value="0">配送方法を選択</option>
                            @foreach($shipping_methods as $shipping_method)
                                <option value="{{ $shipping_method->shipping_method_id }}">{{ $shipping_method->shipping_method_name }}(売上:{{ $shipping_method->fare_unit_price }}円)(経費:{{ $shipping_method->fare_expenses }}円)</option>
                            @endforeach
                        </select>
                        <button type="button" id="shipping_method_add" class="col-start-12 col-span-1 bg-black text-white hover:bg-gray-400 text-sm h-4/5">追加</button>
                        <div id="total_fare_sales_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                            <p class="col-span-2 text-right font-bold">個口合計</p>
                            <p class="col-span-1 text-right font-bold" id="total_box_quantity_sales"></p>
                            <p class="col-span-1 text-left font-bold text-xs pl-2 pt-2">個口</p>
                            <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                            <p class="col-start-9 col-span-2 text-right font-bold" id="total_fare_sales"></p>
                            <p class="col-start-11 col-span-1 text-left font-bold text-xs pl-2 pt-2">円</p>
                        </div>
                    </div>
                    <div id="cargo_handling_list" class="grid grid-cols-12 bg-yellow-200 p-5 mt-5">
                        <p class="col-span-4 text-xl mb-5 font-bold">売上<i class="las la-caret-right"></i>荷役関連</p>
                        <select id="cargo_handling_select" name="cargo_handling_id" class="text-xs h-4/5 col-start-7 col-span-5">
                            <option value="0">荷役を選択</option>
                        </select>
                        <button type="button" id="cargo_handling_add" class="col-start-12 col-span-1 bg-black text-white hover:bg-gray-400 text-sm h-4/5">追加</button>
                        <div id="total_cargo_handling_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                            <p class="col-span-2 text-right font-bold">作業合計</p>
                            <p class="col-span-1 text-right font-bold" id="total_operation_quantity"></p>
                            <p class="col-span-1 text-left font-bold text-xs pl-2 pt-2">作業</p>
                            <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                            <p class="col-start-9 col-span-2 text-right font-bold" id="total_cargo_handling"></p>
                            <p class="col-start-11 col-span-1 text-left font-bold text-xs pl-2 pt-2">円</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 bg-yellow-200 p-5 mt-5">
                        <p class="col-span-4 text-xl mb-5 font-bold">売上<i class="las la-caret-right"></i>保管関連</p>
                        <div class="col-span-12 grid grid-cols-12 border-b-2 border-black">
                            <p class="text-sm col-span-2 font-bold py-3">保管費</p>
                            <p id="storage_fee_detail" class="text-sm col-span-6 py-3"></p>
                            <input type="tel" id="storage_fee" class="col-start-9 col-span-2 text-right text-sm h-4/5 py-3 storage_fee" name="storage_fee" autocomplete="off" placeholder="保管費">
                            <p class="col-span-1 text-left text-sm pl-2 pt-5">円</p>
                        </div>
                        <div id="total_storage_fee_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                            <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                            <p class="col-start-9 col-span-2 text-right font-bold" id="total_storage_fee"></p>
                            <p class="col-start-11 col-span-1 text-left font-bold text-xs pl-2 pt-2">円</p>
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
                            <p class="col-start-11 col-span-1 text-left font-bold text-xs pl-2 pt-2">円</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 bg-orange-200 p-5 mt-5">
                        <p class="col-span-4 text-xl mb-5 font-bold">経費<i class="las la-caret-right"></i>人件費関連</p>
                        <div id="total_fare_expenses_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                            @foreach($labor_costs as $labor_cost)
                                <input name="labor_cost_category[]" class="text-sm col-span-2 font-bold py-3 bg-transparent" value="{{ $labor_cost->labor_cost_category }}" readonly>
                                <input type="tel" id="{{ $labor_cost->labor_cost_id }}_working_time" class="col-span-1 text-right text-sm h-4/5 py-3 labor_costs_update working_time" name="working_time[]" autocomplete="off" placeholder="時間">
                                <p class="text-sm col-span-1 text-left pt-5 ml-2">時間</p>
                                <p class="text-base col-span-1 py-3"><i class="las la-times"></i></p>
                                <input type="tel" id="{{ $labor_cost->labor_cost_id }}_hourly_wage" class="col-span-1 text-right text-sm h-4/5 py-3 labor_costs_update" name="hourly_wage[]" autocomplete="off" placeholder="時給" value="{{ $labor_cost->hourly_wage }}">
                                <p class="text-sm col-span-1 text-left pt-5 ml-2">円</p>
                                <p class="text-base col-span-1 py-3"><i class="las la-equals"></i></p>
                                <input type="tel" id="{{ $labor_cost->labor_cost_id }}_labor_costs" class="col-span-2 text-right text-sm h-4/5 py-3 labor_costs" name="labor_costs[]" autocomplete="off" placeholder="金額">
                                <p class="text-sm col-span-2 text-left pt-5 ml-2">円</p>
                            @endforeach
                        </div>
                        <div id="total_labor_costs_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                            <p class="col-span-2 text-right font-bold">時間合計</p>
                            <p class="col-span-1 text-right font-bold" id="total_working_time"></p>
                            <p class="col-span-1 text-left font-bold text-xs pl-2 pt-2">時間</p>
                            <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                            <p class="col-start-9 col-span-2 text-right font-bold" id="total_labor_costs"></p>
                            <p class="col-start-11 col-span-1 text-left font-bold text-xs pl-2 pt-2">円</p>
                        </div>
                    </div>
                    <div id="other_expense_list" class="grid grid-cols-12 bg-orange-200 p-5 mt-5">
                        <p class="col-span-4 text-xl mb-5 font-bold">経費<i class="las la-caret-right"></i>その他</p>
                        <select id="other_expense_select" class="text-xs h-4/5 col-start-7 col-span-5">
                            <option value="0">経費を選択</option>
                            @foreach($other_expenses as $other_expense)
                                <option value="{{ $other_expense->expense_id }}">{{ $other_expense->expense_name }}</option>
                            @endforeach
                        </select>
                        <button type="button" id="other_expense_add" class="col-start-12 col-span-1 bg-black text-white hover:bg-gray-400 text-sm h-4/5">追加</button>
                        <div id="total_other_expense_div" class="col-span-12 grid grid-cols-12 border-b-2 border-black mt-8">
                            <p class="col-start-7 col-span-2 text-right font-bold">金額合計</p>
                            <p class="col-start-9 col-span-2 text-right font-bold" id="total_other_expense_amount"></p>
                            <p class="col-start-11 col-span-1 text-left font-bold text-xs pl-2 pt-2">円</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 bg-purple-200 p-5 mt-5">
                        <p class="col-span-12 text-xl mb-5 text-center font-bold">その他</p>
                        <label class="col-span-1 py-5">備考</label>
                        <textarea name="balance_note" class="col-span-11" autocomplete="off" placeholder="コメントがあれば入力して下さい。（255文字以内）"></textarea>
                    </div>
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                    <input type="submit" id="item_data_export" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white" value="登録">
                </form>
                <a class="closeRegisterModal cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
