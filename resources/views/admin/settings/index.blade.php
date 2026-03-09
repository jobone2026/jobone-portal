@extends('layouts.admin')

@section('title', 'Site Settings')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Site Settings</h2>
        
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="site_name" class="block text-gray-700 font-bold mb-2">Site Name</label>
                    <input type="text" id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                </div>
                
                <div>
                    <label for="contact_email" class="block text-gray-700 font-bold mb-2">Contact Email</label>
                    <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="phone" class="block text-gray-700 font-bold mb-2">Phone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                </div>
                
                <div>
                    <label for="whatsapp_number" class="block text-gray-700 font-bold mb-2">WhatsApp Number</label>
                    <input type="text" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                </div>
            </div>

            <div class="mb-6">
                <label for="address" class="block text-gray-700 font-bold mb-2">Address</label>
                <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">{{ old('address', $settings['address'] ?? '') }}</textarea>
            </div>

            <div class="mb-6">
                <label for="site_description" class="block text-gray-700 font-bold mb-2">Site Description</label>
                <textarea id="site_description" name="site_description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="ga_tracking_id" class="block text-gray-700 font-bold mb-2">Google Analytics Tracking ID</label>
                    <input type="text" id="ga_tracking_id" name="ga_tracking_id" value="{{ old('ga_tracking_id', $settings['ga_tracking_id'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600" placeholder="G-XXXXXXXXXX">
                </div>
                
                <div>
                    <label for="adsense_publisher_id" class="block text-gray-700 font-bold mb-2">AdSense Publisher ID</label>
                    <input type="text" id="adsense_publisher_id" name="adsense_publisher_id" value="{{ old('adsense_publisher_id', $settings['adsense_publisher_id'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600" placeholder="ca-pub-xxxxxxxxxxxxxxxx">
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Social Media Links</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="facebook_url" class="block text-gray-700 font-bold mb-2">Facebook URL</label>
                        <input type="url" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                    </div>
                    
                    <div>
                        <label for="twitter_url" class="block text-gray-700 font-bold mb-2">Twitter URL</label>
                        <input type="url" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                    </div>
                    
                    <div>
                        <label for="telegram_url" class="block text-gray-700 font-bold mb-2">Telegram URL</label>
                        <input type="url" id="telegram_url" name="telegram_url" value="{{ old('telegram_url', $settings['telegram_url'] ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                    </div>
                </div>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
@endsection
