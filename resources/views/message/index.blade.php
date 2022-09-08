<script src="{{ asset('js/message.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                <i class="las la-sms la-lg"></i>メッセージ
            </div>
            @if(Auth::user()->role_id == 1)
                <div class="col-start-11 col-span-2">
                    <button id="message_templete_register_modal_open" class="w-full text-indigo-500 border border-indigo-500 font-semibold rounded hover:bg-indigo-100 px-3 py-2">テンプレート登録</button>
                </div>
            @endif
        </div>
    </x-slot>
    <form method="get" action="{{ route('message.send') }}" id="message_form" class="m-0">
        <div class="grid grid-cols-12 py-5 mx-5">
            <div class="col-start-4 col-span-6 grid grid-cols-12">
                <label for="templete" class="col-span-12">テンプレート選択</label>
                <select id="templete" class="col-span-12 text-sm rounded-lg">
                    <option value="0">テンプレートを選択</option>
                    @foreach($message_templetes as $message_templete)
                        <option value="{{ $message_templete->message_templete_id }}">{{ $message_templete->templete_name }}</option>
                    @endforeach
                </select>
                <label for="to" class="col-span-12 mt-3">宛先</label>
                <select id="to" name="to" class="col-span-12 text-sm rounded-lg">
                    <option value="all">全員</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name.'《'.$user->email.'》' }}</option>
                    @endforeach
                </select>
                <label for="title" class="col-span-12 mt-3">件名</label>
                <input type="text" id="title" class="col-span-12 rounded-lg" name="title" autocomplete="off">
                <label for="content" class="col-span-12 mt-3">メッセージ内容</label>
                <textarea type="text" id="content" class="col-span-12 rounded-lg h-64" name="content"></textarea>
                <button type="button" id="message_confirm" class="col-span-12 bg-black text-white hover:bg-gray-400 rounded-lg py-5 mt-3 cursor-pointer"><i class="las la-sms la-lg"></i></button>
            </div>
        </div>
    </form>
    <!-- テンプレート登録モーダル -->
    <div id="message_templete_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-20 mx-auto shadow-lg rounded-md bg-white max-w-3xl">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4>メッセージテンプレート登録画面</h4>
                <button class="message_templete_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                <form method="post" id="message_templete_register_form" action="{{ route('message_templete.register') }}" class="m-0">
                    @csrf
                    <label for="register_name" class="w-full">テンプレート名</label>
                    <input type="text" id="register_name" class="w-full rounded-lg" name="register_name" autocomplete="off">
                    <label for="register_title" class="w-full">件名</label>
                    <input type="text" id="register_title" class="w-full rounded-lg" name="register_title" autocomplete="off">
                    <label for="register_content" class="w-full">メッセージ内容</label>
                    <textarea type="text" id="register_content" class="w-full rounded-lg h-64" name="register_content"></textarea>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <a id="message_templete_register" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">登録</a>
                <a class="message_templete_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
