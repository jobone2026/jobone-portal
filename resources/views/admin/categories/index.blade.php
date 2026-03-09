@extends('layouts.admin')

@section('title', 'Categories Management')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Add Category Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">{{ isset($category) ? 'Edit Category' : 'Add Category' }}</h3>
            
            <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
                @csrf
                @if (isset($category))
                    @method('PUT')
                @endif
                
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                </div>
                
                <div class="mb-4">
                    <label for="icon" class="block text-gray-700 font-bold mb-2">Icon</label>
                    <input type="text" id="icon" name="icon" value="{{ old('icon', $category->icon ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600" placeholder="e.g., briefcase">
                </div>
                
                <div class="mb-4">
                    <label for="color" class="block text-gray-700 font-bold mb-2">Color</label>
                    <input type="color" id="color" name="color" value="{{ old('color', $category->color ?? '#3B82F6') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                </div>
                
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    {{ isset($category) ? 'Update' : 'Add' }} Category
                </button>
            </form>
        </div>
        
        <!-- Categories List -->
        <div class="md:col-span-2 bg-white rounded-lg shadow-md overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-700">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-700">Posts</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $cat)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $cat->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $cat->posts_count ?? 0 }}</td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">No categories found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($categories instanceof \Illuminate\Pagination\Paginator)
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    @endif
@endsection
