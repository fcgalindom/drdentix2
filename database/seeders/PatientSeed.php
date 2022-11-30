<?php

namespace Database\Seeders;

use App\Models\Patients;
use Illuminate\Database\Seeder;

class PatientSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents(storage_path("backup_json/patients.json")), true)["RECORDS"];
        foreach ($json as $key) :
            $patient = new Patients();
            $patient->id = $key['id'];
            $patient->name = $key['name'];
            $patient->city = $key['city'];
            $patient->telephone = $key['telephone'];
            $patient->id_user = $key['id_user'];
            $patient->save();
        endforeach;

    }
}
