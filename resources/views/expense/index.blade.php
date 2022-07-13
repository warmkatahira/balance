<script src="{{ asset('js/expense.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                経費マスタ
            </div>
            <div class="inline-block col-span-1 col-start-12">
                <button id="expense_register_modal_open" class="cursor-pointer p-2 px-8"><i class="las la-plus-square la-2x"></i></button>
            </div>
        </div>
    </x-slot>
    <div class="py-12 mx-5 grid grid-cols-12">
        <!-- 経費一覧 -->
        <table class="text-sm mb-5 col-span-6">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-4/12">経費名</th>
                    <th class="p-2 px-2 w-7/12">経費備考</th>
                    <th class="p-2 px-2 w-1/12">経費区分</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($expenses as $expense)
                    <tr id="tr_{{ $expense->expense_id }}">
                        <td class="p-1 px-2 border">{{ $expense->expense_name }}</td>
                        <td class="p-1 px-2 border">{{ $expense->expense_note }}</td>
                        <td class="p-1 px-2 border">{{ $expense->expense_category }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- 経費登録モーダル -->
    <div id="expense_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-40 mx-auto shadow-lg rounded-md bg-white max-w-md">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4>経費登録画面</h4>
                <button class="expense_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                <form method="post" action="{{ route('expense.register') }}">
                    @csrf
                    <input type="text" name="expense_name" class="w-full mt-5" placeholder="経費名" autocomplete="off" required>
                    <input type="text" name="expense_note" class="w-full mt-5" placeholder="経費備考" autocomplete="off" required>
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                    <input type="submit" id="item_data_export" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white" value="登録">
                </form>
                <a class="expense_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
