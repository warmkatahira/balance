<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="mx-5">
        <div class="grid grid-cols-12 pt-1">
            <!-- Logo -->
            <div class="col-span-2">
                <a href="{{ route('home.index') }}">
                    <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                </a>
            </div>
            <!-- Navigation Links -->
            <a href="{{ route('home.index') }}" class="col-span-1 pt-2"><i class="las la-home la-2x"></i></a>
            <!-- Newsのティッカー -->
            <div class="col-span-6 grid grid-cols-12">
                <div class="col-span-2 text-right ticker-head my-3 italic text-blue-500">NEWS</div>
                <div class="col-span-8 ticker my-3 bg-blue-500 rounded-lg">
                    <ul class="text-sm py-1 text-white">
                        <li class='ticker-item'><a href="#"><span class="ticker-date"></span><span class="mx-3">問い合わせは、「その他」→「問い合わせ」よりお願いします。</span></a></li>
                        <li class='ticker-item'><a href="#"><span class="ticker-date"></span><span class="mx-3">「よくある質問」も随時更新していますのでご活用下さい。</span></a></li>
                    </ul>
                </div>
            </div>
            <!-- Settings Dropdown -->
            <div class="col-start-12 col-span-1 pt-5">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-xs font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>
                                <p>{{ Auth::user()->base->base_name }}</p>
                                <p>{{ Auth::user()->name }}</p>
                            </div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
        <div class="pt-2 flex justify-between h-16">
            <div class="flex">
                <ul class="z-50" style="font-family:Zen Maru Gothic">
                    <li class="nav-menu relative inline-block">
                        <div class="w-32 font-bold bg-orange-200 text-center py-2 cursor-pointer">収支</div>
                        <ul class="nav-list absolute hidden">
                            <li>
                                <a href="{{ route('balance_register.index') }}" class="block w-32 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-xs">収支登録</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-menu relative inline-block">
                        <div class="w-32 font-bold bg-orange-200 text-center py-2 cursor-pointer">収支一覧</div>
                        <ul class="nav-list absolute hidden">
                            <li>
                                <a href="{{ route('balance_list.index') }}" class="block w-32 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-xs">収支一覧</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-menu relative inline-block">
                        <div class="w-32 font-bold bg-orange-200 text-center py-2 cursor-pointer">マスタ</div>
                        <ul class="nav-list absolute hidden">
                            <li>
                                <a href="{{ route('base.index') }}" class="block w-32 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-xs">拠点マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('customer.index') }}" class="block w-32 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-xs">荷主マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('cargo_handling.index') }}" class="block w-32 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-xs">荷役マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('expenses_item.index') }}" class="block w-32 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-xs">経費項目マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('sales_item.index') }}" class="block w-32 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-xs">売上項目マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('shipping_method.index') }}" class="block w-32 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-xs">配送方法マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('user.index') }}" class="block w-32 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-xs">ユーザーマスタ</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-menu relative inline-block">
                        <div class="w-32 font-bold bg-orange-200 text-center py-2 cursor-pointer">その他</div>
                        <ul class="nav-list absolute hidden">
                            <li>
                                <a href="{{ route('question.index') }}" class="block w-32 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-xs">よくある質問</a>
                            </li>
                            <li>
                                <a href="{{ route('contact.index') }}" class="block w-32 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-xs">問い合わせ</a>
                            </li>
                            @if(Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{ route('message.index') }}" class="block w-32 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-xs">メッセージ</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
