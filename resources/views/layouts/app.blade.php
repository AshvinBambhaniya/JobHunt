<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Hunt Tracker</title>
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter var', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    @auth
        <div>
            <!-- Top bar -->
            <nav class="bg-white shadow-md">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex items-center">
                            <a href="{{ route('job-applications.index') }}" class="text-2xl font-bold text-indigo-600">
                                JobHunt
                            </a>
                            <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                                <a href="{{ route('job-applications.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-500 text-sm font-medium text-gray-900">
                                    Dashboard
                                </a>
                                <a href="{{ route('job-applications.create') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                                    Add New Job
                                </a>
                            </div>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:items-center">
                            <span class="text-gray-700 mr-4 font-medium">Hi, {{ Auth::user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-red-600 text-sm font-medium">Logout</button>
                            </form>
                        </div>
                        <div class="-mr-2 flex items-center sm:hidden">
                            <!-- Mobile menu button -->
                            <button type="button" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" aria-controls="mobile-menu" aria-expanded="false">
                                <span class="sr-only">Open main menu</span>
                                <!-- Icon when menu is closed. -->
                                <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <!-- Icon when menu is open. -->
                                <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu, show/hide based on menu state. -->
                <div class="sm:hidden" id="mobile-menu">
                    <div class="pt-2 pb-3 space-y-1">
                        <a href="{{ route('job-applications.index') }}" class="block pl-3 pr-4 py-2 border-l-4 border-indigo-500 text-base font-medium text-indigo-700 bg-indigo-50">Dashboard</a>
                        <a href="{{ route('job-applications.create') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700">Add New Job</a>
                    </div>
                    <div class="pt-4 pb-3 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div class="ml-3">
                                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main content -->
            <main class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
    @else
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
            <div class="container mx-auto">
                @yield('content')
            </div>
        </main>
    @endauth
    <script>
        const btn = document.querySelector('button[aria-controls="mobile-menu"]');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            const isExpanded = btn.getAttribute('aria-expanded') === 'true';
            btn.setAttribute('aria-expanded', !isExpanded);
            menu.classList.toggle('hidden');
            const icons = btn.querySelectorAll('svg');
            icons.forEach(icon => icon.classList.toggle('hidden'));
        });
    </script>
</body>
</html>