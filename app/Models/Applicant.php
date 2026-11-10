<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Applicant extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicantFactory> */
    use HasFactory;

    public function raffle(): BelongsTo
    {
        return $this->belongsTo(Raffle::class);
    }

    public function winners(): HasMany
    {
        return $this->hasMany(Winner::class);
    }
}
