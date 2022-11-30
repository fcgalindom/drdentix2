<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents(storage_path("backup_json/schedules.json")), true)["RECORDS"];
        foreach ($json as $key) :
            foreach ($key as $index => $value) :
                if (empty($value)) $key[$index] = null;
            endforeach;
            $procedure = new Schedule();
            $procedure->id = $key['id'];
            $procedure->hour_strart = $key['hour_strart'];
            $procedure->hour_end = $key['hour_end'];
            $procedure->break = $key['break'];
            $procedure->break_strart = $key['break_strart'];
            $procedure->break_end = $key['break_end'];
            $procedure->attend = $key['attend'] == 'f' ? false : true;
            $procedure->day = $key['day'];
            $procedure->dentistF = $key['dentistF'];
            $procedure->save();
        endforeach;
    }
}
