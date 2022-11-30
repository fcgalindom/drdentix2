<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents(storage_path("backup_json/users.json")), true)["RECORDS"];
        foreach ($json as $key) :
            $user = new User();
            if ($key['birth'] != "") $user->birth = Carbon::createFromFormat('d/m/Y', $key['birth'])->format('Y-m-d');
            if ($key['verify_birth'] != "") $user->verify_birth = Carbon::createFromFormat('d/m/Y', $key['verify_birth'])->format('Y-m-d');
            $user->id = $key['id'];
            $user->document = $key['document'];
            $user->email = $key['email'];
            $user->password = $key['password'];
            $user->type_user = $key['type_user'];
            $user->state = $key['state'];
            $user->photo = $key['photo'];
            $user->save();
        endforeach;
    }
}
