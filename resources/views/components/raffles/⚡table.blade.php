<?php

use Livewire\Component;
use App\Models\Raffle;
use Livewire\Attributes\{On,Computed};
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;


new class extends Component
{
    use WithPagination;

    #[Computed()]
    #[On('raffle:refresh')]
    public function records(): LengthAwarePaginator {
        return Raffle::query()->withCount('applicants')->latest()->paginate(7);
    }
};
?>

<div>

    <div class="flex flex-row items-center justify-end">
        {{-- <x-ui.button size="md" @click="$dispatch('raffle:create')">
            Create raffle
        </x-ui.button> --}}
        <x-ui.modal.trigger id="create-raffle">
            <x-ui.button>
                Open
            </x-ui.button>
        </x-ui.modal.trigger>
    </div>

    <x-ui.table>
        <x-ui.table.header>
            <x-ui.table.columns>
                <x-ui.table.head>ID</x-ui.table.head>
                <x-ui.table.head>Name</x-ui.table.head>
                <x-ui.table.head></x-ui.table.head>
            </x-ui.table.columns>
        </x-ui.table.header>

        <x-ui.table.rows>
            @forelse ($this->records as $record)
            <x-ui.table.row :key="$record->id">
                <x-ui.table.cell>{{ $record->id }}</x-ui.table.cell>
                <x-ui.table.cell>{{ $record->name }}</x-ui.table.cell>
                <x-ui.table.cell>{{ $record->created_at->format('d/m/Y H:i') }}</x-ui.table.cell>
                <x-ui.table.cell>
                    <x-ui.modal.trigger id="edit-raffle">
                        <x-ui.button @click="$dispatch('raffle:edit', {id: {{ $record->id }}})">
                            Edit
                        </x-ui.button>
                    </x-ui.modal.trigger>
                    {{-- <x-ui.button @click="$dispatch('open-modal', 'edit-raffle')">
                        Edit
                    </x-ui.button> --}}
                </x-ui.table.cell>
            </x-ui.table.row>
            @empty
            <x-ui.table.empty>No raffles found.</x-ui.table.empty>
            @endforelse
        </x-ui.table.rows>
    </x-ui.table>

    {{ $this->records->links() }}
</div>