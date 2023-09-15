<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class UserController extends Controller
{

    public function login(Request $request) 
    {
        $rules = [
            'email'=>'required|email|max:255',
            'password'=>'required|string|max:255',
        ];

        $validationFailMessages = [
            'email.required'=>'Insira o e-mail do usuário.',
            'email.email'=>'O email precisa ter o formato de email. Ex.: seunome@hotmail.com.',
            'email.max'=>'O email não pode ter mais de 255 caracteres.',
            'password.required'=>'Insira a senha do usuário.',
            'password.max'=>'A senha não pode ter mais de 255 caracteres.',
        ];


        try {
            $request->validate($rules, $validationFailMessages);

            list($username) = explode('@', $request->input('email'));
 
            if(auth()->attempt($request->only(['email', 'password']))) {
                return response(
                    [
                        'Authorized',
                        200,
                        'Token:'=>$request->user()->createToken($username)->plainTextToken
                    ]
                    );
            } else {
                return response('Unauthorized', 401);
            }

        } catch (\Throwable $e) {
            return $e->getMessage();
        }

    }

    public function logout(Request $request) {

        $request->user()->currentAccessToken()->delete();
        return response('Logout efetuado com sucesso!');
        
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::orderBy('created_at', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $rules = [
            'name'=>'required|string|max:255|',
            'email'=>'required|email|max:255',
            'password'=>'required|string|max:255',
            'authorize_location'=>'required|boolean'
        ];

        $validationFailMessages = [
            'name.required'=>'Insira o nome do usuário.',
            'name.max'=>'O nome não pode ter mais de 255 caracteres.',
            'email.required'=>'Insira o e-mail do usuário.',
            'email.email'=>'O email precisa ter o formato de email. Ex.: seunome@hotmail.com.',
            'email.max'=>'O email não pode ter mais de 255 caracteres.',
            'password.required'=>'Insira a senha do usuário.',
            'password.max'=>'A senha não pode ter mais de 255 caracteres.',
            'authorize_location.required'=>'Informe se autoriza a localização.',
            'authorize_location.boolean'=>'O campo de "authorize_location" só aceita 1 para "true" ou 0 para "false".'
        ];


        try {
            $request->validate($rules, $validationFailMessages);

            return User::create($request->only('name',  'email', 'password', 'authorize_location'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {        
        $user = User::find($id);

        return $user ?? [];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $rules = [
            'name'=>'string|max:255|',
            'email'=>'email|max:255',
            'password'=>'string|max:255',
            'authorize_location'=>'boolean'
        ];

        $validationFailMessages = [
            'name.max'=>'O nome não pode ter mais de 255 caracteres.',
            'email.email'=>'O email precisa ter o formato de email. Ex.: seunome@hotmail.com.',
            'email.max'=>'O email não pode ter mais de 255 caracteres.',
            'password.max'=>'A senha não pode ter mais de 255 caracteres.',
            'authorize_location.boolean'=>'O campo de "authorize_location" só aceita 1 para "true" ou 0 para "false".'
        ];

        try {            

            $request->validate($rules, $validationFailMessages);

            $inputs = $request->all();

            $usertoUpdate = User::findOrFail($id);

            foreach($inputs as $input=>$value) {
                if(array_key_exists($input, $usertoUpdate->getAttributes())){
                    $usertoUpdate->$input = $value;
                }
            }            

            $usertoUpdate->save();

            return response(
                [
                    'Novos dados:'=>$usertoUpdate
                ],
                201
            );                 

        } catch (\Throwable $e) {

            return $e->getMessage();

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $userToDelete = User::findOrFail($id);

            $userToDelete->delete();

            return response(
                [
                    'Usuário deletado:'=> $userToDelete
                ],
                200
            );

        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
