<script src="{{ asset('js/cargo_handling.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                荷役マスタ
            </div>
            <div class="col-start-11 col-span-1">
                <button id="cargo_handling_register_modal_open" class="w-full text-indigo-500 border border-indigo-500 font-semibold rounded hover:bg-indigo-100 px-3 py-2">荷役登録</button>
            </div>
            <div class="col-start-12 col-span-1">
                <button type="button" id="cargo_handling_save" class="w-full text-teal-500 border border-teal-500 font-semibold rounded hover:bg-teal-100 px-3 py-2">保存</button>
            </div>
        </div>
    </x-slot>
    <form method="post" id="cargo_handling_form" action="{{ route('cargo_handling.register') }}" class="m-0">
        @csrf
        <div class="py-12 mx-5">
            <!-- 荷役一覧 -->
            <table class="text-sm mb-5 w-6/12">
                <thead>
                    <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                        <th class="p-2 px-2 w-4/12"><a href="{{ route('customer.sort', ['sort_column' => 'customer_name', 'direction' => ($sort_column != 'customer_name' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">荷役名</a>{{ strpos(url()->full(), 'sort/customer_name') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2 w-5/12"><a href="{{ route('customer.sort', ['sort_column' => 'shipping_unit_price_pcs', 'direction' => ($sort_column != 'shipping_unit_price_pcs' ? 'desc' : ($direction == 'asc' ? 'desc' : 'asc')) ]) }}">荷役説明</a>{{ strpos(url()->full(), 'sort/shipping_unit_price_pcs') !== false ? strpos(url()->full(), 'asc') !== false ? '↑' : '↓' : Null }}</th>
                        <th class="p-2 px-2 w-3/12 text-center">操作</th>
                    </tr>
                </thead> 
                <tbody id="cargo_handling_body" class="bg-white">
                    @foreach($cargo_handlings as $cargo_handling)
                        <tr id="tr_{{ $cargo_handling->cargo_handling_name }}">
                            <td class="p-1 px-2 border"><input name="cargo_handling_name[{{ $cargo_handling->cargo_handling_id }}]" value="{{ $cargo_handling->cargo_handling_name }}" readonly></td>
                            <td class="p-1 px-2 border"><input name="cargo_handling_note[]" value="{{ $cargo_handling->cargo_handling_note }}" readonly></td>
                            <td class="p-1 px-2 border text-center"><button type="button" id="{{ $cargo_handling->cargo_handling_name }}" class="cargo_handling_delete bg-red-600 text-white hover:bg-gray-400 p-1 text-xs">削除</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
    <!-- 荷役登録モーダル -->
    <div id="cargo_handling_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-40 mx-auto shadow-lg rounded-md bg-white max-w-md">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4>荷役登録画面</h4>
                <button class="cargo_handling_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                <input type="text" id="cargo_handling_name" name="cargo_handling_name" class="w-full mt-5" placeholder="荷役名" autocomplete="off" required>
                <input type="text" id="cargo_handling_note" name="cargo_handling_note" class="w-full mt-5" placeholder="荷役備考" autocomplete="off">
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <a id="cargo_handling_register" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">登録</a>
                <a class="cargo_handling_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
