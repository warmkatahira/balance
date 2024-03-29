<script src="{{ asset('js/sales_item.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                売上項目マスタ
            </div>
            @if(Auth::user()->role_id == 1)
                <div class="col-start-12 col-span-1">
                    <button id="sales_item_register_modal_open" class="w-full text-indigo-500 border border-indigo-500 font-semibold rounded hover:bg-indigo-100 px-3 py-2">登録</button>
                </div>
            @endif
        </div>
    </x-slot>
    <div class="py-5 mx-5 grid grid-cols-12">
        <!-- 売上項目一覧 -->
        <table class="text-sm mb-5 col-span-4">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-4/12">売上項目名</th>
                    <th class="p-2 px-2 w-6/12">売上項目備考</th>
                    @if(Auth::user()->role_id == 1)
                        <th class="p-2 px-2 w-2/12 text-center">操作</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($sales_items as $sales_item)
                    <tr id="tr_{{ $sales_item->sales_item_id }}">
                        <td class="p-1 px-2 border">{{ $sales_item->sales_item_name }}</td>
                        <td class="p-1 px-2 border">{{ $sales_item->sales_item_note }}</td>
                        @if(Auth::user()->role_id == 1)
                            <td class="p-1 px-2 border text-center">
                                <a href="{{ route('sales_item.delete', ['sales_item_id' => $sales_item->sales_item_id]) }}" class="sales_item_delete bg-red-600 text-white hover:bg-gray-400 p-1 text-xs">削除</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- 売上項目登録モーダル -->
    <div id="sales_item_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-40 mx-auto shadow-lg rounded-md bg-white max-w-md">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4>売上項目登録画面</h4>
                <button class="sales_item_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                <form method="post" id="sales_item_register_form" action="{{ route('sales_item.register') }}">
                    @csrf
                    <label for="sales_item_name" class="">売上項目名</label><br>
                    <input type="text" id="sales_item_name" name="sales_item_name" class="w-full mb-5" placeholder="売上項目名" autocomplete="off" required>
                    <label for="sales_item_note" class="">売上項目備考</label><br>
                    <input type="text" id="sales_item_note" name="sales_item_note" class="w-full" placeholder="任意入力" autocomplete="off">
                </form>
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <button type="button" id="sales_item_register_enter" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">登録</button>
                <a class="sales_item_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
