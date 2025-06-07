<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EcoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $ecoleId = $this->route('ecole') ? $this->route('ecole')->id : null;

        return [
            'nom' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('ecoles', 'nom')->ignore($ecoleId),
            ],
            'adresse' => 'nullable|string|max:255',
            'ville' => 'required|string|max:100',
            'province' => 'required|string|max:20',
            'telephone' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[\d\(\)\-\+\s\.]+$/',
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('ecoles', 'email')->ignore($ecoleId),
            ],
            'responsable' => 'nullable|string|max:255',
            'active' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de l\'école est obligatoire',
            'nom.min' => 'Le nom doit contenir au moins 2 caractères',
            'nom.max' => 'Le nom ne peut pas dépasser 255 caractères',
            'nom.unique' => 'Une école avec ce nom existe déjà',

            'ville.required' => 'La ville est obligatoire',
            'ville.max' => 'La ville ne peut pas dépasser 100 caractères',

            'province.required' => 'La province est obligatoire',
            'province.max' => 'La province ne peut pas dépasser 20 caractères',

            'telephone.regex' => 'Le format du téléphone n\'est pas valide',
            'telephone.max' => 'Le téléphone ne peut pas dépasser 50 caractères',

            'email.email' => 'L\'adresse email n\'est pas valide',
            'email.unique' => 'Cette adresse email est déjà utilisée',
            'email.max' => 'L\'email ne peut pas dépasser 255 caractères',

            'responsable.max' => 'Le nom du responsable ne peut pas dépasser 255 caractères',
            'adresse.max' => 'L\'adresse ne peut pas dépasser 255 caractères',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nom' => 'nom de l\'école',
            'adresse' => 'adresse',
            'ville' => 'ville',
            'province' => 'province',
            'telephone' => 'téléphone',
            'email' => 'adresse email',
            'responsable' => 'responsable',
            'active' => 'statut',
        ];
    }
}
