<script src="{{ asset('js/contact.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                <i class="las la-envelope la-lg"></i>問い合わせフォーム
            </div>
        </div>
    </x-slot>
    <form method="get" action="{{ route('contact.reception') }}" id="contact_form" class="m-0">
        <div class="grid grid-cols-12 py-5 mx-5">
            <div class="col-start-4 col-span-6 grid grid-cols-12">
                <label for="title" class="col-span-12">件名</label>
                <input type="text" id="title" class="col-span-12 rounded-lg mt-3" name="title" autocomplete="off">
                <label for="content" class="col-span-12 mt-3">問い合わせ内容</label>
                <textarea type="text" id="content" class="col-span-12 rounded-lg mt-3 h-64" name="content"></textarea>
                <button type="button" id="contact_confirm" class="col-span-12 bg-black text-white hover:bg-gray-400 rounded-lg py-5 mt-3 cursor-pointer"><i class="las la-envelope la-lg"></i></button>
            </div>
        </div>
    </form>
</x-app-layout>
