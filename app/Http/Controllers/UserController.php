<?php

namespace App\Http\Controllers;

use App\Mail\DentixMail;
use App\Mail\VerifiedMail;
use App\Models\appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UserController extends Controller
{

    public function index()
    {
        if (Auth::user()?->type_user == 'Administrator') :
            return redirect()->intended('/home');
        elseif (Auth::user()?->type_user == 'Patient') :
            return redirect()->intended('/Pacientes/citas');
        else :
            return Inertia::render('Patient/Login');
        endif;
    }

    public function email_verify($id)
    {
        $id = explode('DrDentix', $id);
        $type = $id[1];
        $id = $id[0];
        $id = base64($id, 'decode');
        $type = base64_decode($type);
        $user = User::find($id);
        $user->verify_email = date('Y-m-d H:i:s');
        $user->save();
        $mail = new VerifiedMail;
        Mail::to($user->email)->send($mail);
        if ($type == 'Patient') :
            Auth::logout();
            Auth::attempt(['email' => $user->email, 'password' => $user->password]);
            return redirect()->intended('/Pacientes/citas');
        else :
            return redirect()->intended('/loginAdministrador');
        endif;
    }

    public function update(Request $request)
    {
        $rules = [
            'photo' => 'required|image|file|max:3000'
        ];

        $messages = [
            'photo.required' => 'Debes subir un archivo',
            'photo.file' => 'Necesitas subir un archivo',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) :
            return response()->json([
                'status' => 422,
                'msg' => $validator->errors()->first(),
            ]);
        endif;

        $file = $request->photo;
        $extension = $file->getClientOriginalExtension();
        $name = time() . base64_encode($file->getClientOriginalName()) . ".$extension";
        $request->photo->move(public_path('/images/uploads'), $name);
        $user = User::find($request->id);
        $user->photo = '/images/uploads/' . $name;
        $user->save();
        return response()->json([
            'status' => 200,
            'msg' => 'Imagen de perfil actualizada con éxito',
            'img' => $user->photo,
        ]);
    }

    public function isLog()
    {
        return Auth::user();
    }

    public function error403()
    {
        return Inertia::render('errores/403');
    }

    public function loginAdmin()
    {
        if (Auth::user()?->type_user == 'Administrator') :
            return redirect()->intended('/home');
        elseif (Auth::user()?->type_user == 'Patient') :
            return redirect()->intended('/Pacientes/citas');
        else :
            return Inertia::render('Administrator/Login');
        endif;
    }

    public function logout()
    {
        if (Auth::user()->type_user == 'Administrator') {
            Auth::logout();
            return redirect()->intended('/loginAdministrador');
        } else {
            Auth::logout();
            return redirect()->intended('/');
        }
        Auth::logout();
    }

    public function loginP(Request $request)
    {
        $user =  User::where('document', $request->document)->where('type_user', 'Patient')->first();
        if (empty($user)) :
            return response()->json([
                'status' => 422,
                'msg' => 'Credenciales incorrectas'
            ]);
        else :
            Auth::loginUsingId($user->id);
            if (Auth::user()->state == 'Activo') :
                return response()->json([
                    'status' => 200,
                    'msg' => 'Éxito',
                ]);
            else :
                return response()->json([
                    'status' => 422,
                    'Tu cuenta está temporalmente innabilitada, comunícate con la administración para más información'
                ]);
            endif;
        endif;
    }

    public function loginAdm(Request $request)
    {
        Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if (empty(Auth::user())) :
            return response()->json([
                'status' => 422,
                'msg' => 'Credenciales incorrectas'
            ]);
        else :
            if (Auth::user()->state == 'Inactivo') :
                return response()->json([
                    'status' => 422,
                    'msg' => 'Tu cuenta ha sido innactivada, comunícate con la administración para más información',
                ]);
            else :
                return response()->json([
                    'status' => 200,
                    'msg' => 'Éxito',
                    'user' => Auth::user(),
                ]);
            endif;
        endif;
    }

    public function mail()
    {
        $citas = appointment::with(['dPacient.user', 'dbraches', 'denpro.dentists', 'denpro.procedures'])
            ->where('state', 'Activo')
            ->get();
        foreach ($citas as $row) {
            return $row;
            $datime = $row->day . ' ' . $row->hour;
            $carbon = Carbon::parse($datime)->subHours(24);
            if ($carbon <= Carbon::now()) :
                // return $row;
                $mail = new DentixMail($row);
                Mail::to($row["dPacient"]["user"]["email"])->send($mail);
                $row->state = 'Recordado';
                $row->save();
            endif;
        }
    }


    public function send_whatsapp($message = "Text of Fabian")
    {
        $basic  = new \Vonage\Client\Credentials\Basic('970e637a', '1jhYDeZz6KkADhoW');
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS('573226835874', '3182627014', 'A text message sent using the Nexmo SMS API')
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
        // Nexmo::message()->send([
        //     'to'   => '573226835874',
        //     'from' => '3182627014',
        //     'text' => $message
        // ]);
    }

    public function send_what($message = 'prueba')
    {
        define('CHAT_TOKEN', 'd0yijmeswtms99zr');
        define('CHAT_URL', 'https://api.chat-api.com/instance123');
        $data = [
            'phone' => '79995253422', // Receivers phone
            'body' => 'Hello, Andrew!', // Message
        ];
        $json = json_encode($data); // Encode data to JSON
        // URL for request POST /message
        $token = '83763g87x';
        $instanceId = '777';
        $url = 'https://api.chat-api.com/instance' . $instanceId . '/message?token=' . $token;
        // Make a POST request
        $options = stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/json',
                'content' => $json
            ]
        ]);
        // Send a request
        $result = file_get_contents($url, false, $options);
    }

    public function sendw()
    {

        $id = '1971'; //Please change it with your ID
        $key = "5aad5935731ff73882b11cacfc219ce5c2e115a3";

        $data = array('to' => '+573182627014', 'msg' => '$message_body');

        $url = "https://onyxberry.com/services/wapi/Client/sendMessage";
        $url = $url . '/' . $id . '/' . $key;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        return $response;
    }
    //   public function create(): Response
    //   {
    //       return Inertia::render('CreateJob', [
    //           'mechanics' => User::where('type_user', 'Patient')->when(request('term'), function ($query, $term) {
    //               $query->where('name', 'like', "%$term%");
    //           })->limit(15)->get(),
    //           'consultants' => User::where('type_user', 'Administrator')->when(request('term'), function ($query, $term) {
    //               $query->where('name', 'like', "%$term%");
    //           })->limit(15)->get()
    //       ]);
    //   }


}
