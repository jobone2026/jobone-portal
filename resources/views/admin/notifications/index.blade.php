@extends('admin.layouts.app')

@section('title', 'Send Notification')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📢 Send Notification</h1>
        <p class="text-gray-600 text-sm mt-1">Send custom notifications to your users via Telegram, Android App, or WhatsApp</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Notification Status -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Telegram Status -->
        <div class="bg-white rounded-lg shadow p-4 border-l-4 {{ $telegramConfigured ? 'border-green-500' : 'border-gray-300' }}">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-700">📱 Telegram</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        @if($telegramConfigured)
                            <span class="text-green-600">✅ Configured</span>
                        @else
                            <span class="text-gray-400">❌ Not configured</span>
                        @endif
                    </p>
                </div>
                <div class="text-3xl">
                    @if($telegramConfigured)
                        <span class="text-green-500">✓</span>
                    @else
                        <span class="text-gray-300">○</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Firebase Status -->
        <div class="bg-white rounded-lg shadow p-4 border-l-4 {{ $firebaseConfigured ? 'border-green-500' : 'border-gray-300' }}">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-700">📱 Android Push</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        @if($firebaseConfigured)
                            <span class="text-green-600">✅ Configured</span>
                        @else
                            <span class="text-gray-400">❌ Not configured</span>
                        @endif
                    </p>
                </div>
                <div class="text-3xl">
                    @if($firebaseConfigured)
                        <span class="text-green-500">✓</span>
                    @else
                        <span class="text-gray-300">○</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- WhatsApp Status -->
        <div class="bg-white rounded-lg shadow p-4 border-l-4 {{ $whatsappConfigured ? 'border-green-500' : 'border-gray-300' }}">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-700">💬 WhatsApp</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        @if($whatsappConfigured)
                            <span class="text-green-600">✅ Configured</span>
                        @else
                            <span class="text-gray-400">⚠️ Optional</span>
                        @endif
                    </p>
                </div>
                <div class="text-3xl">
                    @if($whatsappConfigured)
                        <span class="text-green-500">✓</span>
                    @else
                        <span class="text-gray-300">○</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Send Notification Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.notifications.send') }}" method="POST">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Notification Title <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="title" 
                    value="{{ old('title') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="e.g., New Job Alert!"
                    maxlength="100"
                    required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Message -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Message <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="message" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="Enter your notification message..."
                    maxlength="500"
                    required>{{ old('message') }}</textarea>
                <p class="text-gray-500 text-xs mt-1">Maximum 500 characters</p>
                @error('message')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- URL (Optional) -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">
                    Link URL (Optional)
                </label>
                <input 
                    type="url" 
                    name="url" 
                    value="{{ old('url') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="https://jobone.in/job/example">
                <p class="text-gray-500 text-xs mt-1">Users will be redirected to this URL when they click the notification</p>
                @error('url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Select Channels -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">
                    Send To <span class="text-red-500">*</span>
                </label>
                <div class="space-y-2">
                    @if($telegramConfigured)
                        <label class="flex items-center">
                            <input type="checkbox" name="channels[]" value="telegram" class="mr-2" checked>
                            <span class="text-gray-700">📱 Telegram Channel</span>
                        </label>
                    @endif
                    
                    @if($firebaseConfigured)
                        <label class="flex items-center">
                            <input type="checkbox" name="channels[]" value="firebase" class="mr-2" checked>
                            <span class="text-gray-700">📱 Android App (Firebase)</span>
                        </label>
                    @endif
                    
                    @if($whatsappConfigured)
                        <label class="flex items-center">
                            <input type="checkbox" name="channels[]" value="whatsapp" class="mr-2">
                            <span class="text-gray-700">💬 WhatsApp Channel</span>
                        </label>
                    @endif
                </div>
                @error('channels')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3">
                <button 
                    type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                    📤 Send Notification
                </button>
                <a 
                    href="{{ route('admin.posts.index') }}" 
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold px-6 py-3 rounded-lg transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Help Section -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h3 class="font-semibold text-blue-900 mb-2">💡 Tips:</h3>
        <ul class="text-sm text-blue-800 space-y-1">
            <li>• Keep titles short and catchy (max 100 characters)</li>
            <li>• Write clear and concise messages (max 500 characters)</li>
            <li>• Add a URL to direct users to specific posts or pages</li>
            <li>• Test with one channel first before sending to all</li>
            <li>• Notifications are sent instantly to all subscribers</li>
        </ul>
    </div>
</div>
@endsection
