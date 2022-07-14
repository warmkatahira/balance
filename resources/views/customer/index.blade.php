<script src="{{ asset('js/customer.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                荷主マスタ
            </div>
            <div class="inline-block col-span-1 col-start-12">
                <button id="customer_register_modal_open" class="cursor-pointer p-2 px-8"><i class="las la-plus-square la-2x"></i></button>
            </div>
        </div>
    </x-slot>
    <div class="py-12 mx-5 grid grid-cols-12">
        <!-- 荷主一覧 -->
        <table class="text-sm mb-5 col-span-8">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-2/12"><a href="{{ route('customer.sort', ['sort_column' => 'control_base_id', 'direction' => ($sort_column != 'control_base_id' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">拠点</a>{{ strpos(url()->full(), 'sort/control_base_id') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                    <th class="p-2 px-2 w-4/12"><a href="{{ route('customer.sort', ['sort_column' => 'customer_name', 'direction' => ($sort_column != 'customer_name' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">荷主名</a>{{ strpos(url()->full(), 'sort/customer_name') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                    <th class="p-2 px-2 w-2/12 text-right"><a href="{{ route('customer.sort', ['sort_column' => 'monthly_storage_fee', 'direction' => ($sort_column != 'monthly_storage_fee' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">月間保管費</a>{{ strpos(url()->full(), 'sort/monthly_storage_fee') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                    <th class="p-2 px-2 w-1/12 text-right"><a href="{{ route('customer.sort', ['sort_column' => 'working_days', 'direction' => ($sort_column != 'working_days' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">稼働日数</a>{{ strpos(url()->full(), 'sort/working_days') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                    <th class="p-2 px-2 w-2/12"><a href="{{ route('customer.sort', ['sort_column' => 'handling_fee_category', 'direction' => ($sort_column != 'handling_fee_category' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">事務手数料区分</a>{{ strpos(url()->full(), 'sort/handling_fee_category') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                    <th class="p-2 px-2 w-1/12 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($customers as $customer)
                    <tr id="tr_{{ $customer->customer_id }}">
                        <td class="p-1 px-2 border">{{ $customer->base->base_name }}</td>
                        <td class="p-1 px-2 border">{{ $customer->customer_name }}</td>
                        <td class="p-1 px-2 border text-right">{{ number_format($customer->monthly_storage_fee) }}円</td>
                        <td class="p-1 px-2 border text-right">{{ $customer->working_days }}日</td>
                        <td class="p-1 px-2 border">{{ $customer->handling_fee_category }}</td>
                        <td class="p-1 px-2 border text-center"><a href="{{ route('customer.detail', ['customer_id' => $customer->customer_id]) }}" class="bg-sky-400 text-white text-xs p-1 hover:bg-gray-400">詳細</a></td>
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
                <form method="post" action="{{ route('customer.register') }}">
                    @csrf
                    <select name="base_id" class="w-full">
                        <option value="0">拠点を選択</option>
                        @foreach($bases as $base)
                            <option value="{{ $base->base_id }}">{{ $base->base_name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="customer_name" class="w-full mt-5" placeholder="荷主名" autocomplete="off" required>
                    <input type="tel" name="monthly_storage_fee" class="w-full mt-5" placeholder="月間保管料" autocomplete="off" required>
                    <input type="tel" name="working_days" class="w-full mt-5" placeholder="稼働日数" autocomplete="off" required>
                    <input type="text" name="handling_fee_category" class="w-full mt-5" placeholder="事務手数料区分" autocomplete="off" required>
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                    <input type="submit" id="item_data_export" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white" value="登録">
                </form>
                <a class="customer_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
