<?php

namespace App\Imports;

use App\Models\Record;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RecordsImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Record([
            'date' => $row['altarykh'],
            'name' => $row['alasm'],
            'financier_number' => $row['mmol'],
            'age' => $row['alaamr'],
            'patient_ID' => $row['hoy'],
            'phone_number1' => $row['goal1'],
            'phone_number2' => $row['goal2'],
            'operation' => $row['alaamly'],
            'doctor' => $row['altbyb'],
            'amount' => $row['altklf'],
            'doctor_share' => $row['hs_altbyb'],
            'anesthesiologists_share' => $row['tbyb_altkhdyr'],
            'anesthesia' => $row['hs_altkhdyr'],
            'bed' => $row['almbyt'],
            'private' => $row['khas'],
            'done' => $row['tmt_alaamly'],
            'notes' => $row['mlahthat'],
            'notes_2' => $row['mlahthat_thanoy'],
        ]);
    }
}
