<script src="{{ asset('js/modal.js') }}" defer></script>
<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-12 gap-4">
            <div class="inline-block col-span-2 font-semibold text-xl text-gray-800 p-2">
                ユーザーマスタ
            </div>
        </div>
    </x-slot>
    <div class="py-5 mx-5 grid grid-cols-12">
        <!-- ユーザー一覧 -->
        <table class="text-sm mb-5 col-span-7">
            <thead>
                <tr class="font-normal text-left text-white bg-gray-600 border-gray-600 sticky top-0">
                    <th class="p-2 px-2 w-2/12">所属拠点</th>
                    <th class="p-2 px-2 w-3/12">ユーザー名</th>
                    <th class="p-2 px-2 w-5/12">メールアドレス</th>
                    <th class="p-2 px-2 w-2/12">権限</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($users as $user)
                    <tr>
                        <td class="p-1 px-2 border">{{ $user->base->base_name }}</td>
                        <td class="p-1 px-2 border">{{ $user->name }}</td>
                        <td class="p-1 px-2 border">{{ $user->email }}</td>
                        <td class="p-1 px-2 border">{{ $user->role->role_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
