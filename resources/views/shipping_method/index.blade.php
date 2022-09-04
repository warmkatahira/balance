<script src="{{ asset('js/shipping_method.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                配送方法マスタ
            </div>
            @if(Auth::user()->role_id == 1)
                <div class="col-start-12 col-span-1">
                    <button id="shipping_method_register_modal_open" class="w-full text-indigo-500 border border-indigo-500 font-semibold rounded hover:bg-indigo-100 px-3 py-2">登録</button>
                </div>
            @endif
        </div>
    </x-slot>
    <div class="py-5 mx-5 grid grid-cols-12">
        <!-- 配送方法一覧 -->
        <table class="text-sm mb-5 col-span-3">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-6/12">運送会社</th>
                    <th class="p-2 px-2 w-6/12">配送方法</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($shipping_methods as $shipping_method)
                    <tr id="tr_{{ $shipping_method->shipping_method_id }}">
                        <td class="p-1 px-2 border">{{ $shipping_method->shipping_company }}</td>
                        <td class="p-1 px-2 border">{{ $shipping_method->shipping_method }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- 配送方法登録モーダル -->
    <div id="shipping_method_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-40 mx-auto shadow-lg rounded-md bg-white max-w-md">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4>配送方法登録画面</h4>
                <button class="shipping_method_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                <form method="post" id="shipping_method_register_form" action="{{ route('shipping_method.register') }}">
                    @csrf
                    <label for="shipping_company" class="">運送会社</label><br>
                    <input type="text" id="shipping_company" name="shipping_company" class="w-full mb-5" placeholder="運送会社" autocomplete="off" required>
                    <label for="shipping_method" class="">配送方法</label><br>
                    <input type="text" id="shipping_method" name="shipping_method" class="w-full" placeholder="配送方法" autocomplete="off" required>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <button type="button" id="shipping_method_register_enter" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">登録</button>
                <a class="shipping_method_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
