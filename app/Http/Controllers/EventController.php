<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
