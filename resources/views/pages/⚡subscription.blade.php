<?php

use Livewire\Component;

new class extends Component {
    public bool $success = false;
    public ?string $email = null;

    public function save(): void
    {
        // dd($this->email);
        $this->success = true;
    }
};
?>

<div>

    @if ($success)
        <p>
            {{ $email }}
        </p>
    @else
        <form wire:submit="save" class="p-5 flex flex-col gap-4">
            <x-ui.input wire:model="email" placeholder="Enter your name..." />

            <x-ui.button type="submit">
                Submit
            </x-ui.button>

        </form>
    @endif


</div>