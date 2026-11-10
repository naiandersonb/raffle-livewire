<?php

use App\Models\Raffle;
use Livewire\Livewire;

it('renders a single table with one row per raffle', function () {
    $raffles = Raffle::factory()->count(3)->create();

    $html = Livewire::test('raffles.table')->html();

    expect(substr_count($html, '<table'))->toBe(1);

    foreach ($raffles as $raffle) {
        expect($html)->toContain(e($raffle->name));
    }
});

it('shows an empty state when there are no raffles', function () {
    Livewire::test('raffles.table')
        ->assertSee('No raffles found.');
});
