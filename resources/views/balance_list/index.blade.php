<script src="{{ asset('js/balance_list.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                収支一覧
            </div>
        </div>
    </x-slot>
    <div class="py-5 mx-5 grid grid-cols-12">
        <!--▼▼▼▼▼ 検索条件 ▼▼▼▼▼-->
        <div class="col-span-12 shadow-lg border p-5 bg-teal-100">
            <form method="get" action="{{ route('balance_list.search') }}" class="m-0">
                <div class="grid grid-cols-12 grid-rows-2 grid-flow-col text-sm">
                    <div id="search_category" class="row-span-2 col-start-1 col-span-1">
                        <p class="row-span-1 py-2 font-bold">検索区分</p>
                        <div class="row-span-1">
                            <select id="search_category_select" name="search_category_select" class="rounded-lg w-10/12 text-sm">
                                @foreach (App\Consts\SearchConsts::SEARCH_CATEGORY_LIST as $key => $value)
                                    <option value="{{ $key }}" {{ session('search_category') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="base" class="row-span-2 col-start-2 col-span-2 {{ session('search_category') != '全社' && session('search_category') != null ? '' : 'hidden' }}">
                        <p class="row-span-1 py-2 font-bold">拠点</p>
                        <div class="row-span-1">
                            <select id="base_select" name="base_select" class="rounded-lg w-10/12 text-sm" {{ session('search_category') != '全社' && session('search_category') != null ? '' : 'disabled' }}>
                                <option value="全拠点">全拠点</option>
                                @foreach($bases as $base)
                                    <option value="{{ $base->base_id }}" {{ session('base_select') == $base->base_id ? 'selected' : '' }}>{{ $base->base_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="customer" class="row-span-2 col-start-4 col-span-3 {{ session('search_category') != '荷主' ? 'hidden' : '' }}">
                        <p class="row-span-1 py-2 font-bold">荷主</p>
                        <div class="row-span-1">
                            <select id="customer_select" name="customer_select" class="rounded-lg w-11/12 text-sm" {{ session('search_category') != '荷主' ? 'disabled' : '' }}>
                                <option value="全荷主">全荷主</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->customer_id }}" {{ session('customer_select') == $customer->customer_id ? 'selected' : '' }}>{{ $customer->customer_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="date_category" class="row-span-2 col-start-7 col-span-1">
                        <p class="row-span-1 py-2 font-bold">日付区分</p>
                        <div class="row-span-1">
                            <select id="date_category_select" name="date_category_select" class="rounded-lg w-10/12 text-sm">
                                @foreach (App\Consts\SearchConsts::DATE_CATEGORY_LIST as $key => $value)
                                    <option value="{{ $key }}" {{ session('date_category') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="day_period" class="row-span-2 col-start-8 col-span-3">
                        <p class="row-span-1 py-2 font-bold">日付期間</p>
                        <div class="row-span-1 grid grid-cols-12">
                            <input type="{{ session('date_category') == '月別' ? 'month' : 'date' }}" name="date_period_from" id="date_period_from" class="col-span-5 rounded-lg text-sm" value="{{ session('date_period_from') }}">
                            <p class="col-span-2 text-center py-2 text-sm">～</p>
                            <input type="{{ session('date_category') == '月別' ? 'month' : 'date' }}" name="date_period_to" id="date_period_to" class="col-span-5 rounded-lg text-sm" value="{{ session('date_period_to') }}">
                        </div>
                    </div>
                    <div class="row-span-2 col-start-11 col-span-2 text-right">
                        <button type="submit" id="balance_list_search" class="row-span-2 h-full w-10/12 rounded-lg bg-green-600 hover:bg-gray-400 text-white"><i class="las la-search la-lg"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <!--▲▲▲▲▲ 検索条件 ▲▲▲▲▲-->
        
        @if(session('search_category') == '全社')
            <!-- 全社単位の収支一覧 -->
            <table class="text-sm mb-5 col-span-6 mt-5">
                <thead>
                    <tr class="text-white bg-gray-600 border-gray-600">
                        <th class="p-2 px-2 w-3/12 text-left">収支期間</th>
                        <th class="p-2 px-2 w-2/12 text-right">売上</th>
                        <th class="p-2 px-2 w-2/12 text-right">経費</th>
                        <th class="p-2 px-2 w-2/12 text-right">利益</th>
                        <th class="p-2 px-2 w-1/12 text-right">利益率</th>
                        <th class="p-2 px-2 w-2/12 text-center">操作</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($balances as $balance)
                        <tr class="hover:bg-teal-100">
                            <td class="p-1 px-2 border">{{ $balance->date }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($balance->total_sales) }}円</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($balance->total_expenses) }}円</td>
                            <td class="p-1 px-2 border text-right {{ $balance->total_profit < 0 ? 'text-red-400 font-bold bg-rose-100' : '' }}">{{ number_format($balance->total_profit) }}円</td>
                            <td class="p-1 px-2 border text-right">
                                @if($balance->total_sales != 0)
                                    {{ number_format(($balance->total_profit / $balance->total_sales) * 100, 2) }}%
                                @else
                                    0.00%
                                @endif
                            </td>
                            <td class="p-1 px-2 border text-center"><a href="{{ route('balance_list_zensha.index', ['date' => $balance->date]) }}" class="bg-sky-400 text-white text-xs p-1 hover:bg-gray-400">詳細</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        
        @if(session('search_category') == '拠点')
            <!-- 拠点単位の収支一覧 -->
            <table class="text-sm mb-5 col-span-8 mt-5">
                <thead>
                    <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                        <th class="p-2 px-2 w-2/12">収支期間</th>
                        <th class="p-2 px-2 w-2/12">拠点</th>
                        <th class="p-2 px-2 w-2/12 text-right">売上</th>
                        <th class="p-2 px-2 w-2/12 text-right">経費</th>
                        <th class="p-2 px-2 w-2/12 text-right">利益</th>
                        <th class="p-2 px-2 w-1/12 text-right">利益率</th>
                        <th class="p-2 px-2 w-1/12 text-center">操作</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($balances as $balance)
                        <tr class="hover:bg-teal-100">
                            <td class="p-1 px-2 border">{{ $balance->date }}</td>
                            <td class="p-1 px-2 border">{{ $balance->base->base_name }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($balance->total_sales) }}円</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($balance->total_expenses) }}円</td>
                            <td class="p-1 px-2 border text-right {{ $balance->total_profit < 0 ? 'text-red-400 font-bold bg-rose-100' : '' }}">{{ number_format($balance->total_profit) }}円</td>
                            <td class="p-1 px-2 border text-right">
                                @if($balance->total_sales != 0)
                                    {{ number_format(($balance->total_profit / $balance->total_sales) * 100, 2) }}%
                                @else
                                    0.00%
                                @endif
                            </td>
                            <td class="p-1 px-2 border text-center"><a href="{{ route('balance_list_base.index', ['base_id' => $balance->balance_base_id, 'date' => $balance->date]) }}" class="bg-sky-400 text-white text-xs p-1 hover:bg-gray-400">詳細</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if(session('search_category') == '荷主')
            <!-- 荷主単位の収支一覧 -->
            <table class="text-sm col-span-12 mt-5">
                <thead>
                    <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                        <th class="p-2 px-2 w-1/12">収支期間</th>
                        <th class="p-2 px-2 w-1/12">拠点</th>
                        <th class="p-2 px-2 w-3/12">荷主名</th>
                        <th class="p-2 px-2 w-1/12 text-right">売上</th>
                        <th class="p-2 px-2 w-1/12 text-right">経費</th>
                        <th class="p-2 px-2 w-1/12 text-right">利益</th>
                        <th class="p-2 px-2 w-1/12 text-right">利益率</th>
                        @if(session('date_category') == '日別')
                            <th class="p-2 px-2 w-1/12 text-center">修正</th>
                            <th class="p-2 px-2 w-1/12 text-center">更新日時</th>
                        @endif
                        <th class="p-2 px-2 w-1/12 text-center">操作</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($balances as $balance)
                        <tr class="hover:bg-teal-100">
                            <td class="p-1 px-2 border">{{ $balance->date }}</td>
                            <td class="p-1 px-2 border">{{ $balance->base->base_name }}</td>
                            <td class="p-1 px-2 border">{{ $balance->customer->customer_name }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($balance->total_sales) }}円</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($balance->total_expenses) }}円</td>
                            <td class="p-1 px-2 border text-right {{ $balance->total_profit < 0 ? 'text-red-400 font-bold bg-rose-100' : '' }}">{{ number_format($balance->total_profit) }}円</td>
                            <td class="p-1 px-2 border text-right">
                                @if($balance->total_sales != 0)
                                    {{ number_format(($balance->total_profit / $balance->total_sales) * 100, 2) }}%
                                @else
                                    0.00%
                                @endif
                            </td>
                            @if(session('date_category') == '日別')
                                <td class="p-1 px-2 border text-center">
                                    @if($balance->created_at != $balance->updated_at)
                                        <i class="las la-pen-fancy la-lg"></i>
                                    @endif
                                </td>
                                <td class="p-1 px-2 border text-center text-xs">{{ $balance->updated_at }}</td>
                            @endif
                            <td class="p-1 px-2 border text-center">
                                <a href="{{ session('date_category') == '日別' ? route('balance_list.detail', ['balance_id' => $balance->balance_id]) : route('balance_list_customer.index', ['base_id' => $balance->balance_base_id, 'customer_id' => $balance->balance_customer_id, 'date' => $balance->date]) }}" class="bg-sky-400 text-white text-xs p-1 hover:bg-gray-400 text-center">詳細</a>
                                <!-- 自分が登録した収支 or システム管理者の場合 or 管理者の場合は自営業所の収支のみ修正・削除ボタンを表示 -->
                                @if($balance->register_user_id == Auth::user()->id || Auth::user()->role_id == 1 || Auth::user()->role_id == 11 && Auth::user()->base_id == $balance->balance_base_id)
                                    @if(session('date_category') == '日別')
                                        <a href="{{ route('balance_modify.index', ['balance_id' => $balance->balance_id]) }}" class="bg-green-400 text-white text-xs p-1 hover:bg-gray-400 text-center ml-10">修正</a>
                                        <a href="{{ route('balance.delete', ['balance_id' => $balance->balance_id]) }}" class="balance_delete bg-red-400 text-white text-xs p-1 hover:bg-gray-400 text-center ml-10">削除</a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if($balances)
            <!-- ページネーション -->
            <div class="col-span-12 my-5">
                {{ $balances->appends(request()->input())->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
