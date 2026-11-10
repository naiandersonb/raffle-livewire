<?php

use Livewire\Component;
use Livewire\Attributes\On;
// use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use App\Models\Raffle;

new class extends Component
{
    // public bool $modal = false;
    //  #[Validate(['required', 'string','min:5','max:255','unique:raffles,name'])]
    public ?int $id = null;
    public ?string $name = null;

    public function handle(): void {
        Raffle::where('id', $this->id)
        ->delete();

        $this->dispatch('close-modal', id: 'destroy-raffle');
        $this->dispatch('raffle:refresh');
        $this->reset('name');
    }

    #[On('raffle:destroy')]
    public function open(int $id):void {
        $this->id = $id;
        $raffle = Raffle::findOrFail($id);
        $this->name = $raffle->name;
    }
};
?>

<div>
    <x-ui.modal id="destroy-raffle" heading="Delete Raffle" display-classes="contents">
        <p>Delete raffle <b>'{{$name}}'</b>?</p>

        <div class="flex flex-row items-center gap-4">
            <x-ui.button wire:loading.atts='disabled' class="w-full mt-6" wire:click='handle' variant="ghost">
                No, thank you!
            </x-ui.button>

            <x-ui.button wire:loading.atts='disabled' class="w-full mt-6" wire:click='handle' wire:target='handle'>
                Yes, please!!
            </x-ui.button>
        </div>


    </x-ui.modal>
</div>