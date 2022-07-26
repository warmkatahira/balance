<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                拠点マスタ
            </div>
        </div>
    </x-slot>
    <div class="py-5 mx-5 grid grid-cols-12">
        <!-- 拠点一覧 -->
        <table class="text-sm mb-5 col-span-4">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-4/12">拠点</th>
                    <th class="p-2 px-2 w-8/12"></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($bases as $base)
                    <tr>
                        <td class="p-1 px-2 border">{{ $base->base_name }}</td>
                        <td class="p-1 px-2 border text-center">
                            <a href="{{ route('labor_cost_setting.index', ['base_id' => $base->base_id]) }}" class="bg-sky-400 text-white text-xs p-1 hover:bg-gray-400">人件費設定</a>
                            <a href="{{ route('monthly_expenses_setting.index', ['base_id' => $base->base_id]) }}" class="bg-sky-400 text-white text-xs p-1 hover:bg-gray-400 ml-5">月額経費設定</a>
                            <a href="{{ route('sales_plan.index', ['base_id' => $base->base_id]) }}" class="bg-sky-400 text-white text-xs p-1 hover:bg-gray-400 ml-5">売上計画設定</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
