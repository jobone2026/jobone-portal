@extends('layouts.admin')

@section('title', 'Advertisements Management')

@section('content')
    <div x-data="{ formOpen: false }">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Advertisements</h2>
            <button @click="formOpen = !formOpen" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                + New Ad
            </button>
        </div>

        <!-- Add Ad Form (Hidden by default) -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6" x-show="formOpen">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Add Advertisement</h3>
            
            <form action="{{ route('admin.ads.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-gray-700 font-bold mb-2">Name *</label>
                        <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                    </div>
                    
                    <div>
                        <label for="position" class="block text-gray-700 font-bold mb-2">Position *</label>
                        <select id="position" name="position" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                            <option value="">Select Position</option>
                            <option value="header">Header</option>
                            <option value="sidebar">Sidebar</option>
                            <option value="after_post">After Post</option>
                            <option value="footer">Footer</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="type" class="block text-gray-700 font-bold mb-2">Type *</label>
                        <select id="type" name="type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                            <option value="">Select Type</option>
                            <option value="adsense">AdSense</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1" checked class="mr-2">
                        <label for="is_active" class="text-gray-700 font-bold">Active</label>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="code" class="block text-gray-700 font-bold mb-2">Ad Code</label>
                    <textarea id="code" name="code" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"></textarea>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Create Ad
                    </button>
                    <button type="button" @click="formOpen = false" class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Ads List -->
        @if ($ads->count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700">Position</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700">Type</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ads as $ad)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $ad->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $ad->position)) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($ad->type) }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if ($ad->is_active)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Active</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm space-x-2">
                                    <form action="{{ route('admin.ads.destroy', $ad) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($ads instanceof \Illuminate\Pagination\Paginator)
                <div class="mt-6">
                    {{ $ads->links() }}
                </div>
            @endif
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <p class="text-gray-500 text-lg">No ads yet</p>
            </div>
        @endif
    </div>
@endsection
