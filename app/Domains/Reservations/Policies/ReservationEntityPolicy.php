<?php

namespace App\Domains\Reservations\Policies;

use App\Models\User as AuthUser;
use App\Domains\Reservations\Models\ReservationEntity;

class ReservationEntityPolicy
{
    public function view(AuthUser $user, ReservationEntity $model): bool
    {
        return true;
    }

    public function create(AuthUser $user): bool
    {
        return true;
    }

    public function update(AuthUser $user, ReservationEntity $model): bool
    {
        return true;
    }

    public function delete(AuthUser $user, ReservationEntity $model): bool
    {
        return true;
    }
}