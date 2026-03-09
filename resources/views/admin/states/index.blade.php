@extends('layouts.admin')

@section('title', 'States Management')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Add State Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">{{ isset($state) ? 'Edit State' : 'Add State' }}</h3>
            
            <form action="{{ isset($state) ? route('admin.states.update', $state) : route('admin.states.store') }}" method="POST">
                @csrf
                @if (isset($state))
                    @method('PUT')
                @endif
                
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $state->name ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600">
                </div>
                
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    {{ isset($state) ? 'Update' : 'Add' }} State
                </button>
            </form>
        </div>
        
        <!-- States List -->
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
                    @forelse ($states as $st)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $st->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $st->posts_count ?? 0 }}</td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <form action="{{ route('admin.states.destroy', $st) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">No states found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($states instanceof \Illuminate\Pagination\Paginator)
        <div class="mt-6">
            {{ $states->links() }}
        </div>
    @endif
@endsection
