<script src="{{ asset('js/labor_cost_setting.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-1">
                <a href="{{ session('redirect_url') }}" class="inline-block text-center w-full bg-black text-white border font-semibold rounded hover:bg-gray-400 px-3 py-2">戻る</a>
            </div>
            <div class="col-span-6 font-semibold text-xl text-gray-800 p-2">
                人件費設定<i class="las la-caret-right"></i>{{ $base->base_name }}
            </div>
            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11 && Auth::user()->base_id == session('base_id'))
                <div class="col-start-12 col-span-1">
                    <button type="button" id="labor_cost_setting_save" class="w-full text-teal-500 border border-teal-500 font-semibold rounded hover:bg-teal-100 px-3 py-2">保存</button>
                </div>
            @endif
        </div>
    </x-slot>
    <div class="py-12 mx-5 grid grid-cols-12">
        <!-- 人件費一覧 -->
        <table class="text-sm mb-5 col-span-2">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-4/12">人件費名</th>
                    <th class="p-2 px-2 w-8/12 text-right">時給</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <form method="post" id="labor_cost_setting_form" action="{{ route('labor_cost_setting.update') }}" class="m-0">
                    @csrf
                    @foreach($labor_costs as $labor_cost)
                        <tr id="tr_{{ $labor_cost->labor_cost_id }}">
                            <td class="p-1 px-2 border">{{ $labor_cost->labor_cost_name }}</td>
                            <td class="p-1 px-2 border text-right"><input type="tel" name="hourly_wage[]" class="hourly_wage text-sm text-right bg-gray-100 w-3/4" value="{{ $labor_cost->hourly_wage }}" autocomplete="off">円</td>
                        </tr>
                        <input type="hidden" name="labor_cost_id[]" value="{{ $labor_cost->labor_cost_id }}">
                    @endforeach
                </form>
            </tbody>
        </table>
    </div>
</x-app-layout>
