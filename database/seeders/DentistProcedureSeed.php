<?php

namespace Database\Seeders;

use App\Models\DentistProcedures;
use Illuminate\Database\Seeder;

class DentistProcedureSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents(storage_path("backup_json/dentistProcedures.json")), true)["RECORDS"];
        foreach ($json as $key) :
            $procedure = new DentistProcedures();
            $procedure->id = $key['id'];
            $procedure->proceduresF = $key['proceduresF'];
            $procedure->dentistsF = $key['dentistsF'];
            $procedure->save();
        endforeach;
    }
}
