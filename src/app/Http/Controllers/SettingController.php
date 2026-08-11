<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index()
    {

        $settings = Setting::all()
            ->keyBy('key');


        return view(
            'settings.index',
            compact('settings')
        );

    }



    public function update(Request $request)
    {

        $data = $request->validate([

            'institucion_nombre' => [
                'nullable',
                'string',
                'max:255'
            ],

            'dias_alerta_vencimiento' => [
                'nullable',
                'integer',
                'min:1'
            ],

            'email_contacto' => [
                'nullable',
                'email'
            ],

            'logo_institucional' => [
                'nullable',
                'string',
                'max:255'
            ],

        ]);



        foreach($data as $key => $value){

            Setting::setValue(
                $key,
                $value
            );

        }



        return back()
            ->with(
                'success',
                'Configuración actualizada correctamente'
            );

    }

}
