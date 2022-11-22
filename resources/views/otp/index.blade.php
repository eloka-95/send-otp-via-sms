<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>


        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('otp.store')}}">
            @csrf

            <div class="mt-4">
                <x-label for="sentotp" :value="__('ENTER OTP')" />

                <x-input id="sentotp" class="block mt-1 w-full" type="number" name="sentotp" :value="old('sentotp')" required />
            </div>
            
            <x-button class="ml-4">
                 {{ __('verify') }}
            </x-button>
        </form>
    </x-auth-card>
</x-guest-layout>
