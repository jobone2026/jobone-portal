@extends('layouts.admin')

@section('title', 'Authors Management')

@section('content')
    <div x-data="{ formOpen: false }">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Authors</h2>
            <button @click="formOpen = !formOpen" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                + New Author
            </button>
        </div>

        <!-- Add Author Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6" x-show="formOpen">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Add Author</h3>
            
            <form action="{{ route('admin.authors.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-gray-700 font-bold mb-2">Name *</label>
                        <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-gray-700 font-bold mb-2">Email *</label>
                        <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="password" class="block text-gray-700 font-bold mb-2">Password *</label>
                        <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirm Password *</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="bio" class="block text-gray-700 font-bold mb-2">Bio</label>
                    <textarea id="bio" name="bio" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"></textarea>
                </div>

                <div class="mb-6 flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" checked class="mr-2">
                    <label for="is_active" class="text-gray-700 font-bold">Active</label>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Create Author
                    </button>
                    <button type="button" @click="formOpen = false" class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Authors List -->
        @if ($authors->count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700">Created</th>
                            <th class="px-6 py-3 text-left text-sm font-bold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($authors as $author)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $author->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $author->email }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if ($author->is_active)
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Active</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $author->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-sm space-x-2">
                                    <a href="{{ route('admin.authors.edit', $author) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                    <form action="{{ route('admin.authors.destroy', $author) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
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
            @if ($authors instanceof \Illuminate\Pagination\Paginator)
                <div class="mt-6">
                    {{ $authors->links() }}
                </div>
            @endif
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <p class="text-gray-500 text-lg">No authors yet</p>
            </div>
        @endif
    </div>
@endsection
