<?php

namespace App\Domains\Drugs\Repositories;

use App\Domains\Drugs\Models\DrugEntity;
use Maatwebsite\Excel\Facades\Excel;
use App\Domains\Drugs\Imports\DrugsImport;

class DrugEntityRepository
{
    public function importFromExcel($file)
    {
        Excel::import(new DrugsImport, $file);
        return true;
    }

    public function all()
    {
        return DrugEntity::with('creator')->latest()->get();
    }

    public function find($id)
    {
        return DrugEntity::with('creator')->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['created_by'] = auth('admin')->check() ? auth('admin')->id() : null;
        return DrugEntity::create($data); 
    }

    public function update($id, array $data)
    {
        $drug = $this->find($id);
        $drug->update($data);
        return $drug;
    }

    public function delete($id)
    {
        return DrugEntity::destroy($id);
    }
}
