<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                人件費マスタ
            </div>
        </div>
    </x-slot>
    <div class="py-12 mx-5 grid grid-cols-12">
        <!-- 人件費一覧 -->
        <table class="text-sm mb-5 col-span-2">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-8/12">人件費区分</th>
                    <th class="p-2 px-2 w-4/12 text-right">時給</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($labor_costs as $labor_cost)
                    <tr id="tr_{{ $labor_cost->labor_cost_id }}">
                        <td class="p-1 px-2 border">{{ $labor_cost->labor_cost_category }}</td>
                        <td class="p-1 px-2 border text-right">{{ number_format($labor_cost->hourly_wage) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
