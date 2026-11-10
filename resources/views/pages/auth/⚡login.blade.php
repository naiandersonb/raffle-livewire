<?php

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;

new class extends Component {

    #[Validate(['required', 'email'])]
    public ?string $email = null;

    #[Validate(['required', 'string'])]
    public ?string $password = null;


    public function handle(): void
    {
        $this->validate();
        $this->ensureIsNotRateLimited();

        if (
            Auth::attempt([
                'email' => $this->email,
                'password' => $this->password
            ], true)
        ) {
            session()->regenerate();

            $this->redirectRoute('home');
        }

        $this->addError('email', 'Invalid credentials');
    }

    private function ensureIsNotRateLimited(): void {
        if (RateLimiter::tooManyAttempts($this->rateKey(), 5)) {

            $seconds = RateLimiter::availableIn($this->rateKey());

            throw ValidationException::withMessages([
                'email' => 'Too many login attempts. Please try again in ' . $seconds . ' seconds.',

            ]);

        }

        RateLimiter::hit($this->rateKey());
    }

    private function rateKey():string {
        return str($this->email."|" . request()->ip())
            ->replace('@', '_at_')
            ->replace('.', '_')
            ->slug();
    }
};
?>


<div class="p-5 mx-auto max-w-xl">

    <h1 class="text-2xl font-bold mb-4">
        Login
    </h1>

    <form class="flex flex-col gap-4" wire:submit="handle">
        <x-ui.field>
            <x-ui.label>Email Address</x-ui.label>
            <x-ui.input wire:model="email" type="email" placeholder="john@example.com" />
            <x-ui.error name="email" />
        </x-ui.field>

        <x-ui.field>
            <x-ui.label>Password</x-ui.label>
            <x-ui.description>Must be at least 8 characters long and include numbers</x-ui.description>
            <x-ui.input wire:model="password" type="password" placeholder="••••••••" />
            <x-ui.error name="password" />
        </x-ui.field>

        <x-ui.button type="submit">
            Login
        </x-ui.button>
    </form>
</div>