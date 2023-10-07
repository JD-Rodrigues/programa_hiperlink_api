<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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

            $image = $request->file('image');
            
            $imagePath = $image->store();

            return Event::create(
                [
                    'title' => $request->input('title'),
                    'image' => $imagePath,
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
            $image = $request->file('image');

            $eventToUpdate = Event::findOrFail($id);                
            
            $image && Storage::delete($eventToUpdate->image);

            foreach($inputs as $input=>$value){
                if(array_key_exists($input, $eventToUpdate->getAttributes())) {
                    $eventToUpdate->$input = $value;
                }
            }

            if ($image){                
                $imagePath = $image->store();
                $eventToUpdate->image = $imagePath;
            }
        
            
            $eventToUpdate->save();

            return response(
                [                    
                    'Novos_dados:'=>$eventToUpdate
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
            $imageToDelete = $eventToDelete->image;
            Storage::delete($imageToDelete);
            $eventToDelete->delete();
            

            return response(
                [
                    $eventToDelete
                ],
                200
            );

        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
