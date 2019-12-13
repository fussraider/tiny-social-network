<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditEntityRequest extends FormRequest
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
            'id' => 'required|integer|min:1',
            'title' => 'required_if:entity,article|string|min:3|max:140',
            'body' => 'required_if:entity,article|string|min:50',
            'description' => 'required_if:entity,image|string|max:255'
        ];
    }
}
