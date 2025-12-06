<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Airline') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.airlines.update', $airline) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Airline Code</label>
                                <input type="text" name="code" value="{{ $airline->code }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Airline Name</label>
                                <input type="text" name="name" value="{{ $airline->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Update Logo</label>
                                <input type="file" name="logo" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md cursor-pointer">
                                @if($airline->logo)
                                    <p class="mt-2 text-sm text-gray-500">Current Logo:</p>
                                    <img src="{{ asset('storage/' . $airline->logo) }}" class="h-10 mt-1">
                                @endif
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update Airline</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>