<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    @if(!auth()->user()->subscribe)
                        <form action="{{ route('subscribe') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Subscribe Now</button>
                        </form>
                    @else
                        <p>You are already subscribed.</p>
                    @endif

                    @if(session('message'))
                        <div class="alert alert-info mt-2">{{ session('message') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
