<?php

namespace App\Http\Controllers;


use App\Models\Document;
use Illuminate\Support\Facades\Auth;


class CalendarController extends Controller
{


    /**
     * Vista calendario
     */
    public function index()
    {

        return view('calendar.index');

    }





    /**
     * Eventos calendario JSON
     */
    public function events()
    {


        $documents = Document::whereHas(
            'vehicle',
            function($query){

                $query->where(
                    'user_id',
                    Auth::id()
                );

            }
        )
        ->whereNotNull(
            'fecha_vencimiento'
        )
        ->get();



        $events = $documents->map(function($document){


            return [

                'title' =>
                    $document->nombre
                    .' - '
                    .$document->vehicle->patente,


                'start' =>
                    $document->fecha_vencimiento,


                'color' =>
                    match($document->estadoActual()){


                        'Vigente'
                            => '#2fb344',


                        'Por vencer'
                            => '#f59f00',


                        'Vencido'
                            => '#d63939',


                        default
                            => '#6c757d'

                    }

            ];


        });



        return response()->json(
            $events
        );


    }


}