<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class TicketController extends Controller
{ 
    public function index()
    {      

        $tickets = Ticket::join('users', 'tickets.id_user', '=', 'users.id')
            ->join('events', 'tickets.id_event', '=', 'events.id')
            ->select(
                'tickets.id',
                'users.name as nome_usuario',
                'events.title as titulo_evento',
                'events.start_date as data_do_evento',
                'tickets.created_at as data_da_compra'
            )
            ->get();

        return $tickets;

    }

    
    public function store(Request $request)
    {
        $rules = [
            'id_user'=>'required|integer',
            'id_event'=>'required|integer'
        ];

        $validateFailMessages = [
            'id_user.required'=>'Insira o valor para o id_user.',
            'id_user.integer'=>'O valor para o id_user deve ser um número inteiro.',
            'id_event.required'=>'Insira o valor para o id_event.',
            'id_event.integer'=>'O valor para o id_event deve ser um número inteiro.',
        ];

        try {
            $request->validate($rules, $validateFailMessages);

            if(!User::find($request->input('id_user'))){
                return "Usuário não encontrado";
            }
    
            if(!Event::find($request->input('id_event'))){
                return "Evento não encontrado";
            }

            return [
                'Ingresso adquirido:'=> Ticket::create($request->only(['id_user', 'id_event']))
            ];

        } catch (\Throwable $e) {
            return $e->getMessage();
        }


    }


    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
