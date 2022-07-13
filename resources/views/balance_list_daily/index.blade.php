<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                収支一覧（日別）
            </div>
        </div>
    </x-slot>
    <div class="py-12 mx-5 grid grid-cols-12">
        <!-- 日別×拠点別収支一覧 -->
        <table class="text-sm mb-5 col-span-4">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-5/12">拠点</th>
                    <th class="p-2 px-2 w-4/12">収支日</th>
                    <th class="p-2 px-2 w-3/12 text-center">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($balances as $balance)
                    <tr>
                        <td class="p-1 px-2 border">{{ $balance->base->base_name }}</td>
                        <td class="p-1 px-2 border">{{ $balance->balance_date }}</td>
                        <td class="p-1 px-2 border text-center"><a href="{{ route('balance_list_daily.detail', ['base_id' => $balance->balance_base_id, 'balance_date' => $balance->balance_date]) }}" class="bg-sky-400 text-white text-xs p-1 hover:bg-gray-400">詳細</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
