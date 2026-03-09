@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-2xl w-full text-center">
        <!-- Maintenance Icon -->
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-32 h-32 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full">
                <i class="fas fa-tools text-6xl text-blue-600"></i>
            </div>
        </div>

        <!-- Maintenance Message -->
        <h1 class="text-6xl font-bold text-gray-800 mb-4">503</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Service Unavailable</h2>
        <p class="text-gray-600 mb-8">
            We're currently performing scheduled maintenance to improve your experience. 
            We'll be back shortly!
        </p>

        <!-- Estimated Time -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8 max-w-md mx-auto">
            <i class="fas fa-clock text-blue-600 text-2xl mb-3"></i>
            <p class="text-blue-800 font-semibold">Estimated Downtime</p>
            <p class="text-blue-600 text-sm mt-2">We expect to be back online within 15-30 minutes</p>
        </div>

        <!-- What You Can Do -->
        <div class="text-left max-w-md mx-auto mb-8">
            <h3 class="font-semibold text-gray-800 mb-4">What you can do:</h3>
            <ul class="space-y-2 text-gray-600">
                <li class="flex items-start gap-2">
                    <i class="fas fa-check-circle text-green-600 mt-1"></i>
                    <span>Refresh this page in a few minutes</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="fas fa-check-circle text-green-600 mt-1"></i>
                    <span>Follow us on social media for updates</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="fas fa-check-circle text-green-600 mt-1"></i>
                    <span>Check back later for the latest job notifications</span>
                </li>
            </ul>
        </div>

        <!-- Refresh Button -->
        <button onclick="window.location.reload()" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
            <i class="fas fa-sync-alt"></i> Refresh Page
        </button>

        <!-- Contact Info -->
        <div class="mt-8 text-sm text-gray-500">
            For urgent queries, email us at 
            <a href="mailto:jobone2026@gmail.com" class="text-blue-600 hover:text-blue-700">jobone2026@gmail.com</a>
        </div>
    </div>
</div>
@endsection
