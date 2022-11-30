<?php

namespace Database\Seeders;

use App\Models\Procedures;
use Illuminate\Database\Seeder;

class ProceduresSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents(storage_path("backup_json/procedures.json")), true)["RECORDS"];
        foreach ($json as $key) :
            $procedure = new Procedures();
            $procedure->id = $key['id'];
            $procedure->name = $key['name'];
            $procedure->duration = $key['duration'];
            $procedure->state = $key['state'];
            $procedure->save();
        endforeach;
    }
}
