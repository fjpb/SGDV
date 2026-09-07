<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\DocumentType;

/**
 * Validaciones para carga de documentos vehiculares
 */
class DocumentRequest extends FormRequest
{


    /**
     * Permisos de la solicitud
     */
    public function authorize(): bool
    {
        return true;
    }



    /**
     * Reglas de validación
     */
    public function rules(): array
    {

        return [


            /*
            |--------------------------------------------------------------------------
            | Vehículo asociado
            |--------------------------------------------------------------------------
            */

            'vehicle_id' => [

                $this->isMethod('post')
                    ? 'required'
                    : 'nullable',

                'exists:vehicles,id'

            ],



            /*
            |--------------------------------------------------------------------------
            | Información documental
            |--------------------------------------------------------------------------
            */

            'tipo_documento' => [

                'required',

                Rule::exists(
                    'document_types',
                    'nombre'
                )
                ->where(
                    'activo',
                    true
                ),

            ],



            'nombre' => [

                'required',
                'string',
                'max:200'

            ],




            /*
            |--------------------------------------------------------------------------
            | Archivo
            |--------------------------------------------------------------------------
            |
            | mimes:
            |   Solo documentos permitidos
            |
            | max:
            |   Laravel trabaja en KB
            |
            |   10240 KB = 10 MB
            |
            |--------------------------------------------------------------------------
            */

            'archivo' => [

                'nullable',

                'file',

                'mimes:pdf,jpg,jpeg,png',

                'max:10240'

            ],




            /*
            |--------------------------------------------------------------------------
            | Fechas
            |--------------------------------------------------------------------------
            */

            'fecha_emision' => [

                'nullable',
                'date'

            ],



            'fecha_vencimiento' => [

                'nullable',
                'date'

            ],




            /*
            |--------------------------------------------------------------------------
            | Observaciones
            |--------------------------------------------------------------------------
            */

            'observacion' => [

                'nullable',
                'string',
                'max:1000'

            ]

        ];

    }




    /**
     * Mensajes personalizados
     */
    public function messages(): array
    {

        return [


            'archivo.required' =>
                'Debe seleccionar un archivo.',



            'archivo.mimes' =>
                'Solo se permiten archivos PDF, JPG, JPEG o PNG.',



            'archivo.max' =>
                'El archivo supera el tamaño máximo permitido de 10 MB.',



            'nombre.required' =>
                'Debe ingresar un nombre para el documento.'


        ];

    }


}