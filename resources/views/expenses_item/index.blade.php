<script src="{{ asset('js/expenses_item.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                経費項目マスタ
            </div>
            @if(Auth::user()->role_id == 1)
                <div class="inline-block col-span-1 col-start-12">
                    <button id="expenses_item_register_modal_open" class="w-full text-indigo-500 border border-indigo-500 font-semibold rounded hover:bg-indigo-100 px-3 py-2">登録</button>
                </div>
            @endif
        </div>
    </x-slot>
    <div class="py-5 mx-5 grid grid-cols-12">
        <!-- 経費項目一覧 -->
        <table class="text-sm mb-5 col-span-6">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-3/12">経費項目名</th>
                    <th class="p-2 px-2 w-5/12">経費項目備考</th>
                    <th class="p-2 px-2 w-2/12">経費項目区分</th>
                    @if(Auth::user()->role_id == 1)
                        <th class="p-2 px-2 w-2/12 text-center">操作</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($expenses_items as $expenses_item)
                    <tr id="tr_{{ $expenses_item->expenses_item_id }}">
                        <td class="p-1 px-2 border">{{ $expenses_item->expenses_item_name }}</td>
                        <td class="p-1 px-2 border">{{ $expenses_item->expenses_item_note }}</td>
                        <td class="p-1 px-2 border">{{ $expenses_item->expenses_item_category }}</td>
                        @if(Auth::user()->role_id == 1)
                            <td class="p-1 px-2 border text-center">
                                <a href="{{ route('expenses_item.delete', ['expenses_item_id' => $expenses_item->expenses_item_id]) }}" class="expenses_item_delete bg-red-600 text-white hover:bg-gray-400 p-1 text-xs">削除</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- 経費項目登録モーダル -->
    <div id="expenses_item_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-40 mx-auto shadow-lg rounded-md bg-white max-w-md">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4>経費項目登録画面</h4>
                <button class="expenses_item_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                <form method="post" id="expenses_item_register_form" action="{{ route('expenses_item.register') }}">
                    @csrf
                    <label for="expenses_item_name" class="">経費項目名</label><br>
                    <input type="text" id="expenses_item_name" name="expenses_item_name" class="w-full mb-5" placeholder="経費項目名" autocomplete="off" required>
                    <label for="expenses_item_note" class="">経費項目備考</label><br>
                    <input type="text" id="expenses_item_note" name="expenses_item_note" class="w-full mb-5" placeholder="任意入力" autocomplete="off">
                    <label for="expenses_item_category" class="">経費項目区分</label><br>
                    <select id="expenses_item_category" name="expenses_item_category" class="w-full">
                        <option value="毎月" selected>毎月</option>
                        <option value="変動">変動</option>
                    </select>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <button type="button" id="expenses_item_register_enter" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">登録</button>
                <a class="expenses_item_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
