<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Admin Dashboard') | Luxenet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Luxenet Admin Dashboard" name="description">
    <meta content="Luxenet" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('tailzon/images/favicon.ico') }}">

    <!-- Icons css  (Mandatory in All Pages) -->
    <link href="{{ asset('tailzon/css/icons.min.css') }}" rel="stylesheet" type="text/css">

    <!-- App css  (Mandatory in All Pages) -->
    <link href="{{ asset('tailzon/css/app.min.css') }}" rel="stylesheet" type="text/css">
    
    <!-- Custom CSS to match the Navy/Gold theme -->
    <style>
        :root {
            --primary: #b8962a;
            --primary-rgb: 184, 150, 42;
        }
        .bg-primary { background-color: var(--primary) !important; }
        .text-primary { color: var(--primary) !important; }
        .border-primary { border-color: var(--primary) !important; }
        .hover\:bg-primary\/5:hover { background-color: rgba(184, 150, 42, 0.05) !important; }
        .hs-accordion-active\:text-primary.hs-accordion-active { color: var(--primary) !important; }
        .hs-accordion-active\:bg-primary\/5.hs-accordion-active { background-color: rgba(184, 150, 42, 0.05) !important; }
    </style>
    <!-- Tailwind Plus Elements -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>

    @stack('css')
</head>

