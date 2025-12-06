<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add Airline') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.airlines.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Airline Code</label>
                                <input type="text" name="code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="GA">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Airline Name</label>
                                <input type="text" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required placeholder="Garuda Indonesia">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Logo (Optional)</label>
                                <input type="file" name="logo" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md cursor-pointer focus:outline-none">
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Save Airline</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>