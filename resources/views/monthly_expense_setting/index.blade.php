<script src="{{ asset('js/monthly_expense_setting.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                月額経費設定<i class="las la-caret-right"></i>{{ $base->base_name }}
            </div>
            <div class="inline-block col-span-1 col-start-12">
                <button id="monthly_expense_setting_register_modal_open" class="cursor-pointer p-2 px-8"><i class="las la-plus-square la-2x"></i></button>
            </div>
        </div>
    </x-slot>
    <div class="py-12 mx-5 grid grid-cols-12">
        <!-- 月額経費設定一覧 -->
        <table class="text-sm mb-5 col-span-5">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-3/12">設定年月</th>
                    <th class="p-2 px-2 w-4/12">経費名</th>
                    <th class="p-2 px-2 w-3/12 text-right">経費金額</th>
                    <th class="p-2 px-2 w-2/12 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($monthly_expense_settings as $monthly_expense_setting)
                    <tr id="tr_{{ $monthly_expense_setting->monthly_expense_setting_id }}">
                        <td class="p-1 px-2 border">{{ $monthly_expense_setting->setting_date }}</td>
                        <td class="p-1 px-2 border">{{ $monthly_expense_setting->expense->expense_name }}</td>
                        <td class="p-1 px-2 border text-right">{{ number_format($monthly_expense_setting->expense_amount) }}円</td>
                        <td class="p-1 px-2 border text-center"><a href="{{ route('monthly_expense_setting.delete', ['monthly_expense_setting_id' => $monthly_expense_setting->monthly_expense_setting_id]) }}" class="monthly_expense_setting_delete bg-red-400 text-white text-xs p-1 hover:bg-gray-400">削除</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- 月額経費設定登録モーダル -->
    <div id="monthly_expense_setting_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-40 mx-auto shadow-lg rounded-md bg-white max-w-md">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4>月額経費設定登録画面</h4>
                <button class="monthly_expense_setting_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                <form method="post" action="{{ route('monthly_expense_setting.register') }}">
                    @csrf
                    <select name="expense_id" class="w-full">
                        <option value="0">経費を選択</option>
                        @foreach($expenses as $expense)
                            <option value="{{ $expense->expense_id }}">{{ $expense->expense_name }}</option>
                        @endforeach
                    </select>
                    <input type="tel" name="setting_date_year" class="text-right w-1/4 mt-5 inline-block" placeholder="設定年" autocomplete="off" required>年
                    <input type="tel" name="setting_date_month" class="text-right w-1/4 mt-5 inline-block" placeholder="設定月" autocomplete="off" required>月
                    <p class="inline-block text-red-500 text-sm underline ml-5">※例 2022年07月</p>
                    <input type="tel" name="expense_amount" class="w-2/4 mt-5 text-right" placeholder="金額" autocomplete="off" required>円
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                    <input type="submit" id="item_data_export" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white" value="登録">
                </form>
                <a class="monthly_expense_setting_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
