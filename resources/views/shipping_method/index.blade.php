<script src="{{ asset('js/modal.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                配送方法マスタ
            </div>
        </div>
    </x-slot>
    <div class="py-12 mx-5 grid grid-cols-12">
        <!-- 配送方法一覧 -->
        <table class="text-sm mb-5 col-span-4">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-6/12">配送方法</th>
                    <th class="p-2 px-2 w-3/12 text-right">運賃売上単価</th>
                    <th class="p-2 px-2 w-3/12 text-right">運賃経費単価</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($shipping_methods as $shipping_method)
                    <tr id="tr_{{ $shipping_method->shipping_method_id }}">
                        <td class="p-1 px-2 border">{{ $shipping_method->shipping_method_name }}</td>
                        <td class="p-1 px-2 border text-right">{{ number_format($shipping_method->fare_unit_price) }}</td>
                        <td class="p-1 px-2 border text-right">{{ number_format($shipping_method->fare_expenses) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
