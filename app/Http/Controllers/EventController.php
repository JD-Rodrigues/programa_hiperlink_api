<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

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
            'image'=>'required|image',
            'start_date'=>'required|date_format:Y-m-d',
        ];

        $validationFailMessages = [
            'title.required'=>'Insira o título do evento.',
            'title.max'=>'O título não pode ter mais de 255 caracteres.',
            'image.required'=>'Insira a imagem.',
            'image.image'=>'Os formatos do arquivo de imagem permitidos são: jpg, jpeg, png, bmp, gif, svg, ou webp',
            'start_date.required'=>'Insira a data de início do evento.',
            'start_date.date_format'=>'A data do evento precisa seguir o formato: Y-m-d. Ex.: 2023-08-03.'
        ];


        try {
            $request->validate($rules, $validationFailMessages);

            $eventTitle = $request->input('title');
            $eventSlug = Str::slug($eventTitle);

            $image = $request->file('image');
            $imageExtension = $image->getClientOriginalExtension();
            $imageName = "$eventSlug.$imageExtension";
            $image->move(public_path('images'), $imageName);

            return Event::create(
                [
                    'title' => $eventTitle,
                    'image' => $imageName,
                    'start_date' => $request->input('start_date')
                ]
            );
            return ;
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
            'image'=>'image',
            'start_date'=>'date_format:Y-m-d',
        ];

        $validationFailMessages = [
            'title.max'=>'O título não pode ter mais de 255 caracteres.',
            'image.image'=>'Os formatos do arquivo de imagem permitidos são: jpg, jpeg, png, bmp, gif, svg, ou webp',
            'start_date.date_format'=>'A data do evento precisa seguir o formato: Y-m-d. Ex.: 2023-08-03.'
        ];

        try {
            $request->validate($rules, $validationFailMessages);

            $inputs = $request->all();
            $imageName = '';
            $eventToUpdate = Event::findOrFail($id);            

            foreach($inputs as $input=>$value){
                if(array_key_exists($input, $eventToUpdate->getAttributes())) {
                    $eventToUpdate->$input = $value;
                }
            }

            if ($request->file('image')){
                $eventTitle = $request->input('title') ?? $eventToUpdate->title;
                $eventSlug = Str::slug($eventTitle);

                $image = $request->file('image');
                $imageExtension = $image->getClientOriginalExtension();
                $imageName = "$eventSlug.$imageExtension";
                $eventToUpdate->image = $imageName;
                $image->move(public_path('images'), $imageName);
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
