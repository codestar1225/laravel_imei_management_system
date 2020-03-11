<?php

namespace App\Imports;

use App\Imei;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportImei implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Imei([
            'document_date' => @\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[0]),
            'product'       => @$row[1],
            'model'         => @$row[2],
            'imei'          => @$row[3]
        ]);
    }
}
