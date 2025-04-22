<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lights') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Lights") }}

                    <!-- Modal Trigger -->
                    <button @click="open = true"
                        class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Open Modal
                    </button>

                    <!-- Modal -->
                    <div x-data="{ open: false }">
                        <div x-show="open" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg relative">
                                <h3 class="text-lg font-semibold mb-4">Light Settings</h3>
                                <p class="text-gray-700 mb-4">Customize your lighting preferences here.</p>
                                <div class="flex justify-end space-x-2">
                                    <button @click="open = false"
                                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                                        Cancel
                                    </button>
                                    <button @click="open = false"
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
