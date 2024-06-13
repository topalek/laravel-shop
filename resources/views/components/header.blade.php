<header class="header pt-6 xl:pt-12">
    <div class="container">
        <div class="header-inner flex items-center justify-between lg:justify-start">
            <div class="header-logo shrink-0">
                <a href="{{route('home')}}" rel="home">
                    <img alt="CutCode"
                         class="w-[120px] xs:w-[148px] md:w-[201px] h-[30px] xs:h-[36px] md:h-[50px]"
                         src="{{asset('/images/logo.svg')}}">
                </a>
            </div>
            <div class="header-menu grow hidden lg:flex items-center ml-8 mr-8 gap-8">
                <form class="hidden lg:flex gap-3" action="{{route('shop')}}">
                    <input
                        name="s"
                        value="{{request('s')}}"
                        class="w-full h-12 px-4 rounded-lg border border-body/10 focus:border-pink focus:shadow-[0_0_0_3px_#EC4176] bg-white/5 text-white text-xs shadow-transparent outline-0 transition"
                        placeholder="Поиск..."
                        type="search">
                    <button class="shrink-0 w-12 !h-12 !px-0 btn btn-pink" type="submit">
                        <x-icons.search class="w-4 h-4"/>
                    </button>
                </form>
                <x-menu/>
            </div>
            <div class="header-actions flex items-center gap-3 md:gap-5">
                @guest
                    <a href="{{route('login.page')}}" class="profile hidden xs:flex items-center">
                        <x-icons.profile/>
                        <span class="profile-text relative ml-2 text-white text-xxs md:text-xs font-bold">Войти</span>
                    </a>
                @endguest
                @auth
                    <div class="profile relative" x-data="{dropdownProfile: false}">
                        <button @click="dropdownProfile = ! dropdownProfile"
                                class="flex items-center text-white hover:text-pink transition">
                            <span class="sr-only">Профиль</span>
                            <img alt="{{auth()->user()->name}}" class="shrink-0 w-7 md:w-9 h-7 md:h-9 rounded-full" src="{{auth()->user()->avatar}}">
                            <span class="hidden md:block ml-2 font-medium">{{auth()->user()->name ?? 'Guest'}}</span>
                            <x-icons.chevron-down class="shrink-0 w-3 h-3 ml-2"/>
                        </button>
                        <div
                            @click.away="dropdownProfile = false"
                            class="absolute z-50 top-0 -right-20 xs:-right-8 sm:right-0 w-[280px] sm:w-[300px] mt-14 p-4 rounded-lg shadow-xl bg-card"
                            x-show="dropdownProfile"
                            x-transition:enter="ease-out duration-300"
                            x-transition:enter-end="opacity-100"
                            x-transition:enter-start="opacity-0"
                            x-transition:leave="ease-in duration-150"
                            x-transition:leave-end="opacity-0"
                            x-transition:leave-start="opacity-100"
                        >
                            <h5 class="text-body text-xs">Мой профиль</h5>
                            <div class="flex items-center mt-3">
                                <img alt="{{auth()->user()->name}}" class="w-11 h-11 rounded-full"
                                     src="{{auth()->user()->avatar}}">
                                <span
                                    class="ml-3 text-xs md:text-sm font-bold">{{auth()->user()->name ?? 'Guest'}}</span>
                            </div>
                            <div class="mt-4">
                                <ul class="space-y-2">
                                    <li><a class="text-body hover:text-white text-xs font-medium" href="orders.html">Мои
                                            заказы</a></li>
                                    <li><a class="text-body hover:text-white text-xs font-medium"
                                           href="edit-profile.html">Редактировать
                                            профиль</a></li>
                                </ul>
                            </div>
                            <div class="mt-6">
                                <form action="{{route('logout')}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="inline-flex items-center text-body hover:text-pink">
                                        <x-icons.logout class="shrink-0 w-5 h-5"/>
                                        <span class="ml-2 font-medium">Выйти</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
                <a class="flex items-center gap-3 text-pink hover:text-white" href="{{route('cart')}}">
                    <x-icons.bag class="w-6 md:w-7 h-6 md:h-7"/>
                    <div class="hidden sm:flex flex-col gap-2">
                        <span class="text-body text-xxs leading-none">3 шт.</span>
                        <span class="text-white text-xxs 2xl:text-xs font-bold !leading-none">57 900 ₽</span>
                    </div>
                </a>
                <button class="flex 2xl:hidden text-white hover:text-pink transition" id="burgerMenu">
                    <span class="sr-only">Меню</span>
                    <x-icons.menu class="w-8 h-8"/>
                </button>
            </div>
        </div>
    </div>
</header>
