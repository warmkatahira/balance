<script src="{{ asset('js/customer.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-1">
                <a href="{{ session('index_url') }}" class="inline-block text-center w-full bg-black text-white border font-semibold rounded hover:bg-gray-400 px-3 py-2">戻る</a>
            </div>
            <div class="col-span-6 font-semibold text-xl text-gray-800 p-2">
                配送方法設定<i class="las la-caret-right"></i>{{ $customer->customer_name }}
            </div>
            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11 && Auth::user()->base_id == $customer->control_base_id)
                <div class="col-start-11 col-span-1">
                    <button id="shipping_method_register_modal_open" class="w-full text-indigo-500 border border-indigo-500 font-semibold rounded hover:bg-indigo-100 px-3 py-2">登録</button>
                </div>
                <div class="col-start-12 col-span-1">
                    <button type="button" id="shipping_method_setting_save" class="w-full text-teal-500 border border-teal-500 font-semibold rounded hover:bg-teal-100 px-3 py-2">保存</button>
                </div>
            @endif
        </div>
    </x-slot>
    <form method="post" id="shipping_method_setting_form" action="{{ route('customer_shipping_method_setting.update') }}" class="m-0">
        @csrf
        <div class="py-5 mx-5 grid grid-cols-12">
            <div class="col-span-5">
                <table class="col-span-12 text-sm mb-5">
                    <thead>
                        <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                            <th class="p-2 px-2 w-3/12">運送会社</th>
                            <th class="p-2 px-2 w-3/12">配送方法</th>
                            <th class="p-2 px-2 w-2/12 text-right">運賃単価</th>
                            <th class="p-2 px-2 w-2/12 text-right">運賃経費</th>
                            <th class="p-2 px-2 w-2/12 text-center">操作</th>
                        </tr>
                    </thead>
                    <tbody id="shipping_method_setting_body" class="bg-white">
                        @foreach($customer->shipping_methods as $shipping_method)
                            <tr id="tr_{{ $shipping_method->shipping_method_id }}">
                                <td class="p-1 px-2 border">{{ $shipping_method->shipping_company }}</td>
                                <td class="p-1 px-2 border">{{ $shipping_method->shipping_method }}</td>
                                <td class="p-1 px-2 border text-right"><input type="tel" name="fare_unit_price[{{ $shipping_method->shipping_method_id }}]" class="text-sm text-right w-3/4 bg-gray-100 fare_unit_price" value="{{ $shipping_method->pivot->fare_unit_price }}"></td>
                                <td class="p-1 px-2 border text-right"><input type="tel" name="fare_expense[{{ $shipping_method->shipping_method_id }}]" class="text-sm text-right w-3/4 bg-gray-100 fare_expense" value="{{ $shipping_method->pivot->fare_expense }}"></td>
                                <td class="p-1 px-2 border text-center">
                                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11 && Auth::user()->base_id == $customer->control_base_id)
                                        <button type="button" id="{{ $shipping_method->shipping_method_id }}" class="shipping_method_setting_delete bg-red-600 text-white hover:bg-gray-400 p-1 text-xs">削除</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
    <!-- 配送方法設定モーダル -->
    <div id="shipping_method_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-40 mx-auto shadow-lg rounded-md bg-white max-w-md">
            <!-- モーダルヘッダー -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4>配送方法設定登録画面</h4>
                <button class="shipping_method_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- モーダルボディ -->
            <div class="p-10">
                <label for="shipping_method_id" class="">設定配送方法</label><br>
                <select id="shipping_method_id" class="w-full text-sm mb-5">
                    <option value="0">配送方法を選択</option>
                    @foreach($shipping_methods as $shipping_method)
                        <option value="{{ $shipping_method->shipping_method_id }}">{{ $shipping_method->shipping_company .'【'. $shipping_method->shipping_method .'】' }}</option>
                    @endforeach
                </select>
                <label for="fare_unit_price" class="">運賃売上</label><br>
                <input type="tel" id="fare_unit_price" class="w-1/4 mb-5 text-sm text-right" placeholder="単価" autocomplete="off" required><span class="ml-1">円</span><br>
                <label for="fare_expense" class="">運賃経費</label><br>
                <input type="tel" id="fare_expense" class="w-1/4 text-sm text-right" placeholder="単価" autocomplete="off" required><span class="ml-1">円</span>
            </div>
            <!-- モーダルフッター -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <a id="shipping_method_register" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">登録</a>
                <a class="shipping_method_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
