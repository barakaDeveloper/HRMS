<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HRSoles') }} - @yield('title', 'Dashboard')</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
    <script>
        // Maintain user's theme preference
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="min-h-screen antialiased">
    <!-- Mobile overlay -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="sidebar w-72 panel p-6 flex flex-col gap-6 shadow-lg">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-md" style="background:linear-gradient(45deg,var(--lime),var(--g-spring)); color:var(--g-deep); display:flex;align-items:center;justify-content:center;font-weight:700">HR</div>
                <div>
                    <div class="logo-text font-semibold text-lg">HRSoles</div>
                    <div class="text-xs text-[var(--muted)]">Admin Dashboard</div>
                </div>
            </div>

            <nav class="flex-1">
                <ul class="space-y-1 text-sm">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-section="dashboard">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10h14V10" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.employees.index') }}" class="nav-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}" data-section="employees">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>Employees</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.departments.index') }}" class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}" data-section="departments">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>Departments</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.attendance.index') }}" class="nav-link {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}" data-section="attendance">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <span>Attendance</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.payroll.index') }}" class="nav-link {{ request()->routeIs('admin.payroll.*') ? 'active' : '' }}" data-section="payroll">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Payroll</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.leave.index') }}" class="nav-link {{ request()->routeIs('admin.leave.*') ? 'active' : '' }}" data-section="leave">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Leave</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{'#' }}" class="nav-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}" data-section="user">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.5 6a1.5 1.5 0 013 0v.52a5.99 5.99 0 012.03 1.18l.46-.27a1.5 1.5 0 012.05.55l.75 1.3a1.5 1.5 0 01-.55 2.05l-.46.27c.04.33.07.66.07 1s-.03.67-.07 1l.46.27a1.5 1.5 0 01.55 2.05l-.75 1.3a1.5 1.5 0 01-2.05.55l-.46-.27A6.02 6.02 0 0113.5 17.5v.5a1.5 1.5 0 01-3 0v-.5a6.02 6.02 0 01-2.03-1.18l-.46.27a1.5 1.5 0 01-2.05-.55l-.75-1.3a1.5 1.5 0 01.55-2.05l.46-.27A6.8 6.8 0 016.5 12c0-.34.03-.67.07-1l-.46-.27a1.5 1.5 0 01-.55-2.05l.75-1.3a1.5 1.5 0 012.05-.55l.46.27A6.02 6.02 0 0110.5 6v-.52z" />
                            <circle cx="12" cy="12" r="2.5" stroke-width="2"></circle>
                        </svg>

                            <span>Manage User</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="mt-auto text-xs text-[var(--muted)]">
                <div>© 2025 HRSoles</div>
            </div>
        </aside>

        <!-- Main -->
        <div class="flex-1 overflow-auto">
            <!-- Topbar with Laravel Auth -->
            <header x-data="{ open: false }" class="panel mb-6 sticky top-0 z-30">
                <div class="flex items-center justify-between p-4 lg:p-6">
                    <!-- Mobile menu button -->
                    <button @click="open = !open" class="lg:hidden p-2 -ml-2" aria-label="Toggle menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="flex items-center gap-4 flex-1 max-w-2xl">
                        <div class="text-sm text-[var(--muted)] hidden md:block" id="page-title">@yield('page-title', 'Dashboard')</div>
                        <div class="relative flex-1 hidden md:block">
                            <input type="search" placeholder="Search here..." class="chip pl-10 pr-3 py-2 rounded-full text-sm w-full" />
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 ml-4">
                        <!-- Theme Toggle - Visible on all devices -->
                        <button id="toggleTheme" class="chip flex items-center gap-2" aria-label="Toggle theme">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            <span class="hidden xl:inline">Theme</span>
                        </button>

                        <!-- Profile Dropdown with Alpine.js -->
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'User' }}&background=316C40&color=fff" alt="avatar" class="w-9 h-9 rounded-full border-2 border-[var(--border-color)]" />
                                <div class="text-sm hidden lg:block text-left">
                                    <div class="font-medium logo-text">{{ Auth::user()->name ?? 'User' }}</div>
                                    <div class="text-[var(--muted)] text-xs">Online</div>
                                </div>
                                <svg class="w-4 h-4 text-[var(--muted)] hidden lg:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="dropdown-content"
                                 style="display: none;"
                                 @click="open = false">
                                <a href="#" class="dropdown-link">
                                    Profile
                                </a>
                                <div class="border-t border-[var(--border-color)]"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-link w-full text-left">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Responsive Menu -->
                <div :class="{'block': open, 'hidden': !open}" class="hidden lg:hidden border-t border-[var(--border-color)]">
                    <!-- Mobile Search -->
                    <div class="px-4 pt-4 pb-3">
                        <div class="relative">
                            <input type="search" placeholder="Search here..." class="chip pl-10 pr-3 py-2 rounded-full text-sm w-full" />
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-[var(--muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Mobile Navigation Links -->
                    <div class="px-4 pb-3 space-y-1">
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}" 
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-section="dashboard">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10h14V10"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <!-- Employees -->
                        <a href="{{ route('admin.employees.index') }}"  
                        class="nav-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}" data-section="employees">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span>Employees</span>
                        </a>

                        <!-- Departments -->
                        <a href="{{ route('admin.departments.index') }}" 
                        class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}" data-section="departments">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span>Departments</span>
                        </a>

                        <!-- Attendance -->
                        <a href="{{ route('admin.attendance.index') }}" 
                        class="nav-link {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}" data-section="attendance">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            <span>Attendance</span>
                        </a>

                        <!-- Payroll -->
                        <a href="{{ route('admin.payroll.index') }}" 
                        class="nav-link {{ request()->routeIs('admin.payroll.*') ? 'active' : '' }}" data-section="payroll">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Payroll</span>
                        </a>

                        <!-- Leave -->
                        <a href="{{ route('admin.leave.index') }}" 
                        class="nav-link {{ request()->routeIs('admin.leave.*') ? 'active' : '' }}" data-section="leave">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Leave</span>
                        </a>
                        <!-- manage Users -->
                        <a href="{{ '#' }}" 
                        class="nav-link {{ request()->routeIs('admin.leave.*') ? 'active' : '' }}" data-section="leave">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.5 6a1.5 1.5 0 013 0v.52a5.99 5.99 0 012.03 1.18l.46-.27a1.5 1.5 0 012.05.55l.75 1.3a1.5 1.5 0 01-.55 2.05l-.46.27c.04.33.07.66.07 1s-.03.67-.07 1l.46.27a1.5 1.5 0 01.55 2.05l-.75 1.3a1.5 1.5 0 01-2.05.55l-.46-.27A6.02 6.02 0 0113.5 17.5v.5a1.5 1.5 0 01-3 0v-.5a6.02 6.02 0 01-2.03-1.18l-.46.27a1.5 1.5 0 01-2.05-.55l-.75-1.3a1.5 1.5 0 01.55-2.05l.46-.27A6.8 6.8 0 016.5 12c0-.34.03-.67.07-1l-.46-.27a1.5 1.5 0 01-.55-2.05l.75-1.3a1.5 1.5 0 012.05-.55l.46.27A6.02 6.02 0 0110.5 6v-.52z" />
                                <circle cx="12" cy="12" r="2.5" stroke-width="2"></circle>
                            </svg>

                            <span>Manage Users</span>
                        </a>
                    </div>

                    <!-- Mobile User Info -->
                    <div class="pt-4 pb-3 border-t border-[var(--border-color)]">
                        <div class="px-4">
                            <div class="font-medium text-base logo-text">{{ Auth::user()->name ?? 'User' }}</div>
                            <div class="font-medium text-sm text-[var(--muted)]">{{ Auth::user()->email ?? 'user@example.com' }}</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main content area -->
            <div class="px-4 lg:px-6 pb-6">
                @yield('content')
            </div>
        </div>
    </div>

<!-- JavaScript Files -->
<script src="{{ asset('js/theme.js') }}"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>
<script src="{{ asset('js/navigation.js') }}"></script>

@stack('scripts')
</body>
</html>