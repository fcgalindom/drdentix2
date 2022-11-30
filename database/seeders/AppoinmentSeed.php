<?php

namespace Database\Seeders;

use App\Models\appointment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppoinmentSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents(storage_path("backup_json/appointments.json")), true)["RECORDS"];

        foreach ($json as $key) {
            $procedure = new appointment();
            $procedure->id = $key['id'];
            $procedure->day = Carbon::createFromFormat('d/m/Y', $key['day'])->format('Y-m-d');
            $procedure->hour = $key['hour'];
            $procedure->branchesF = $key['branchesF'];
            $procedure->patientsF = $key['patientsF'];
            $procedure->dentistProceduresF = $key['dentistProceduresF'];
            $procedure->state = $key['state'];
            $procedure->pay = $key['pay'];
            $procedure->type_state = $key['type_state'];
            $procedure->save();
        }
    }
}
