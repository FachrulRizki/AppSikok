<?php

namespace App\Services;

use App\Models\SpvKepru;
use Illuminate\Http\Request;

class SpvKepruService
{
    public function getAll()
    {
        return SpvKepru::latest()->get();
    }

    public function store(array $data)
    {
        return SpvKepru::create($data);
    }

    public function update(SpvKepru $spv, array $data)
    {
        $spv->update($data);
        return $spv;
    }

    public function delete(SpvKepru $spv)
    {
        return $spv->delete();
    }
}
