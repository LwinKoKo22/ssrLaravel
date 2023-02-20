<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('verify.store') }}">
            @csrf
            <h1>Two Factor Verification</h1>
            <p class="text-muted">
                You have received an email with contains two factor login code.
                If you haven't received it,press <a href="{{ route('verify.resend') }}">here</a>.
            </p>
            <div>
                <x-input  class="block mt-1 w-full" type="number" name="two_factor_code" :value="old('email')"  autofocus />
            </div>
                <x-button class="mt-4">Verify</x-button>         
        </form>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <x-button class="mt-4">Logout</x-button>
        </form>
    </x-auth-card>
</x-guest-layout>
