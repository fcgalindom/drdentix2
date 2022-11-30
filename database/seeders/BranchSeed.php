<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents(storage_path("backup_json/branches.json")), true)["RECORDS"];
        foreach ($json as $key) :
            $branch = new Branch();
            $branch->id = $key['id'];
            $branch->name = $key['name'];
            $branch->contact = $key['contact'];
            $branch->city = $key['city'];
            $branch->address = $key['address'];
            $branch->state = $key['state'];
            $branch->save();
        endforeach;
    }
}
