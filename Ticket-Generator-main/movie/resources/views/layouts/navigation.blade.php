<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="transform hover:scale-105 transition-transform duration-200">
                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-600" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-600 hover:text-indigo-600 transition-colors">
                        {{ __('My Bookings') }}
                    </x-nav-link>

                    @if(auth()->user()->is_admin)
                        
                        <div class="flex items-center">
                            <span class="h-4 w-px bg-gray-300 mx-2"></span>
                        </div>

                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-gray-600 hover:text-indigo-600">
                            {{ __('Analytics') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.movies.index')" :active="request()->routeIs('admin.movies.*')" class="text-gray-600 hover:text-indigo-600">
                            {{ __('Movies') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.cinemas.index')" :active="request()->routeIs('admin.cinemas.*')" class="text-gray-600 hover:text-indigo-600">
                            {{ __('Cinemas') }}
                        </x-nav-link>

                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-gray-600 bg-gray-50 hover:bg-indigo-50 hover:text-indigo-600 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-100 text-xs text-gray-400">
                            Manage Account
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="text-red-600 hover:bg-red-50">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100 shadow-lg">
        <div class="pt-2 pb-3 space-y-1">
            
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('My Bookings') }}
            </x-responsive-nav-link>

            @if(auth()->user()->is_admin)
                <div class="border-t border-gray-100 my-2 pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Admin Tools</p>
                    
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Analytics') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.movies.index')" :active="request()->routeIs('admin.movies.*')">
                        {{ __('Movies') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.cinemas.index')" :active="request()->routeIs('admin.cinemas.*')">
                        {{ __('Cinemas') }}
                    </x-responsive-nav-link>
                </div>
            @endif

        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 bg-gray-50">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();" class="text-red-600">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>