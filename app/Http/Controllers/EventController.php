<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Event::orderBy('created_at', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $rules = [
            'title'=>'required|string|max:255|',
            'image'=>'required|string|max:255',
            'start_date'=>'required|date_format:Y-m-d',
        ];

        $validationFailMessages = [
            'title.required'=>'Insira o título do evento.',
            'title.max'=>'O título não pode ter mais de 255 caracteres.',
            'image.required'=>'Insira o nome da imagem.',
            'image.string'=>'O nome da imagem precisa ser texto, contendo nome e extensão. Ex.: minha-imagem.jpg',
            'start_date.required'=>'Insira a data de início do evento.',
            'start_date.date_format'=>'A data do evento precisa seguir o formato: Y-m-d. Ex.: 2023-08-03.'
        ];


        try {
            $request->validate($rules, $validationFailMessages);

            return Event::create($request->only('title',  'image', 'start_date'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $event = Event::find($id);

        return $event ?? [];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $rules = [
            'title'=>'string|max:255|',
            'image'=>'string|max:255',
            'start_date'=>'date_format:Y-m-d',
        ];

        $validationFailMessages = [
            'title.max'=>'O título não pode ter mais de 255 caracteres.',
            'image.string'=>'O nome da imagem precisa ser texto, contendo nome e extensão. Ex.: minha-imagem.jpg',
            'start_date.date_format'=>'A data do evento precisa seguir o formato: Y-m-d. Ex.: 2023-08-03.'
        ];

        try {
            $request->validate($rules, $validationFailMessages);

            $inputs = $request->all();
            $eventToUpdate = Event::findOrFail($id);

            foreach($inputs as $input=>$value){
                if(array_key_exists($input, $eventToUpdate->getAttributes())) {
                    $eventToUpdate->$input = $value;
                }
            }

            $eventToUpdate->save();

            return response(
                [                    
                    'Novos dados:'=>$eventToUpdate
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
            $eventToDelete = Event::findOrFail($id);

            $eventToDelete->delete();

            return response(
                [
                    'Usuário deletado:'=> $eventToDelete
                ],
                200
            );

        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
