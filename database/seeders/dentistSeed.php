<?php

namespace Database\Seeders;

use App\Models\Dentist;
use Illuminate\Database\Seeder;
use App\Models\Schedule;
class dentistSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents(storage_path("backup_json/dentists.json")), true)["RECORDS"];
        foreach ($json as $key) :
            $dentist = new Dentist();
            $dentist->id = $key['id'];
            $dentist->name = $key['name'];
            $dentist->city = $key['city'];
            $dentist->id_user = $key['id_user'];
            $dentist->save();
        endforeach;
    }
}
