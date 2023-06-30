@extends('layout')

@section('title', 'Investment Sale')

@section('content')
    <div class="flex justify-center mt-24" x-data="saleForm()">
        <x-custom-form action="{{ route('sell.store') }}" method="POST">
            @csrf
            <h2 class="text-3xl font-bold">Investment Sale</h2>

            <x-input-field-container>
                <p>Crypto: {{ $crypto->getName() }}</p>
                <p>Symbol: {{ $crypto->getSymbol() }}</p>
                <p>Price in USD: ${{ number_format($crypto->getPrice(), 3) }}</p>
                <p>Available amount: {{ $investment->crypto_amount }}</p>
            </x-input-field-container>

            <input type="hidden" name="investment_id" id="investment_id" value="{{ $investment->id }}">

            <x-input-field-container>
                <label for="amount">Amount:</label>
                <input type="text" name="amount" id="amount" x-model="saleAmount" @input="calculateTotalSalePrice()" class="border-gray-400 border-2 px-5 py-2">
                <div class="flex flex-col border-gray-400 border-2 px-5 py-2 bg-gray-100 mt-2" x-show="totalSalePrice">
                    <p x-text="totalSalePrice"></p>
                </div>
                @error('amount')
                <error>{{ $message }}</error>
                @enderror
            </x-input-field-container>

            <x-input-field-container>
                <label for="2fa_code">Authenticator Code:</label>
                <x-custom-input type="text" name="2fa_code" id="2fa_code" class="tracking-[5px]"/>
                @error('2fa_code')
                <error>{{ $message }}</error>
                @enderror
            </x-input-field-container>

            <div>
                <x-custom-button>Sell</x-custom-button>
            </div>
        </x-custom-form>
    </div>

    <script>
        function saleForm() {
            return {
                saleAmount: null,
                totalSalePrice: null,
                calculateTotalSalePrice() {
                    if (this.saleAmount) {
                        const cryptoPrice = {{ $crypto->getPrice() }};
                        const conversionRate = {{ $conversionRate }};
                        const totalPrice = this.saleAmount * cryptoPrice * conversionRate;
                        const accountCurrency = '{{ $account->currency }}';
                        this.totalSalePrice = `Total Sale Price: ${totalPrice.toFixed(2)} ${accountCurrency}`;
                    } else {
                        this.totalSalePrice = null;
                    }
                }
            };
        }
    </script>
@endsection
