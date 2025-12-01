<?php

namespace App\Domains\Reservations\Repositories;

use App\Domains\Reservations\Models\ReservationEntity;

class ReservationEntityRepository
{
    public function all()
    {
        return ReservationEntity::all();
    }

    public function find($id)
    {
        return ReservationEntity::find($id);
    }

    public function create(array $data)
    {
        return ReservationEntity::create($data);
    }

    public function update($id, array $data)
    {
        $model = ReservationEntity::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        return ReservationEntity::destroy($id);
    }
}