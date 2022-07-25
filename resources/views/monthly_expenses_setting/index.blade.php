<script src="{{ asset('js/monthly_expenses_setting.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-1">
                <a href="{{ session('redirect_url') }}" class="inline-block text-center w-full bg-black text-white border font-semibold rounded hover:bg-gray-400 px-3 py-2">戻る</a>
            </div>
            <div class="col-span-6 font-semibold text-xl text-gray-800 p-2">
                月額経費設定<i class="las la-caret-right"></i>{{ Auth::user()->base->base_name }}
            </div>
            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11 && Auth::user()->base_id == session('base_id'))
                <div class="inline-block col-span-1 col-start-12">
                    <button id="monthly_expenses_setting_register_modal_open" class="w-full text-indigo-500 border border-indigo-500 font-semibold rounded hover:bg-indigo-100 px-3 py-2">登録</button>
                </div>
            @endif
        </div>
    </x-slot>
    <div class="py-5 mx-5 grid grid-cols-12">
        <!--▼▼▼▼▼ 検索条件 ▼▼▼▼▼-->
        <div class="col-span-12 shadow-lg border p-5 bg-teal-100">
            <form method="get" action="{{ route('monthly_expenses_setting.search') }}" class="m-0">
                <div class="grid grid-cols-12 grid-rows-2 grid-flow-col text-sm">
                    <div id="base" class="row-span-2 col-span-2">
                        <p class="row-span-1 py-2 font-bold">設定年月</p>
                        <div class="row-span-1">
                            <input type="month" name="month_select" id="month_select" class="text-sm rounded-lg" value="{{ session('month_select') }}">
                        </div>
                    </div>
                    <div class="row-span-2 col-start-11 col-span-2 text-right">
                        <button type="submit" id="balance_list_search" class="row-span-2 h-full w-10/12 rounded-lg bg-green-600 hover:bg-gray-400 text-white"><i class="las la-search la-lg"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <!--▲▲▲▲▲ 検索条件 ▲▲▲▲▲-->

        <!-- 月額経費設定一覧 -->
        <table class="text-sm my-5 col-span-5">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-3/12">設定年月</th>
                    <th class="p-2 px-2 w-4/12">経費名</th>
                    <th class="p-2 px-2 w-3/12 text-right">経費金額</th>
                    <th class="p-2 px-2 w-2/12 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($monthly_expenses_settings as $monthly_expenses_setting)
                    <tr id="tr_{{ $monthly_expenses_setting->monthly_expenses_setting_id }}">
                        <td class="p-1 px-2 border">{{ substr($monthly_expenses_setting->setting_date, 0, 4).'年'.substr($monthly_expenses_setting->setting_date, 4, 2).'月' }}</td>
                        <td class="p-1 px-2 border">{{ $monthly_expenses_setting->expenses_item->expenses_item_name }}</td>
                        <td class="p-1 px-2 border text-right">{{ number_format($monthly_expenses_setting->expenses_amount) }}円</td>
                        <td class="p-1 px-2 border text-center">
                            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11 && Auth::user()->base_id == session('base_id'))
                                <a href="{{ route('monthly_expenses_setting.delete', ['monthly_expenses_setting_id' => $monthly_expenses_setting->monthly_expenses_setting_id]) }}" class="monthly_expenses_setting_delete bg-red-400 text-white text-xs p-1 hover:bg-gray-400">削除</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- 月額経費設定登録モーダル -->
    <div id="monthly_expenses_setting_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-40 mx-auto shadow-lg rounded-md bg-white max-w-md">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4>月額経費設定登録画面</h4>
                <button class="monthly_expenses_setting_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                <form method="post" id="monthly_expenses_setting_register_form" action="{{ route('monthly_expenses_setting.register') }}">
                    @csrf
                    <select id="expenses_item_id" name="expenses_item_id" class="w-full">
                        <option value="0">経費を選択</option>
                        @foreach($expenses_items as $expenses_item)
                            <option value="{{ $expenses_item->expenses_item_id }}">{{ $expenses_item->expenses_item_name }}</option>
                        @endforeach
                    </select>
                    <input type="tel" id="setting_date_year" name="setting_date_year" class="text-right w-1/4 mt-5 inline-block" placeholder="設定年" autocomplete="off" required>年
                    <input type="tel" id="setting_date_month" name="setting_date_month" class="text-right w-1/4 mt-5 inline-block" placeholder="設定月" autocomplete="off" required>月
                    <p class="inline-block text-red-500 text-sm underline ml-5">※例 2022年07月</p>
                    <input type="tel" id="expenses_amount" name="expenses_amount" class="w-2/4 mt-5 text-right" placeholder="金額" autocomplete="off" required>円
                </form>
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <button type="button" id="monthly_expenses_setting_register_enter" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">登録</button>
                <a class="monthly_expenses_setting_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
