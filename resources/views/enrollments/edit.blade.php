<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Enrollment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('enrollments.update', $enrollment->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <!-- Student Selection -->
                        <div class="mb-4">
                            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Student *
                            </label>
                            <select name="student_id" id="student_id" required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" 
                                        {{ $enrollment->student_id == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('student_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Course Selection -->
                        <div class="mb-4">
                            <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Course *
                            </label>
                            <select name="course_id" id="course_id" required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" 
                                        {{ $enrollment->course_id == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Enrollment Date -->
                        <div class="mb-4">
                            <label for="enrollment_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Enrollment Date *
                            </label>
                            <input type="date" name="enrollment_date" id="enrollment_date" 
                                value="{{ $enrollment->enrollment_date->format('Y-m-d') }}" required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                            @error('enrollment_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status *
                            </label>
                            <select name="status" id="status" required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                <option value="active" {{ $enrollment->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ $enrollment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="dropped" {{ $enrollment->status == 'dropped' ? 'selected' : '' }}>Dropped</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('enrollments.index') }}" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Enrollment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
