<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MembreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $membreId = $this->route('membre') ? $this->route('membre') : null;

        return [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('membres')->ignore($membreId)
            ],
            'ecole_id' => ['required', 'exists:ecoles,id'],
            'date_naissance' => ['nullable', 'date', 'before:today'],
            'sexe' => ['nullable', Rule::in(['H', 'F'])],
            'telephone' => ['nullable', 'string', 'max:255'],
            'numero_rue' => ['nullable', 'string', 'max:255'],
            'nom_rue' => ['nullable', 'string', 'max:255'],
            'ville' => ['nullable', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:50'],
            'code_postal' => ['nullable', 'string', 'max:10'],
            'approuve' => ['boolean']
        ];
    }

    public function messages()
    {
        return [
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire', 
            'email.email' => 'Format d\'email invalide',
            'email.unique' => 'Cet email est déjà utilisé',
            'ecole_id.required' => 'L\'école est obligatoire',
            'ecole_id.exists' => 'École invalide',
            'date_naissance.date' => 'Date de naissance invalide',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui',
            'sexe.in' => 'Sexe invalide (H ou F)'
        ];
    }
}
