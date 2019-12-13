<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LikeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (bool)request()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'entity' => 'required|in:article,image',
            'entity_id' => 'required|integer|min:1',
        ];
    }

    /**
     * @return array
     */
    public function validationData()
    {
        return array_merge($this->request->all(), [
            'entity' => $this->route()->parameter('entity'),
            'entity_id' => $this->route()->parameter('entity_id')
        ]);
    }
}
