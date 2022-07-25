<script src="{{ asset('js/customer.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                荷主マスタ
            </div>
            <div class="col-start-12 col-span-1">
                <button id="customer_register_modal_open" class="w-full text-indigo-500 border border-indigo-500 font-semibold rounded hover:bg-indigo-100 px-3 py-2">登録</button>
            </div>
        </div>
    </x-slot>
    <div class="py-5 mx-5 grid grid-cols-12">
        <!--▼▼▼▼▼ 検索条件 ▼▼▼▼▼-->
        <div class="col-span-12 shadow-lg border p-5 bg-teal-100">
            <form method="get" action="{{ route('customer_search.index') }}" class="m-0">
                <div class="grid grid-cols-12 grid-rows-2 grid-flow-col text-sm">
                    <div id="base" class="row-span-2 col-span-2">
                        <p class="row-span-1 py-2 font-bold">拠点</p>
                        <div class="row-span-1">
                            <select id="base_select" name="base_select" class="rounded-lg w-10/12 text-sm">
                                <option value="0">全拠点</option>
                                @foreach($bases as $base)
                                    <option value="{{ $base->base_id }}" {{ session('base_id') == $base->base_id ? 'selected' : '' }}>{{ $base->base_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row-span-2 col-start-11 col-span-2 text-right">
                        <button type="submit" id="balance_list_search" class="row-span-2 h-full w-10/12 rounded-lg bg-green-600 hover:bg-gray-400 text-white"><i class="las la-search la-lg"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <!--▲▲▲▲▲ 検索条件 ▲▲▲▲▲-->

        <!-- 荷主一覧 -->
        <table class="text-sm my-5 col-span-9">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-2/12">拠点</th>
                    <th class="p-2 px-2 w-5/12">荷主名</th>
                    <th class="p-2 px-2 w-1/12 text-right">月間保管費</th>
                    <th class="p-2 px-2 w-1/12 text-right">稼働日数</th>
                    <th class="p-2 px-2 w-3/12 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($customers as $customer)
                    <tr id="tr_{{ $customer->customer_id }}">
                        <td class="p-1 px-2 border">{{ $customer->base->base_name }}</td>
                        <td class="p-1 px-2 border">{{ $customer->customer_name }}</td>
                        <td class="p-1 px-2 border text-right">{{ number_format($customer->monthly_storage_fee) }}円</td>
                        <td class="p-1 px-2 border text-right">{{ $customer->working_days }}日</td>
                        <td class="p-1 px-2 border text-center"><a href="{{ route('customer_base_info.index', ['customer_id' => $customer->customer_id]) }}" class="bg-sky-400 text-white text-xs p-1 hover:bg-gray-400">基本</a><a href="{{ route('customer_cargo_handling_setting.index', ['customer_id' => $customer->customer_id]) }}" class="bg-sky-400 text-white text-xs p-1 hover:bg-gray-400 ml-5">荷役設定</a><a href="{{ route('customer_shipping_method_setting.index', ['customer_id' => $customer->customer_id]) }}" class="bg-sky-400 text-white text-xs p-1 hover:bg-gray-400 ml-5">配送方法設定</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- 荷主登録モーダル -->
    <div id="customer_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-40 mx-auto shadow-lg rounded-md bg-white max-w-md">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4>荷主登録画面</h4>
                <button class="customer_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                <form method="post" id="customer_register_form" action="{{ route('customer.register') }}">
                    @csrf
                    <select id="base_select" name="base_id" class="w-full">
                        <option value="0">拠点を選択</option>
                        @foreach($bases as $base)
                            <option value="{{ $base->base_id }}">{{ $base->base_name }}</option>
                        @endforeach
                    </select>
                    <input type="text" id="customer_name" name="customer_name" class="w-full mt-5" placeholder="荷主名" autocomplete="off" required>
                    <input type="tel" id="monthly_storage_fee" name="monthly_storage_fee" class="w-1/2 mt-5 text-right" placeholder="月間保管料" autocomplete="off" required><br>
                    <input type="tel" id="working_days" name="working_days" class="w-1/4 mt-5 text-right" placeholder="稼働日数" autocomplete="off" required>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <button type="button" id="customer_register_enter" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">登録</button>
                <a class="customer_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
