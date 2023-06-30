@extends('layout')

@section('title', 'Investments')

@section('content')
    <x-layout class="mb-4">
        <h2 class="text-3xl font-bold">Available Cryptocurrencies</h2>
        <div class=" flex flex-col items-center w-full md:w-2/3 lg:w-1/2 xl:w-1/3">

            <form action="{{ route('investments.search') }}" method="POST" class="flex flex-row mt-4">
                @csrf
                <x-custom-input type="text" name="search" placeholder="Search"/>
                <x-custom-button class="ml-2">
                    Search
                </x-custom-button>
            </form>

            @if ($cryptocurrencies instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="flex flex-row w-full justify-between mt-4">
                    @if ($cryptocurrencies->currentPage() > 1)
                        <x-link-button href="{{ $cryptocurrencies->previousPageUrl() }}">Previous</x-link-button>
                    @else
                        <div></div> <!-- Add an empty div for spacing -->
                    @endif

                    <div></div> <!-- Add an empty div for spacing -->

                    @if ($cryptocurrencies->currentPage() < $cryptocurrencies->lastPage())
                        <x-link-button href="{{ $cryptocurrencies->nextPageUrl() }}">Next</x-link-button>
                    @endif
                </div>
            @endif

            <x-custom-table>
                <thead>
                <tr>
                    <x-custom-table-header>Name</x-custom-table-header>
                    <x-custom-table-header>Symbol</x-custom-table-header>
                    <x-custom-table-header>Price</x-custom-table-header>
                    <x-custom-table-header>Hour %</x-custom-table-header>
                    <x-custom-table-header>Day %</x-custom-table-header>
                    <x-custom-table-header>Week %</x-custom-table-header>
                    <x-custom-table-header>Actions</x-custom-table-header>
                </tr>
                </thead>
                <tbody>
                @foreach ($cryptocurrencies as $crypto)
                    <tr>
                        <x-custom-table-data>{{ $crypto->getName() }}</x-custom-table-data>
                        <x-custom-table-data>{{ $crypto->getSymbol() }}</x-custom-table-data>
                        <x-custom-table-data>${{ number_format($crypto->getPrice(), 3) }}</x-custom-table-data>
                        <x-custom-table-data class="{{ $crypto->getPercentChangeHour() >= 0 ? 'text-green-500' : 'text-red-500' }}">
                            {{ number_format($crypto->getPercentChangeHour(), 2) }}
                        </x-custom-table-data>
                        <x-custom-table-data class="{{ $crypto->getPercentChangeDay() >= 0 ? 'text-green-500' : 'text-red-500' }}">
                            {{ number_format($crypto->getPercentChangeDay(), 2) }}
                        </x-custom-table-data>
                        <x-custom-table-data class="{{ $crypto->getPercentChangeWeek() >= 0 ? 'text-green-500' : 'text-red-500' }}">
                            {{ number_format($crypto->getPercentChangeWeek(), 2) }}
                        </x-custom-table-data>
                        <x-custom-table-data>
                            <x-action-button href="{{ route('purchase', ['id' => $crypto->getId()]) }}">Buy</x-action-button>
                        </x-custom-table-data>
                    </tr>
                @endforeach
                </tbody>
            </x-custom-table>
        </div>
    </x-layout>
@endsection
