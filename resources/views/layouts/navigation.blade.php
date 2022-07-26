<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="mx-5">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home.index') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>
                <!-- Navigation Links -->
                <a href="{{ route('home.index') }}" class="ml-5 p-4 w-20 text-center"><i class="las la-home la-2x"></i></a>
                <ul class="p-3 z-50" style="font-family:Zen Maru Gothic">
                    <li class="nav-menu relative inline-block">
                        <div class="w-40 font-bold bg-orange-200 text-center py-2 cursor-pointer">収支</div>
                        <ul class="nav-list absolute hidden">
                            <li>
                                <a href="{{ route('balance_register.index') }}" class="block w-40 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-sm">収支登録</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-menu relative inline-block">
                        <div class="w-40 font-bold bg-orange-200 text-center py-2 cursor-pointer">収支一覧</div>
                        <ul class="nav-list absolute hidden">
                            <li>
                                <a href="{{ route('balance_list.index') }}" class="block w-40 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-sm">収支一覧</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-menu relative inline-block">
                        <div class="w-40 font-bold bg-orange-200 text-center py-2 cursor-pointer">マスタ</div>
                        <ul class="nav-list absolute hidden">
                            <li>
                                <a href="{{ route('base.index') }}" class="block w-40 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-sm">拠点マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('customer.index') }}" class="block w-40 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-sm">荷主マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('cargo_handling.index') }}" class="block w-40 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-sm">荷役マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('expenses_item.index') }}" class="block w-40 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-sm">経費項目マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('sales_item.index') }}" class="block w-40 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-sm">売上項目マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('shipping_method.index') }}" class="block w-40 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-sm">配送方法マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('user.index') }}" class="block w-40 bg-orange-300 hover:bg-gray-400 py-2 hover:text-white text-sm">ユーザーマスタ</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->base->base_name .' / '. Auth::user()->name }}</div>

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
    </div>
</nav>
