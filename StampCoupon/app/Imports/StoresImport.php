<?php

namespace App\Imports;

use App\Models\Store;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Session;


class StoresImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Store([
            'name_store'     => $row[0],
            'address'    => $row[1],
            'app_id' => Session::get('app_id')
        ]);
    }
}
