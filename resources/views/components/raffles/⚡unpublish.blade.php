<?php

use Livewire\Component;
use Livewire\Attributes\On;
// use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use App\Models\Raffle;

new class extends Component
{
    public ?int $id = null;
    public ?Raffle $raffle = null;

    public function handle(): void {
        $this->raffle->update(['published_at' => null]);

        $this->dispatch('close-modal', id: 'unpublish-raffle');
        $this->dispatch('raffle:refresh');
        $this->reset();
    }

    #[On('raffle:unpublish')]
    public function open(int $id):void {
        $this->id = $id;
        $this->raffle = Raffle::findOrFail($id);
    }

    public function close():void {
        $this->dispatch('close-modal', id: 'unpublish-raffle');
        $this->reset();
    }



};
?>

<div>
    <x-ui.modal id="unpublish-raffle" heading="Publish Raffle" display-classes="contents">
        <p>Unpublishe this Raffle?</p>

        <div class="flex flex-row items-center gap-4">
            <x-ui.button wire:loading.atts='disabled' class="w-full mt-6" wire:click='close' variant="ghost">
                No, thank you!
            </x-ui.button>

            <x-ui.button wire:loading.atts='disabled' class="w-full mt-6" wire:click='handle' wire:target='handle'>
                Yes, please!!
            </x-ui.button>
        </div>


    </x-ui.modal>
</div>