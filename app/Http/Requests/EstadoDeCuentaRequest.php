<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EstadoDeCuentaRequest
 * @package App\Http\Requests
 * @property string $FechaInicial
 * @property string $FechaFinal
 */
class EstadoDeCuentaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'FechaInicial' => 'required',
            'FechaFinal' => 'required',
        ];
    }
}
