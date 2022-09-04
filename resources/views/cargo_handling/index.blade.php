<script src="{{ asset('js/cargo_handling.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                荷役マスタ
            </div>
            @if(Auth::user()->role_id == 1)
                <div class="col-start-11 col-span-1">
                    <button id="cargo_handling_register_modal_open" class="w-full text-indigo-500 border border-indigo-500 font-semibold rounded hover:bg-indigo-100 px-3 py-2">登録</button>
                </div>
                <div class="col-start-12 col-span-1">
                    <button type="button" id="cargo_handling_save" class="w-full text-teal-500 border border-teal-500 font-semibold rounded hover:bg-teal-100 px-3 py-2">保存</button>
                </div>
            @endif
        </div>
    </x-slot>
    <div class="grid grid-cols-12 py-5 mx-5">
        <!-- 荷役一覧 -->
        <table class="text-sm mb-5 col-span-4">
            <thead>
                <tr class="text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-10/12">荷役名</th>
                    @if(Auth::user()->role_id == 1)
                        <th class="p-2 px-2 w-2/12 text-center">操作</th>
                    @endif
                </tr>
            </thead> 
            <tbody id="cargo_handling_body" class="bg-white">
                @foreach($cargo_handlings as $cargo_handling)
                    <tr id="tr_{{ $cargo_handling->cargo_handling_name }}">
                        <td class="p-1 px-2 border"><input name="cargo_handling_name[{{ $cargo_handling->cargo_handling_id }}]" value="{{ $cargo_handling->cargo_handling_name }}" readonly></td>
                        @if(Auth::user()->role_id == 1)
                            <td class="p-1 px-2 border text-center">
                                <a href="{{ route('cargo_handling.delete', ['cargo_handling_id' => $cargo_handling->cargo_handling_id]) }}" class="cargo_handling_delete bg-red-600 text-white hover:bg-gray-400 p-1 text-xs">削除</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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
                <form method="post" id="cargo_handling_register_form" action="{{ route('cargo_handling.register') }}" class="m-0">
                    @csrf
                    <label for="cargo_handling_name" class="">荷役名</label><br>
                    <input type="text" id="cargo_handling_name" name="cargo_handling_name" class="w-full" placeholder="荷役名" autocomplete="off" required>
                </form>
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
