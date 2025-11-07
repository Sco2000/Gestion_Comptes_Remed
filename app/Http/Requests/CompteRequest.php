<?php

namespace App\Http\Requests;

use App\Http\Traits\ApiResponse;
use App\Rules\ValidCIN;
use App\Rules\ValidTelephone;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CompteRequest extends FormRequest
{

    use ApiResponse;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|in:cheque,epargne',
            'solde' => 'required|numeric|min:10000',
            'client.prenom' => 'required|string|max:100',
            'client.nom' => 'required|string|max:100',
            'client.email' => 'required|email',
            'client.telephone' => ['required', new ValidTelephone()],
            'client.adresse' => 'nullable|string|max:255',
            'client.nci' => ['required', 'string', new ValidCIN()],
            'client.date_naissance' => 'required|date_format:Y-m-d',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Le type de compte est obligatoire.',
            'type.in' => 'Le type de compte doit être "cheque" ou "epargne".',

            'solde.required' => 'Le solde initial est obligatoire.',
            'solde.numeric' => 'Le solde initial doit être un nombre.',
            'solde.min' => 'Le solde initial doit être d\'au moins 10 000 FCFA.',

            'client.prenom.required' => 'Le prénom du client est obligatoire.',
            'client.nom.required' => 'Le nom du client est obligatoire.',

            'client.email.required' => 'L\'email du client est obligatoire.',
            'client.email.email' => 'L\'email du client n\'est pas valide.',

            'client.telephone.required' => 'Le téléphone du client est obligatoire.',

            'client.nci.required' => 'Le numéro CNI est obligatoire.',

            'client.date_naissance.required' => 'La date de naissance est obligatoire.',
            'client.date_naissance.date_format:Y-m-d' => 'Le format de la date doit être AAAA-MM-JJ.',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        // On utilise ta successResponse, mais en forçant un succès = false
        $response = $this->errorResponse($validator->errors(), 400);

        throw new HttpResponseException($response);
    }
}
