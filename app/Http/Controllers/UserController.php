<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
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
        return User::find($id) ? [User::find($id)] : [];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
