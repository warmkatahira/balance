<link rel="stylesheet" href="{{ asset('css/question.css') }}">
<script src="{{ asset('js/question.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                <i class="las la-question-circle la-lg"></i>よくある質問
            </div>
            @if(Auth::user()->role_id == 1)
                <div class="col-start-12 col-span-1">
                    <button type="button" id="question_register_modal_open" class="w-full text-indigo-500 border border-indigo-500 font-semibold rounded hover:bg-indigo-100 px-3 py-2">投稿</button>
                </div>
            @endif
        </div>
    </x-slot>
    <div class="grid grid-cols-12 gap-4 py-5 mx-5">
        @foreach($questions as $question)
            <details id="{{ $question->question_id }}" class="question_detail col-span-12 mb-8 rounded-lg shadow-lg">
                <summary class="bg-black text-white p-2 text-xl cursor-pointer rounded-t-lg"><i id="{{ 'summary_'.$question->question_id }}" class="las la-plus-circle la-lg mr-5"></i>{{ $question->question_title }}
                    @if(Auth::user()->role_id == 1)
                        <a href="{{ route('question.delete', ['question_id' => $question->question_id]) }}" class="question_delete bg-red-400 text-white text-xs p-1 hover:bg-gray-400 ml-10">削除</a>
                    @endif
                </summary>
                <div class="px-3 py-10 text-sm bg-teal-100">
                    <p>{!! nl2br(e($question->answer_content)) !!}</p>
                </div>
            </details>
        @endforeach
    </div>
    <!-- よくある質問投稿モーダル -->
    <div id="question_register_modal" class="fixed hidden z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full px-4">
        <div class="relative top-40 mx-auto shadow-lg rounded-md bg-white max-w-4xl">
            <!-- Modal header -->
            <div class="flex justify-between items-center bg-gray-400 text-white text-xl rounded-t-md px-4 py-2">
                <h4>よくある質問投稿画面</h4>
                <button class="question_register_modal_close"><i class="las la-window-close"></i></button>
            </div>
            <!-- Modal body -->
            <div class="p-10">
                <form method="post" id="question_register_form" action="{{ route('question.register') }}" class="m-0">
                    @csrf
                    <input type="text" id="question_title" name="question_title" class="w-full mt-5" placeholder="タイトル（100文字以内）" autocomplete="off" required>
                    <textarea id="answer_content" name="answer_content" class="w-full mt-5 h-60" placeholder="回答（500文字以内）" autocomplete="off" required></textarea>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="px-4 py-2 border-t border-t-gray-500 grid grid-cols-2 gap-4">
                <a id="question_register" class="cursor-pointer rounded-lg bg-teal-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">投稿</a>
                <a class="question_register_modal_close cursor-pointer rounded-lg bg-pink-200 text-center p-4 transition duration-300 ease-in-out hover:bg-gray-400 hover:text-white">
                    閉じる
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
