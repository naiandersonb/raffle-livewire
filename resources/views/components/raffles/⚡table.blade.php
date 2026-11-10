<?php

use Livewire\Component;
use App\Models\Raffle;
use Livewire\Attributes\Computed;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Features\SupportPagination\HandlesPagination;

new class extends Component
{
    use HandlesPagination;

    #[Computed()]
    public function records(): LengthAwarePaginator {
        return Raffle::query()->withCount('applicants')->latest()->paginate(7);
    }
};
?>

<div>

    <div x-data="{name: 'Bruno', open: false}">
        <button @click="open = !open">toggle</button>
        <div x-show="open">
            <span x-text="name"></span>
        </div>
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
                <x-ui.table.cell>Ações</x-ui.table.cell>
            </x-ui.table.row>
            @empty
            <x-ui.table.empty>No raffles found.</x-ui.table.empty>
            @endforelse
        </x-ui.table.rows>
    </x-ui.table>

    {{ $this->records->links() }}
</div>