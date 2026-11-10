<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Raffle;
use App\Models\Applicant;
use Illuminate\Validation\Rule;

new class extends Component {
    public bool $success = false;
    public ?string $email = null;
    public ?Raffle $raffle = null;
    public ?string $winner = null;

    #[Computed]
    public function winners() {
        $this->raffle->winners()->with('applicant')->get();
    }

    #[Computed]
    public function participants()
    {
        return $this->raffle?->applicants ?? collect();
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('applicants', 'email')->where('raffle_id', $this->raffle->id)
            ]
        ];
    }

    public function mount(): void
    {
        $this->raffle = Raffle::inRandomOrder()->first();
    }

    public function save(): void
    {
        $this->validate();

        Applicant::create([
            'raffle_id' => $this->raffle->id,
            'email' => $this->email
        ]);

        $this->success = true;
    }

    public function getWinner(): void
    {
        $this->authorize('drawWinner', $this->raffle);

        if($this->raffle->applicants()->count() < 2) {
            $this->addError('email', 'É necessário ter pelo menos 2 participantes para realizar o sorteio.');
            return;
        }

        $winners = $this->raffle->winners()->pluck('applicant_id');

        $winner = $this->raffle
        ->applicants()
        ->whereNotIn('id', $winners)
        ->inRandomOrder()
        ->first();

        if(!$winner) {
            // adicionar um erro ou alerta
        }

        $this->raffle->winners()->create([
            'applicant_id' => $winner->id,
        ]);

        $this->winner = $winner->email;
    }
};
?>

<div>
    @if (isset($raffle))
    <div>
        <h1 class="text-2xl font-bold mb-4">
            Raffle App :: {{ $raffle->name }}
        </h1>
    </div>
    @endif

    <form wire:submit="save" class="flex flex-col gap-4">
        <x-ui.input wire:model="email" placeholder="Enter your name..." />
        @error('email')
        <div class="text-red-500 text-sm">
            {{ $message }}
        </div>
        @enderror

        <x-ui.button type="submit">
            Submit
        </x-ui.button>

    </form>

    <br />


    @if(count($this->participants) > 0)
    <x-ui.card class="w-full" size='xl'>
        <p class="flex font-bold items-center justify-between mb-4" level="h3" size="sm">
            Participantes

        </p>
        <ul class="w-full">
            @foreach ($this->participants as $participant)
            <li class="not-last:border-b border-b-gray-200 py-2">
                {{ $participant->email }}
            </li>
            @endforeach
        </ul>
    </x-ui.card>

    @if ($this->winners->count())
    <div>
        @foreach ($this->winners as $winner)

        @endforeach
        <h1>The winner is: {{ $winner->applicant->email }}</h1>
    </div>
    @endif

    @can('drawWinner', $raffle)
    <x-ui.button type="button" wire:click="getWinner" class="mt-4 w-full">
        Draw the winner
    </x-ui.button>
    @endcan

    @endif




</div>
