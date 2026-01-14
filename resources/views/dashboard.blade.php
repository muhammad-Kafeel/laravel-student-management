<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Error Message -->
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold mb-2">Welcome, {{ Auth::user()->name }}!</h3>
                            <p class="text-gray-600">You're logged in successfully.</p>
                        </div>
                        <div>
                            @if(Auth::user()->isAdmin())
                                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full font-semibold">Admin</span>
                            @elseif(Auth::user()->isTeacher())
                                <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full font-semibold">Teacher</span>
                            @else
                                <span class="px-4 py-2 bg-gray-100 text-gray-800 rounded-full font-semibold">Student</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Students Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Students</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $studentCount }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ url('/students') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View all students →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Teachers Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Teachers</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $teacherCount }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ url('/teachers') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                View all teachers →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Courses Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
                                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Courses</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $courseCount }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ url('/courses') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                View all courses →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Enrollments Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-orange-100 rounded-full p-3">
                                <svg class="h-8 w-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Enrollments</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $enrollmentCount }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ url('/enrollments') }}" class="text-orange-600 hover:text-orange-800 text-sm font-medium">
                                View all enrollments →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
