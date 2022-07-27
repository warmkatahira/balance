<script src="{{ asset('js/customer.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-1">
                <a href="{{ session('redirect_url') }}" class="inline-block text-center w-full bg-black text-white border font-semibold rounded hover:bg-gray-400 px-3 py-2">戻る</a>
            </div>
            <div class="col-span-6 font-semibold text-xl text-gray-800 p-2">
                荷主情報<i class="las la-caret-right"></i>{{ $customer->customer_name }}
            </div>
            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 11 && Auth::user()->base_id == $customer->control_base_id)
                <div class="col-start-12 col-span-1">
                    <button type="button" id="customer_base_info_save" class="w-full text-teal-500 border border-teal-500 font-semibold rounded hover:bg-teal-100 px-3 py-2">保存</button>
                </div>
            @endif
        </div>
    </x-slot>
    <form method="post" id="customer_base_info_form" action="{{ route('customer_base_info.update') }}" class="m-0">
        @csrf
        <div class="py-5 mx-5 grid grid-cols-12">
            <div class="col-span-6">
                <div class="col-span-12 grid grid-cols-12">
                    <p class="col-span-3 font-bold">拠点</p>
                    <p class="col-span-9">{{ $customer->base->base_name }}</p>
                    <p class="col-span-3 font-bold mt-4">荷主名</p>
                    <input type="text" id="customer_name" name="customer_name" class="col-span-5 text-sm mt-2" value="{{ $customer->customer_name }}" autocomplete="off">
                    <p class="col-start-1 col-span-3 font-bold mt-4">月間保管売上</p>
                    <input type="tel" id="monthly_storage_fee" name="monthly_storage_fee" class="col-span-2 text-sm text-right mt-2" value="{{ $customer->monthly_storage_fee }}" autocomplete="off"><span class="mt-5">円</span>
                    <p class="col-start-1 col-span-3 font-bold mt-4">月間保管経費</p>
                    <input type="tel" id="monthly_storage_expenses" name="monthly_storage_expenses" class="col-span-2 text-sm text-right mt-2" value="{{ $customer->monthly_storage_expenses }}" autocomplete="off"><span class="mt-5">円</span>
                    <p class="col-start-1 col-span-3 font-bold mt-4">稼働日数</p>
                    <input type="tel" id="working_days" name="working_days" class="col-span-2 text-sm text-right mt-2" value="{{ $customer->working_days }}" autocomplete="off"><span class="mt-5">日</span>
                    <input type="hidden" id="base_select" value="{{ $customer->control_base_id }}">
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
