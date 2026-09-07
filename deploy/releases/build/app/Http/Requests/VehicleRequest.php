<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }



    public function rules(): array
    {
        return [

            'patente' => [
                'required',
                'string',
                'max:10'
            ],


            'tipo' => [
                'required',
                'string',
                'max:50'
            ],


            'marca' => [
                'required',
                'string',
                'max:100'
            ],


            'modelo' => [
                'required',
                'string',
                'max:100'
            ],


            'anio' => [
                'required',
                'integer',
                'min:1900',
                'max:' . date('Y')
            ],


            'color' => [
                'required',
                'string',
                'max:50'
            ]

        ];
    }

}