<script src="{{ asset('js/monthly_sales_setting.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-1">
                <a href="{{ session('index_url') }}" class="inline-block text-center w-full bg-black text-white border font-semibold rounded hover:bg-gray-400 px-3 py-2">戻る</a>
            </div>
            <div class="col-span-6 font-semibold text-xl text-gray-800 p-2">
                月額売上設定<i class="las la-caret-right"></i>{{ $customer->customer_name }}
            </div>
            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11 && Auth::user()->base_id == session('base_id'))
                <div class="inline-block col-span-1 col-start-12">
                    <button id="monthly_sales_setting_register_modal_open" class="w-full text-indigo-500 border border-indigo-500 font-semibold rounded hover:bg-indigo-100 px-3 py-2">登録</button>
                </div>
            @endif
        </div>
    </x-slot>
    <div class="py-5 mx-5 grid grid-cols-12">
        <!-- 月額売上設定一覧 -->
        <table class="text-sm my-5 col-span-5">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-7/12">売上名</th>
                    <th class="p-2 px-2 w-3/12 text-right">売上金額</th>
                    <th class="p-2 px-2 w-2/12 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($monthly_sales_settings as $monthly_sales_setting)
                    <tr id="tr_{{ $monthly_sales_setting->sales_item_id }}">
                        <td class="p-1 px-2 border">{{ $monthly_sales_setting->sales_item->sales_item_name }}</td>
                        <td class="p-1 px-2 border text-right"><input type="tel" name="sales_amount[]" class="text-sm text-right w-3/4 bg-gray-100" value="{{ $monthly_sales_setting->sales_amount }}"><span>円</span></td>
                        <td class="p-1 px-2 border text-center">
                            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11 && Auth::user()->base_id == session('base_id'))
                                <a href="{{ route('monthly_sales_setting.delete', ['monthly_sales_setting_id' => $monthly_sales_setting->monthly_sales_setting_id]) }}" class="monthly_sales_setting_delete bg-red-400 text-white text-xs p-1 hover:bg-gray-400">削除</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- 月額売上設定登録モーダル -->
    <div id="monthly_sales_setting_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-40 mx-auto shadow-lg rounded-md bg-white max-w-md">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4>月額売上設定登録画面</h4>
                <button class="monthly_sales_setting_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                <form method="post" id="monthly_sales_setting_register_form" action="{{ route('monthly_sales_setting.register') }}">
                    @csrf
                    <label for="sales_item_id">売上項目</label><br>
                    <select id="sales_item_id" name="sales_item_id" class="w-full mb-5">
                        <option value="0">売上を選択</option>
                        @foreach($sales_items as $sales_item)
                            <option value="{{ $sales_item->sales_item_id }}">{{ $sales_item->sales_item_name }}</option>
                        @endforeach
                    </select>
                    <label for="sales_amount">売上金額</label><br>
                    <input type="tel" id="sales_amount" name="sales_amount" class="w-2/4 text-right" placeholder="金額" autocomplete="off" required><span class="ml-1">円</span>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <button type="button" id="monthly_sales_setting_register_enter" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">登録</button>
                <a class="monthly_sales_setting_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
