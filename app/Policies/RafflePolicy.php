<?php

namespace App\Policies;

use App\Models\Raffle;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RafflePolicy
{
    public function onlyPublished(?User $user, Raffle $raffle): bool
    {
        if ($user?->is_admin) {
            return true;
        }

        return filled($raffle->published_at);
    }
}
