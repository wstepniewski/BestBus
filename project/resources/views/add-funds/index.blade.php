<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Adding funds') }}
        </h2>
    </x-slot>
    @if(isset(Auth::user()->id))
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    {{ $insufficientFunds??'' }}

                    <form method="post" action="{{ route('add-funds.confirm') }}">

                        @csrf

                        <div>
                            <x-label for="amount" :value="__('Amount')" />
                            {{$message??''}}
                            <x-input id="amount" class="block mt-1 w-full" type="text" name="amount" :value="old('amount')" autofocus />
                        </div>

                        <x-input name="routeToTicketsBuy" value="{{$routeToTicketsBuy??''}}" hidden/>
                        <x-input name="timeId" value="{{$timeId??''}}" hidden/>



                        <div class="flex items-center justify-end mt-4">

                            <x-button class="ml-4">
                                {{ __('Add funds') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        {{ "Total cost:" . explode('-', $insufficientFunds)[1]}}
                        <form method="post" action="{{ route('tickets.buy') }}">

                            @csrf
                            <?php $amount = explode(' ', $insufficientFunds)[3]; ?>
                            <x-input name="amount" value="{{$amount}}" hidden />

                            <x-input name="routeToTicketsBuy" value="{{$routeToTicketsBuy??''}}" hidden/>
                            <x-input name="timeId" value="{{$timeId??''}}" hidden/>



                            <div class="flex items-center justify-end mt-4">

                                <x-button class="ml-4">
                                    {{ __('Pay') }}
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
</x-app-layout>
