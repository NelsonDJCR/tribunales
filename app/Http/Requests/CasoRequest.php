<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Http\JsonResponse;

class CasoRequest extends FormRequest
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
            'id_tipo_tramite' => 'required',
            'fecha_eleccion' => 'required|date',
            'id_tipo_eleccion' => 'required',
            'id_prioridad' => 'required',
            'fecha_recibido' => 'required|date',
            'id_medio_recepcion' => 'required',
            'correo_notificacion' => 'required|email',
            'informante_anonimo' => 'required|in:Si,No',
            'id_departamento' => 'required',
            'id_ciudad' => 'required',
            'direccion' => 'required',
            'barrio' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'puesto_votacion' => 'required',
            'mesa_votacion' => 'required',
            'asunto' => 'required',
            'hechos' => 'required',
            'nombres_solicitante' => 'required',
            'id_tipo_identificacion' => 'required',
            'numero_identificacion' => 'required',
            'id_departamento_recidencia' => 'required',
            'id_ciudad_recidencia' => 'required',
            'direccion_recidencia' => 'required',
            'telefono' => 'required',
            // 'id_estado' => 'required',
            // 'id_asesor_asignado' => 'required',
            // 'fecha_gestion' => 'required|date',
            // 'fecha_respuesta' => 'required|date',
            // 'gestion' => 'required'
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'id_tipo_tramite.required' => 'El tramite es requerido.',
    //     ];
    // }

    public function attributes()
    {
        return [
            'id_tipo_tramite' => 'Tipo de trámite',
            'fecha_eleccion' => 'Fecha de elección',
            'id_tipo_eleccion' => 'Tipo de elección',
            'id_prioridad' => 'Prioridad',
            'fecha_recibido' => 'Fecha de recibido',
            'id_medio_recepcion' => 'Medio de recepción',
            'correo_notificacion' => 'Correo de notificación',
            'informante_anonimo' => 'Informante anónimo',
            'id_departamento' => 'Departamento',
            'id_ciudad' => 'Ciudad',
            'direccion' => 'Dirección',
            'barrio' => 'Barrio',
            'fecha_inicio' => 'Fecha inicio',
            'fecha_fin' => 'Fecha fin',
            'puesto_votacion' => 'Puesto de votación',
            'mesa_votacion' => 'Mesa de votación',
            'asunto' => 'Asunto',
            'hechos' => 'Hechos',
            'nombres_solicitante' => 'Nombres y apellidos del solicitante',
            'id_tipo_identificacion' => 'Tipo de identificación',
            'numero_identificacion' => 'Número de identificación',
            'id_departamento_recidencia' => 'Departamento de recidencia',
            'id_ciudad_recidencia' => 'Ciudad de recidencia',
            'direccion_recidencia' => 'Dirección de recidencia',
            'telefono' => 'Teléfono de recidencia',
            'id_estado' => 'Estado',
            'id_asesor_asignado' => 'Asesor asignado',
            'fecha_gestion' => 'Fecha de asignación',
            'fecha_respuesta' => 'Fecha de respuesta',
            'gestion' => 'Respuesta'
        ];
    }
}
