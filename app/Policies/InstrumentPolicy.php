<?php

// app/Policies/InstrumentPolicy.php

namespace App\Policies;

use App\Models\Instrument;
use App\Models\User;

class InstrumentPolicy
{
    /** Apenas o dono do instrumento pode editá-lo ou excluí-lo. */
    public function update(User $user, Instrument $instrument): bool
    {
        return $user->id === $instrument->user_id;
    }

    public function delete(User $user, Instrument $instrument): bool
    {
        return $user->id === $instrument->user_id;
    }
}