<body>

    <div class="wrapper">

        <!-- Start Sidebar -->
        <aside id="app-menu"
            class="w-sidenav min-w-sidenav bg-white shadow-sm overflow-y-auto hs-overlay fixed inset-y-0 start-0 z-60 hidden border-e border-default-200 -translate-x-full transform transition-all duration-200 hs-overlay-open:translate-x-0 lg:bottom-0 lg:end-auto lg:z-30 lg:block lg:translate-x-0 rtl:translate-x-full rtl:hs-overlay-open:translate-x-0 rtl:lg:translate-x-0 print:hidden [--body-scroll:true] [--overlay-backdrop:true] lg:[--overlay-backdrop:false]">

            <div class="flex flex-col h-full">
                <!-- Sidenav Logo -->
                <div class="sticky top-0 flex h-topbar items-center justify-start px-6">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('images/logo-dark.png') }}" alt="logo" class="flex h-7">
                    </a>
                </div>

                <div class="p-4 h-[calc(100%-theme('spacing.topbar'))] flex-grow" data-simplebar>
                    <!-- Menu -->
                    <ul class="admin-menu hs-accordion-group flex w-full flex-col gap-1">
                        <li class="px-3 py-2 text-xs uppercase font-medium text-default-500">Main Menu</li>

                        <li class="menu-item">
                            <a href="{{ route('admin.dashboard') }}"
                                class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-primary/5 text-primary' : 'text-default-600' }} transition-all hover:bg-primary/5 hover:text-primary">
                                <i class="ti ti-home text-xl"></i>
                                <span class="menu-text"> Dashboard </span>
                            </a>
                        </li>

                        <li class="px-3 py-2 text-xs uppercase font-medium text-default-500">Management</li>

                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5 hover:text-primary"
                                href="#users">
                                <i class="ti ti-user-circle text-xl"></i>
                                Network Users
                            </a>
                        </li>

                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5 hover:text-primary"
                                href="#capacity">
                                <i class="ti ti-file-invoice text-xl"></i>
                                Capacity Requests
                            </a>
                        </li>

                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5 hover:text-primary"
                                href="{{ route('admin.meet-greet.index') }}">
                                <i class="ti ti-camera text-xl"></i>
                                Meet & Greet Mgmt
                            </a>
                        </li>

                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.partners.index') ? 'bg-primary/5 text-primary' : 'text-default-600' }} transition-all hover:bg-primary/5 hover:text-primary"
                                href="{{ route('admin.partners.index') }}">
                                <i class="ti ti-briefcase text-xl"></i>
                                Partners Mgmt
                            </a>
                        </li>

                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.works.index') ? 'bg-primary/5 text-primary' : 'text-default-600' }} transition-all hover:bg-primary/5 hover:text-primary"
                                href="{{ route('admin.works.index') }}">
                                <i class="ti ti-layers-intersect text-xl"></i>
                                Portfolio Mgmt
                            </a>
                        </li>

                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.blogs.*') ? 'bg-primary/5 text-primary' : 'text-default-600' }} transition-all hover:bg-primary/5 hover:text-primary"
                                href="{{ route('admin.blogs.index') }}">
                                <i class="ti ti-article text-xl"></i>
                                Blog Mgmt
                            </a>
                        </li>

                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.subscribers.*') ? 'bg-primary/5 text-primary' : 'text-default-600' }} transition-all hover:bg-primary/5 hover:text-primary"
                                href="{{ route('admin.subscribers.index') }}">
                                <i class="ti ti-users-group text-xl"></i>
                                Mailing List
                            </a>
                        </li>


                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.shop.index') ? 'bg-primary/5 text-primary' : 'text-default-600' }} transition-all hover:bg-primary/5 hover:text-primary"
                                href="{{ route('admin.shop.index') }}">
                                <i class="ti ti-shopping-bag text-xl"></i>
                                Shop Management
                            </a>
                        </li>

                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.shop.orders') ? 'bg-primary/5 text-primary' : 'text-default-600' }} transition-all hover:bg-primary/5 hover:text-primary"
                                href="{{ route('admin.shop.orders') }}">
                                <i class="ti ti-shopping-cart text-xl"></i>
                                Shop Orders
                            </a>
                        </li>

                        <li class="menu-item">
                            <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.invoices.index') ? 'bg-primary/5 text-primary' : 'text-default-600' }} transition-all hover:bg-primary/5 hover:text-primary"
                                href="{{ route('admin.invoices.index') }}">
                                <i class="ti ti-receipt-2 text-xl"></i>
                                Financial Mgmt
                            </a>
                        </li>

                        <li class="px-3 py-2 text-xs uppercase font-medium text-default-500">System</li>

                        <li class="menu-item">
                            <a href="{{ route('admin.settings.index') }}"
                                class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.settings.*') ? 'bg-primary/5 text-primary' : 'text-default-600' }} transition-all hover:bg-primary/5 hover:text-primary">
                                <i class="ti ti-settings text-xl"></i>
                                <span class="menu-text"> Site Settings </span>
                            </a>
                        </li>

                        <li class="menu-item">
                            <a href="{{ url('/') }}" target="_blank"
                                class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5 hover:text-primary">
                                <i class="ti ti-external-link text-xl"></i>
                                <span class="menu-text"> Visit Site </span>
                            </a>
                        </li>
                        
                        <li class="menu-item">
                            <form action="{{ route('logout') }}" method="POST" id="logout-form-sidebar">
                                @csrf
                                <a href="javascript:void(0)" onclick="document.getElementById('logout-form-sidebar').submit();"
                                    class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-red-500 transition-all hover:bg-red-50">
                                    <i class="ti ti-logout text-xl"></i>
                                    <span class="menu-text"> Logout </span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <!-- End Sidebar -->

        <!-- Start Page Content here -->
        <div class="page-content">

            <!-- Topbar Start -->
            <nav class="relative bg-gray-900/80 backdrop-blur-md sticky top-0 z-50 after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">
              <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="relative flex h-16 items-center justify-between">
                  <div class="flex items-center">
                    <!-- Sidenav Menu Toggle Button -->
                    <button
                        class="flex items-center text-gray-400 rounded-lg cursor-pointer p-2 hover:bg-white/5 hover:text-white transition-all mr-4"
                        data-hs-overlay="#app-menu" aria-label="Toggle navigation">
                        <i class="ti ti-menu-2 text-2xl"></i>
                    </button>

                    <div class="flex shrink-0 items-center">
                      <img src="{{ asset('images/logo-light.png') }}" alt="Luxenet" class="h-8 w-auto" />
                    </div>
                  </div>

                  <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                      <a href="{{ route('admin.dashboard') }}" aria-current="page" class="rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} px-3 py-2 text-sm font-medium">Dashboard</a>
                      <a href="{{ route('admin.partners.index') }}" class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.partners.index') ? 'text-white bg-white/5' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">Partners</a>
                      <a href="{{ route('admin.works.index') }}" class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.works.index') ? 'text-white bg-white/5' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">Portfolio</a>
                                              <a href="{{ route('admin.blogs.index') }}" class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.blogs.*') ? 'text-white bg-white/5' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">Blogs</a>
                                              <a href="{{ route('admin.meet-greet.index') }}" class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.meet-greet.index') ? 'text-white bg-white/5' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">Meet & Greet</a>
                                              <a href="{{ route('admin.invoices.index') }}" class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.invoices.index') ? 'text-white bg-white/5' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">Invoices</a>
                                              <a href="{{ route('admin.shop.index') }}" class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.shop.*') ? 'text-white bg-white/5' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}"><i class="ti ti-shopping-bag mr-1"></i>Shop</a>
                    </div>
                  </div>

                  <div class="flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <button type="button" data-toggle="fullscreen" class="relative rounded-full p-1 text-gray-400 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-primary">
                      <span class="sr-only">View notifications</span>
                      <i class="ti ti-maximize text-xl"></i>
                    </button>

                    <!-- Profile dropdown -->
                    <el-dropdown class="relative ml-3">
                      <button class="relative flex rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">Open user menu</span>
                        <img src="{{ asset('tailzon/images/users/avatar-8.jpg') }}" alt="" class="size-8 rounded-full bg-gray-800 outline -outline-offset-1 outline-white/10" />
                      </button>

                      <el-menu anchor="bottom end" popover class="w-48 origin-top-right rounded-md bg-gray-800 py-1 outline -outline-offset-1 outline-white/10 transition transition-discrete [--anchor-gap:--spacing(2)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in">
                        <div class="px-4 py-2 border-b border-white/5">
                            <p class="text-xs text-gray-400">Signed in as</p>
                            <p class="text-sm font-medium text-white truncate">{{ Auth::user()->first_name }}</p>
                        </div>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 focus:bg-white/5 focus:outline-hidden">Your profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 focus:bg-white/5 focus:outline-hidden">Settings</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 focus:bg-red-500/10 focus:outline-hidden">Sign out</button>
                        </form>
                      </el-menu>
                    </el-dropdown>
                  </div>
                </div>
              </div>

              <el-disclosure id="mobile-menu" hidden class="block sm:hidden">
                <div class="space-y-1 px-2 pt-2 pb-3 bg-gray-900 border-t border-white/5">
                  <a href="{{ route('admin.dashboard') }}" class="block rounded-md bg-gray-950/50 px-3 py-2 text-base font-medium text-white">Dashboard</a>
                  <a href="{{ route('admin.partners.index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Partners</a>
                  <a href="{{ route('admin.works.index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Portfolio</a>
                  <a href="{{ route('admin.blogs.index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Blogs</a>
                  <a href="{{ route('admin.subscribers.index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Mailing List</a>
                  <a href="{{ route('admin.meet-greet.index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Meet & Greet</a>
                  <a href="{{ route('admin.invoices.index') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Invoices</a>
                </div>
              </el-disclosure>
            </nav>
            <!-- Topbar End -->

            <main class="p-6">
                @yield('content')
            </main>

            <!-- Footer Start -->
            <footer class="footer h-16 flex items-center px-6 bg-white border-t border-default-200 mt-auto">
                <div class="flex md:justify-between justify-center w-full gap-4">
                    <div>
                        <p class="text-sm font-medium text-default-600">
                            <script>document.write(new Date().getFullYear())</script> © Luxenet - luxenetworks.co.ke
                        </p>
                    </div>
                    <div class="md:flex hidden gap-2 item-center md:justify-end">
                        <p class="text-sm font-medium text-default-600">Design & Develop by <a href="#" class="text-primary">Luxenet Dev Team</a></p>
                    </div>
                </div>
            </footer>
            <!-- Footer End -->

        </div>
    </div>

    <!-- Plugin Js (Mandatory in All Pages) -->
    <script src="{{ asset('tailzon/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('tailzon/libs/preline/preline.js') }}"></script>
    <script src="{{ asset('tailzon/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('tailzon/libs/iconify-icon/iconify-icon.min.js') }}"></script>
    <script src="{{ asset('tailzon/libs/node-waves/waves.min.js') }}"></script>

    <!-- App Js (Mandatory in All Pages) -->
    <script src="{{ asset('tailzon/js/app.js') }}"></script>
    
    @stack('js')

</body>

</html>
