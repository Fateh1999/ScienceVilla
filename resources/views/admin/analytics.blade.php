@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Analytics</h1>
    <p class="text-gray-600">Platform insights and statistics</p>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- User Registrations Chart -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">User Registrations (Last 30 Days)</h2>
        <div class="h-64 flex items-center justify-center">
            @if($data['user_registrations']->count() > 0)
                <div class="w-full">
                    <canvas id="userRegistrationsChart" width="400" height="200"></canvas>
                </div>
            @else
                <p class="text-gray-500">No registration data available</p>
            @endif
        </div>
    </div>

    <!-- Course Enrollments Chart -->
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Course Enrollments (Last 30 Days)</h2>
        <div class="h-64 flex items-center justify-center">
            @if($data['course_enrollments']->count() > 0)
                <div class="w-full">
                    <canvas id="enrollmentsChart" width="400" height="200"></canvas>
                </div>
            @else
                <p class="text-gray-500">No enrollment data available</p>
            @endif
        </div>
    </div>
</div>

<!-- Tables Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Popular Courses -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Popular Courses</h2>
        </div>
        <div class="p-6">
            @if($data['popular_courses']->count() > 0)
                <div class="space-y-4">
                    @foreach($data['popular_courses'] as $course)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $course->title }}</p>
                                <p class="text-sm text-gray-600">{{ ucfirst($course->level) }} • ${{ number_format($course->price, 2) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-blue-600">{{ $course->enrollments_count }}</p>
                                <p class="text-sm text-gray-500">enrollments</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No course data available</p>
            @endif
        </div>
    </div>

    <!-- Completion Rates -->
    <div class="bg-white rounded-lg shadow-sm border">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Course Completion Rates</h2>
        </div>
        <div class="p-6">
            @if($data['completion_rates']->count() > 0)
                <div class="space-y-4">
                    @foreach($data['completion_rates'] as $item)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $item['course'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold {{ $item['completion_rate'] >= 70 ? 'text-green-600' : ($item['completion_rate'] >= 40 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $item['completion_rate'] }}%
                                </p>
                                <div class="w-20 bg-gray-200 rounded-full h-2 mt-1">
                                    <div class="h-2 rounded-full {{ $item['completion_rate'] >= 70 ? 'bg-green-600' : ($item['completion_rate'] >= 40 ? 'bg-yellow-600' : 'bg-red-600') }}" 
                                         style="width: {{ $item['completion_rate'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No completion data available</p>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // User Registrations Chart
    @if($data['user_registrations']->count() > 0)
    const userRegCtx = document.getElementById('userRegistrationsChart').getContext('2d');
    new Chart(userRegCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($data['user_registrations']->pluck('date')) !!},
            datasets: [{
                label: 'New Users',
                data: {!! json_encode($data['user_registrations']->pluck('count')) !!},
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    @endif

    // Course Enrollments Chart
    @if($data['course_enrollments']->count() > 0)
    const enrollmentsCtx = document.getElementById('enrollmentsChart').getContext('2d');
    new Chart(enrollmentsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($data['course_enrollments']->pluck('date')) !!},
            datasets: [{
                label: 'Enrollments',
                data: {!! json_encode($data['course_enrollments']->pluck('count')) !!},
                backgroundColor: 'rgba(34, 197, 94, 0.8)',
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    @endif
});
</script>
@endpush
@endsection
