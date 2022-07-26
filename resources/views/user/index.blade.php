<script src="{{ asset('js/user.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                ユーザーマスタ
            </div>
            @if(Auth::user()->role_id == 1)
                <div class="col-start-12 col-span-1">
                    <button type="button" id="user_save" class="w-full text-teal-500 border border-teal-500 font-semibold rounded hover:bg-teal-100 px-3 py-2">保存</button>
                </div>
            @endif
        </div>
    </x-slot>
    <div class="py-5 mx-5 grid grid-cols-12">
        <!-- ユーザー一覧 -->
        <table class="text-sm mb-5 col-span-10">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-2/12">所属拠点</th>
                    <th class="p-2 px-2 w-2/12">ユーザー名</th>
                    <th class="p-2 px-2 w-3/12">メールアドレス</th>
                    <th class="p-2 px-2 w-2/12 text-center">権限区分</th>
                    <th class="p-2 px-2 w-1/12 text-center">ステータス</th>
                    <th class="p-2 px-2 w-2/12">最終ログイン日時</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <form method="post" id="user_update_form" action="{{ route('user.update') }}" class="m-0">
                    @csrf
                    @foreach($users as $user)
                        <tr class="hover:bg-teal-100">
                            <td class="p-1 px-2 border">{{ $user->base->base_name }}</td>
                            <td class="p-1 px-2 border">{{ $user->name }}</td>
                            <td class="p-1 px-2 border">{{ $user->email }}</td>
                            @if(Auth::user()->role_id == 1)
                                <td class="p-1 px-2 border text-center">
                                    <select class="text-xs rounded-lg" name="role[]">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->role_id }}" {{ $role->role_id == $user->role_id ? 'selected' : '' }}>{{ $role->role_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="p-1 px-2 border text-center">
                                    <select class="text-xs rounded-lg {{ $user->status == 1 ? 'bg-sky-200' : 'bg-pink-200' }}" name="status[]">
                                        <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>有効</option>
                                        <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>無効</option>
                                    </select>
                                </td>
                                <input type="hidden" name="user_id[]" value="{{ $user->id }}">
                            @endif
                            @if(Auth::user()->role_id != 1)
                                <td class="p-1 px-2 border">{{ $user->role->role_name }}</td>
                                <td class="p-1 px-2 border text-center {{ $user->status == 1 ? 'bg-sky-200' : 'bg-pink-200' }}">{{ $user->status == 1 ? '有効' : '無効' }}</td>
                            @endif
                            <td class="p-1 px-2 border">{{ $user->status == 1 ? $user->last_login_at : '' }}</td>
                        </tr>
                    @endforeach
                </form>
            </tbody>
        </table>
    </div>
</x-app-layout>
