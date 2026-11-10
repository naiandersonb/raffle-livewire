<?php

use Livewire\Component;
// use Livewire\Attributes\On;
// use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;
use App\Models\Raffle;

new class extends Component
{
    // public bool $modal = false;
    //  #[Validate(['required', 'string','min:5','max:255','unique:raffles,name'])]
    public ?string $name = null;

    public function rules():array {
        return [
            'name' =>[
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('raffles', 'name')
            ]
        ];
    }

    public function handle(): void {
        $this->validate();
        Raffle::create(['name' => $this->name]);
        $this->dispatch('close-modal', id: 'create-raffle');
        $this->dispatch('raffle:refresh');
        $this->reset('name');
    }

    // #[On('raffle:create')]
    // exemplo da aula
    // public function open():void {
    //     $this->modal = true;
    //     // dd($this->modal);
    // }
};
?>

<div>
    <x-ui.modal id="create-raffle" heading="Create new Raffle">
        <form class="space-y-4" wire:submit='handle'>
            <x-ui.field>
                <x-ui.label>Name</x-ui.label>
                <x-ui.input wire:model="name" placeholder="Sorteio xpto.." />
                <x-ui.error name="name" />
            </x-ui.field>

            <x-ui.button wire:loading.atts='disabled' type="submit" class="w-full" wire:target='handle'>
                Save
            </x-ui.button>

        </form>
    </x-ui.modal>
</div>