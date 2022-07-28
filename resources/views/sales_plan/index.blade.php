<script src="{{ asset('js/sales_plan.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-1">
                <a href="{{ session('index_url') }}" class="inline-block text-center w-full bg-black text-white border font-semibold rounded hover:bg-gray-400 px-3 py-2">戻る</a>
            </div>
            <div class="col-span-6 font-semibold text-xl text-gray-800 p-2">
                売上計画設定<i class="las la-caret-right"></i>{{ Auth::user()->base->base_name }}
            </div>
            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11 && Auth::user()->base_id == session('base_id'))
                <div class="inline-block col-span-1 col-start-12">
                    <button id="sales_plan_register_modal_open" class="w-full text-indigo-500 border border-indigo-500 font-semibold rounded hover:bg-indigo-100 px-3 py-2">登録</button>
                </div>
            @endif
        </div>
    </x-slot>
    <div class="py-5 mx-5 grid grid-cols-12">
        <!--▼▼▼▼▼ 検索条件 ▼▼▼▼▼-->
        <div class="col-span-12 shadow-lg border p-5 bg-teal-100">
            <form method="get" action="{{ route('sales_plan.search') }}" class="m-0">
                <div class="grid grid-cols-12 text-sm">
                    <p class="col-span-1 font-bold py-2 text-center">計画年月</p>
                    <div class="col-span-1 text-left">
                        <input type="month" name="month_select_from" id="month_select_from" class="text-sm rounded-lg" value="{{ session('month_select_from') }}">
                    </div>
                    <p class="col-span-1 font-bold py-2 text-center">～</p>
                    <div class="col-span-1">
                        <input type="month" name="month_select_to" id="month_select_to" class="text-sm rounded-lg" value="{{ session('month_select_to') }}">
                    </div>
                    <div class="col-start-11 col-span-2 text-right">
                        <button type="submit" class="row-span-2 h-full w-10/12 rounded-lg bg-green-600 hover:bg-gray-400 text-white"><i class="las la-search la-lg"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <!--▲▲▲▲▲ 検索条件 ▲▲▲▲▲-->

        <!-- 売上計画一覧 -->
        <table class="text-sm my-5 col-span-4">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-3/12">計画年月</th>
                    <th class="p-2 px-2 w-6/12 text-right">売上計画金額</th>
                    <th class="p-2 px-2 w-3/12 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($sales_plans as $sales_plan)
                    <tr>
                        <td class="p-1 px-2 border">{{ substr($sales_plan->plan_date, 0, 4).'年'.substr($sales_plan->plan_date, 4, 2).'月' }}</td>
                        <td class="p-1 px-2 border text-right">{{ number_format($sales_plan->sales_plan_amount) }}円</td>
                        <td class="p-1 px-2 border text-center">
                            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11 && Auth::user()->base_id == session('base_id'))
                                <a href="{{ route('sales_plan.delete', ['sales_plan_id' => $sales_plan->sales_plan_id]) }}" class="sales_plan_delete bg-red-400 text-white text-xs p-1 hover:bg-gray-400">削除</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- 売上計画登録モーダル -->
    <div id="sales_plan_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-40 mx-auto shadow-lg rounded-md bg-white max-w-md">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4>売上計画登録画面</h4>
                <button class="sales_plan_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                <form method="post" id="sales_plan_register_form" action="{{ route('sales_plan.register') }}">
                    @csrf
                    <input type="month" id="plan_date" name="plan_date" class="text-sm w-1/2 mt-5 inline-block" autocomplete="off" required>
                    <input type="tel" id="sales_plan_amount" name="sales_plan_amount" class="text-sm w-2/4 mt-5 text-right" placeholder="売上計画金額" autocomplete="off" required>円
                </form>
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <button type="button" id="sales_plan_register_enter" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">登録</button>
                <a class="sales_plan_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
