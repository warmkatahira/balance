<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-7 font-semibold text-xl text-gray-800 p-2">
                収支詳細<i class="las la-caret-right"></i>{{ $base->base_name }}<i class="las la-calendar"></i>{{ $balance_date }}
            </div>
        </div>
    </x-slot>
    <div class="py-5 mx-5 grid grid-cols-12">
        <div class="mb-5 col-span-12 grid grid-cols-12 border-b-2">
            <div class="col-span-3">
                <p class="text-xl font-bold">荷主数  {{ number_format(count($balances)) }}</p>
            </div>
            <div class="col-span-3">
                <p class="text-xl font-bold">売上合計  {{ number_format($total_amount->total_sales) }}円</p>
            </div>
            <div class="col-span-3">
                <p class="text-xl font-bold">経費合計  {{ number_format($total_amount->total_expenses) }}円</p>
            </div>
            <div class="col-span-3">
                <p class="text-xl font-bold {{ $total_amount->total_profit < 0 ? 'text-red-400 font-bold' : '' }}">利益合計  {{ number_format($total_amount->total_profit) }}円</p>
            </div>
        </div>
        <div class="col-span-5">
            <!-- 収支一覧 -->
            <p class="text-sm">収支一覧</p>
            <table class="text-sm mb-5 w-full">
                <thead>
                    <tr class="text-white bg-gray-600 border-gray-600">
                        <th class="p-2 px-2 w-6/12 text-left">荷主名</th>
                        <th class="p-2 px-2 w-2/12 text-right">売上</th>
                        <th class="p-2 px-2 w-2/12 text-right">経費</th>
                        <th class="p-2 px-2 w-2/12 text-right">利益</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($balances as $balance)
                        <tr>
                            <td class="p-1 px-2 border">{{ $balance->customer->customer_name }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($balance->sales) }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($balance->expenses) }}</td>
                            <td class="p-1 px-2 border text-right {{ $balance->profit < 0 ? 'text-red-400 font-bold bg-rose-100' : '' }}">{{ number_format($balance->profit) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-start-8 col-span-5">
            <!-- 月額経費一覧 -->
            <p class="text-sm">月額経費一覧</p>
            <table class="text-sm mb-5 w-full">
                <thead>
                    <tr class="text-white bg-gray-600 border-gray-600">
                        <th class="p-2 px-2 w-6/12 text-left">経費名</th>
                        <th class="p-2 px-2 w-6/12 text-right">経費金額</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($monthly_expenses as $monthly_expense)
                        <tr>
                            <td class="p-1 px-2 border">{{ $monthly_expense->expense->expense_name }}</td>
                            <td class="p-1 px-2 border text-right">{{ number_format($monthly_expense->expense_amount) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
