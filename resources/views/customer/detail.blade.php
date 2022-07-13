<script src="{{ asset('js/customer.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                荷主詳細
            </div>
            <div class="col-start-11 col-span-1">
                <button id="cargo_handling_register_modal_open" class="w-full text-indigo-500 border border-indigo-500 font-semibold rounded hover:bg-indigo-100 px-3 py-2">荷役登録</button>
            </div>
            <div class="col-start-12 col-span-1">
                <button type="button" id="cargo_handling_setting_save" class="w-full text-teal-500 border border-teal-500 font-semibold rounded hover:bg-teal-100 px-3 py-2">保存</button>
            </div>
        </div>
    </x-slot>
    <form method="post" id="cargo_handling_setting_form" action="{{ route('customer_setting.update') }}" class="m-0">
        @csrf
        <div class="py-12 mx-5 grid grid-cols-12">
            <div class="col-span-6">
                <div class="col-span-12 grid grid-cols-12">
                    <p class="col-span-3 font-bold">拠点</p>
                    <p class="col-span-9">{{ $customer->base->base_name }}</p>
                    <p class="col-span-3 font-bold mt-4">荷主名</p>
                    <input type="text" name="customer_name" class="col-span-5 text-sm bg-gray-100 mt-2" value="{{ $customer->customer_name }}" autocomplete="off">
                    <p class="col-start-1 col-span-3 font-bold mt-4">月間保管費</p>
                    <input type="tel" name="monthly_storage_fee" class="col-span-2 text-sm text-right bg-gray-100 mt-2" value="{{ $customer->monthly_storage_fee }}" autocomplete="off">
                    <p class="col-start-1 col-span-3 font-bold mt-4">稼働日数</p>
                    <input type="tel" name="working_days" class="col-span-2 text-sm text-right bg-gray-100 mt-2" value="{{ $customer->working_days }}" autocomplete="off">
                    <p class="col-start-1 col-span-3 font-bold mt-4">事務手数料区分</p>
                    <input type="text" name="handling_fee_category" class="col-span-2 text-sm bg-gray-100 mt-2" value="{{ $customer->handling_fee_category }}" autocomplete="off">
                </div>
                <p class="col-span-12 font-bold mt-5"><i class="las la-cog"></i>荷役設定状況</p>
                <table class="col-span-12 text-sm mb-5">
                    <thead>
                        <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                            <th class="p-2 px-2 w-5/12">荷役名</th>
                            <th class="p-2 px-2 w-2/12 text-right">荷役単価</th>
                            <th class="p-2 px-2 w-3/12 text-center">収支登録初期表示</th>
                            <th class="p-2 px-2 w-2/12 text-center">操作</th>
                        </tr>
                    </thead>
                    <tbody id="cargo_handling_setting_body" class="bg-white">
                        @foreach($customer->cargo_handlings as $cargo_handling)
                            <tr id="tr_{{ $cargo_handling->cargo_handling_id }}">
                                <td class="p-1 px-2 border">{{ $cargo_handling->cargo_handling_name }}</td>
                                <td class="p-1 px-2 border text-right"><input type="tel" name="cargo_handling_unit_price[{{ $cargo_handling->cargo_handling_id }}]" class="text-sm text-right w-3/4 bg-gray-100 cargo_handling_unit_price" value="{{ $cargo_handling->pivot->cargo_handling_unit_price }}"></td>
                                <td class="p-1 px-2 border text-center"><input type="checkbox" name="balance_register_default_disp[{{ $cargo_handling->cargo_handling_id }}]" class="text-sm bg-gray-100" {{ $cargo_handling->pivot->balance_register_default_disp == 1 ? 'checked' : '' }}></td>
                                <td class="p-1 px-2 border text-center"><button type="button" id="{{ $cargo_handling->cargo_handling_id }}" class="cargo_handling_setting_delete bg-red-600 text-white hover:bg-gray-400 p-1 text-xs">削除</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </form>
    <!-- 荷役設定モーダル -->
    <div id="cargo_handling_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-40 mx-auto shadow-lg rounded-md bg-white max-w-md">
            <!-- モーダルヘッダー -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4>荷役設定登録画面</h4>
                <button class="cargo_handling_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- モーダルボディ -->
            <div class="p-10">
                <select id="cargo_handling_id" class="w-full text-sm">
                    <option value="0">荷役を選択</option>
                    @foreach($cargo_handlings as $cargo_handling)
                        <option value="{{ $cargo_handling->cargo_handling_id }}">{{ $cargo_handling->cargo_handling_name }}</option>
                    @endforeach
                </select>
                <input type="tel" id="cargo_handling_unit_price" class="w-1/4 mt-5 text-sm text-right" placeholder="荷役単価" autocomplete="off" required>
                <div class="flex items-center mr-4 mt-5">
                    <input checked id="balance_register_default_disp" type="checkbox" class="w-4 h-4 text-teal-600 bg-gray-100 rounded border-gray-300 focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="balance_register_default_disp" class="ml-2 text-gray-900 dark:text-gray-300">収支登録初期表示</label>
                </div>
            </div>
            <!-- モーダルフッター -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <a id="cargo_handling_register" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">登録</a>
                <a class="cargo_handling_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
