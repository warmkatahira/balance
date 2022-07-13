<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="mx-5">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>
                <!-- Navigation Links -->
                <ul class="p-3 ml-20 z-50">
                    <li class="nav-menu relative inline-block">
                        <div class="w-40 font-bold bg-sky-200 text-center py-2 cursor-pointer">収支</div>
                        <ul class="nav-list absolute hidden">
                            <li>
                                <a href="{{ route('balance_register.index') }}" class="block w-40 bg-gray-100 hover:bg-gray-400 text-center py-2 hover:text-white">収支登録</a>
                            </li>
                            <li>
                                <a href="{{ route('balance_list_daily.index') }}" class="block w-40 bg-gray-100 hover:bg-gray-400 text-center py-2 hover:text-white">収支一覧（日別）</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-menu relative inline-block">
                        <div class="w-40 font-bold bg-sky-200 text-center py-2 cursor-pointer">マスタ</div>
                        <ul class="nav-list absolute hidden">
                            <li>
                                <a href="{{ route('base.index') }}" class="block w-40 bg-gray-100 hover:bg-gray-400 text-center py-2 hover:text-white">拠点マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('customer.index') }}" class="block w-40 bg-gray-100 hover:bg-gray-400 text-center py-2 hover:text-white">荷主マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('cargo_handling.index') }}" class="block w-40 bg-gray-100 hover:bg-gray-400 text-center py-2 hover:text-white">荷役マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('expense.index') }}" class="block w-40 bg-gray-100 hover:bg-gray-400 text-center py-2 hover:text-white">経費マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('shipping_method.index') }}" class="block w-40 bg-gray-100 hover:bg-gray-400 text-center py-2 hover:text-white">配送方法マスタ</a>
                            </li>
                            <li>
                                <a href="{{ route('labor_cost.index') }}" class="block w-40 bg-gray-100 hover:bg-gray-400 text-center py-2 hover:text-white">人件費マスタ</a>
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
                            <div>{{ Auth::user()->name }}</div>

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
