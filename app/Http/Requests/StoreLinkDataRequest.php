<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLinkDataRequest extends FormRequest
{
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
            // 'user.uuid' => 'nullable|uuid',
            'user.firstName' => 'required|string|max:255',
            'user.lastName' => 'required|string|max:255',
            'user.date_of_birth' => 'required|date',
            'user.country_of_birth' => 'required|string|max:255',
            'user.gender' => 'required|string|in:Male,Female,Other',
            'user.nationality_1' => 'required|string|max:255',
            'user.nationality_2' => 'nullable|string|max:255',
            'user.indentity_number' => 'nullable|string|max:50',
            'user.social_security_number' => 'required|string|max:50',
            'user.permanent_address' => 'required|string|max:500',
            'user.country_of_residence' => 'required|string|max:255',
            'user.town_of_residence' => 'required|string|max:255',
            'user.phone' => 'required|string|max:20',
            'user.personal_email' => 'required|email|max:255',
            'user.marital_status' => 'required|string|in:single,married,divorced,widowed',
            'user.number_of_children' => 'required|integer|min:0',
            'user.family_living_with_staff' => 'required|string|in:yes,no',
            'user.family_residence_location' => 'nullable|string|max:255',
            'user.spouse_works' => 'required|string|in:yes,no',
            'user.spouse_workplace' => 'nullable|string|max:255',

            // 'dependent' => 'required|array|min:1',
            'dependent.*.employeeId' => 'nullable',
            'dependent.*.full_name' => 'required|string|max:255',
            'dependent.*.relation' => 'required|string|max:100',
            'dependent.*.gender' => 'required|string|in:male,female,other',
            'dependent.*.date_of_birth' => 'required|date',
            'dependent.*.residence_or_school' => 'required|string|max:500',
            'dependent.*.nationality' => 'required|string|max:255',

            'emergency' => 'required|array|min:1',
            'emergency.*.employeeId' => 'nullable',
            'emergency.*.name' => 'required|string|max:255',
            'emergency.*.relationship' => 'required|string|max:100',
            // 'emergency.*.birthday' => 'required|date',
            'emergency.*.address' => 'required|string|max:500',
            'emergency.*.email' => 'required|email|max:255',
            'emergency.*.phone' => 'required|string|max:20',

            'beneficiary' => 'required|array|min:1',
            'beneficiary.*.employeeId' => 'nullable',
            'beneficiary.*.full_name' => 'required|string|max:255',
            'beneficiary.*.relationship' => 'required|string|max:100',
            'beneficiary.*.birthday' => 'required|date',
            'beneficiary.*.address' => 'required|string|max:500',
            'beneficiary.*.email' => 'required|email|max:255',
            'beneficiary.*.percentage_share' => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages()
{
    return [
        // user
        'user.uuid.uuid' => "L'UUID doit être au format valide.",
        'user.firstName.required' => 'Le prénom est requis.',
        'user.firstName.string' => 'Le prénom doit être une chaîne de caractères.',
        'user.firstName.max' => 'Le prénom ne doit pas dépasser 255 caractères.',

        'user.lastName.required' => 'Le nom est requis.',
        'user.lastName.string' => 'Le nom doit être une chaîne de caractères.',
        'user.lastName.max' => 'Le nom ne doit pas dépasser 255 caractères.',

        'user.date_of_birth.required' => 'La date de naissance est requise.',
        'user.date_of_birth.date' => 'La date de naissance doit être une date valide.',

        'user.country_of_birth.required' => 'Le pays de naissance est requis.',
        'user.country_of_birth.string' => 'Le pays de naissance doit être une chaîne de caractères.',
        'user.country_of_birth.max' => 'Le pays de naissance ne doit pas dépasser 255 caractères.',

        'user.gender.required' => 'Le genre est requis.',
        'user.gender.in' => 'Le genre doit être Male, Female ou Other.',

        'user.nationality_1.required' => 'La première nationalité est requise.',
        'user.nationality_1.string' => 'La première nationalité doit être une chaîne de caractères.',
        'user.nationality_1.max' => 'La première nationalité ne doit pas dépasser 255 caractères.',

        'user.nationality_2.string' => 'La deuxième nationalité doit être une chaîne de caractères.',
        'user.nationality_2.max' => 'La deuxième nationalité ne doit pas dépasser 255 caractères.',

        'user.indentity_number.required' => "Le numéro d'identité est requis.",
        'user.indentity_number.string' => "Le numéro d'identité doit être une chaîne de caractères.",
        'user.indentity_number.max' => "Le numéro d'identité ne doit pas dépasser 50 caractères.",

        'user.social_security_number.required' => 'Le numéro de sécurité sociale est requis.',
        'user.social_security_number.string' => 'Le numéro de sécurité sociale doit être une chaîne de caractères.',
        'user.social_security_number.max' => 'Le numéro de sécurité sociale ne doit pas dépasser 50 caractères.',

        'user.permanent_address.required' => 'L\'adresse permanente est requise.',
        'user.permanent_address.string' => 'L\'adresse permanente doit être une chaîne de caractères.',
        'user.permanent_address.max' => 'L\'adresse permanente ne doit pas dépasser 500 caractères.',

        'user.country_of_residence.required' => 'Le pays de résidence est requis.',
        'user.country_of_residence.string' => 'Le pays de résidence doit être une chaîne de caractères.',
        'user.country_of_residence.max' => 'Le pays de résidence ne doit pas dépasser 255 caractères.',

        'user.town_of_residence.required' => 'La ville de résidence est requise.',
        'user.town_of_residence.string' => 'La ville de résidence doit être une chaîne de caractères.',
        'user.town_of_residence.max' => 'La ville de résidence ne doit pas dépasser 255 caractères.',

        'user.phone.required' => 'Le téléphone est requis.',
        'user.phone.string' => 'Le téléphone doit être une chaîne de caractères.',
        'user.phone.max' => 'Le téléphone ne doit pas dépasser 20 caractères.',

        'user.personal_email.required' => "L'email personnel est requis.",
        'user.personal_email.email' => "L'email personnel doit être une adresse email valide.",
        'user.personal_email.max' => "L'email personnel ne doit pas dépasser 255 caractères.",

        'user.marital_status.required' => 'Le statut matrimonial est requis.',
        'user.marital_status.in' => 'Le statut matrimonial doit être : single, married, divorced ou widowed.',

        'user.number_of_children.required' => 'Le nombre d\'enfants est requis.',
        'user.number_of_children.integer' => 'Le nombre d\'enfants doit être un entier.',
        'user.number_of_children.min' => 'Le nombre d\'enfants ne peut pas être négatif.',

        'user.family_living_with_staff.required' => 'La présence de la famille avec le personnel est requise.',
        'user.family_living_with_staff.in' => 'La présence de la famille doit être oui ou non.',

        'user.family_residence_location.required' => 'Le lieu de résidence de la famille est requis.',
        'user.family_residence_location.string' => 'Le lieu de résidence de la famille doit être une chaîne de caractères.',
        'user.family_residence_location.max' => 'Le lieu de résidence de la famille ne doit pas dépasser 255 caractères.',

        'user.spouse_works.required' => 'Le statut professionnel du conjoint est requis.',
        'user.spouse_works.in' => 'Le statut professionnel du conjoint doit être oui ou non.',

        'user.spouse_workplace.required' => 'Le lieu de travail du conjoint est requis.',
        'user.spouse_workplace.string' => 'Le lieu de travail du conjoint doit être une chaîne de caractères.',
        'user.spouse_workplace.max' => 'Le lieu de travail du conjoint ne doit pas dépasser 255 caractères.',

        // dependent
        'dependent.required' => 'Au moins une personne à charge est requise.',
        'dependent.array' => 'Les personnes à charge doivent être un tableau.',
        'dependent.min' => 'Au moins une personne à charge doit être fournie.',

        'dependent.*.employeeId.nullable' => "L'ID employé peut être nul.",
        'dependent.*.full_name.required' => 'Le nom complet de la personne à charge est requis.',
        'dependent.*.full_name.string' => 'Le nom complet de la personne à charge doit être une chaîne de caractères.',
        'dependent.*.full_name.max' => 'Le nom complet de la personne à charge ne doit pas dépasser 255 caractères.',

        'dependent.*.relation.required' => 'La relation est requise pour la personne à charge.',
        'dependent.*.relation.string' => 'La relation doit être une chaîne de caractères.',
        'dependent.*.relation.max' => 'La relation ne doit pas dépasser 100 caractères.',

        'dependent.*.gender.required' => 'Le genre de la personne à charge est requis.',
        'dependent.*.gender.in' => 'Le genre de la personne à charge doit être male, female ou other.',

        'dependent.*.date_of_birth.required' => 'La date de naissance de la personne à charge est requise.',
        'dependent.*.date_of_birth.date' => 'La date de naissance de la personne à charge doit être une date valide.',

        'dependent.*.residence_or_school.required' => 'Le lieu de résidence ou d\'école de la personne à charge est requis.',
        'dependent.*.residence_or_school.string' => 'Le lieu de résidence ou d\'école doit être une chaîne de caractères.',
        'dependent.*.residence_or_school.max' => 'Le lieu de résidence ou d\'école ne doit pas dépasser 500 caractères.',

        'dependent.*.nationality.required' => 'La nationalité de la personne à charge est requise.',
        'dependent.*.nationality.string' => 'La nationalité doit être une chaîne de caractères.',
        'dependent.*.nationality.max' => 'La nationalité ne doit pas dépasser 255 caractères.',

        // emergency
        'emergency.required' => 'Au moins un contact d\'urgence est requis.',
        'emergency.array' => 'Les contacts d\'urgence doivent être un tableau.',
        'emergency.min' => 'Au moins un contact d\'urgence doit être fourni.',

        'emergency.*.employeeId.nullable' => "L'ID employé peut être nul.",
        'emergency.*.name.required' => 'Le nom du contact d\'urgence est requis.',
        'emergency.*.name.string' => 'Le nom du contact d\'urgence doit être une chaîne de caractères.',
        'emergency.*.name.max' => 'Le nom du contact d\'urgence ne doit pas dépasser 255 caractères.',

        'emergency.*.relationship.required' => 'La relation du contact d\'urgence est requise.',
        'emergency.*.relationship.string' => 'La relation doit être une chaîne de caractères.',
        'emergency.*.relationship.max' => 'La relation ne doit pas dépasser 100 caractères.',

        'emergency.*.birthday.required' => 'La date de naissance du contact d\'urgence est requise.',
        'emergency.*.birthday.date' => 'La date de naissance du contact d\'urgence doit être une date valide.',

        'emergency.*.address.required' => 'L\'adresse du contact d\'urgence est requise.',
        'emergency.*.address.string' => 'L\'adresse doit être une chaîne de caractères.',
        'emergency.*.address.max' => 'L\'adresse ne doit pas dépasser 500 caractères.',

        'emergency.*.email.required' => "L'email du contact d'urgence est requis.",
        'emergency.*.email.email' => "L'email du contact d'urgence doit être valide.",
        'emergency.*.email.max' => "L'email du contact d'urgence ne doit pas dépasser 255 caractères.",

        'emergency.*.phone.required' => 'Le téléphone du contact d\'urgence est requis.',
        'emergency.*.phone.string' => 'Le téléphone doit être une chaîne de caractères.',
        'emergency.*.phone.max' => 'Le téléphone ne doit pas dépasser 20 caractères.',

        // beneficiary
        'beneficiary.required' => 'Au moins un bénéficiaire est requis.',
        'beneficiary.array' => 'Les bénéficiaires doivent être un tableau.',
        'beneficiary.min' => 'Au moins un bénéficiaire doit être fourni.',

        'beneficiary.*.employeeId.nullable' => "L'ID employé peut être nul.",
        'beneficiary.*.full_name.required' => 'Le nom complet du bénéficiaire est requis.',
        'beneficiary.*.full_name.string' => 'Le nom complet du bénéficiaire doit être une chaîne de caractères.',
        'beneficiary.*.full_name.max' => 'Le nom complet du bénéficiaire ne doit pas dépasser 255 caractères.',

        'beneficiary.*.relationship.required' => 'La relation du bénéficiaire est requise.',
        'beneficiary.*.relationship.string' => 'La relation doit être une chaîne de caractères.',
        'beneficiary.*.relationship.max' => 'La relation ne doit pas dépasser 100 caractères.',

        'beneficiary.*.birthday.required' => 'La date de naissance du bénéficiaire est requise.',
        'beneficiary.*.birthday.date' => 'La date de naissance du bénéficiaire doit être une date valide.',

        'beneficiary.*.address.required' => 'L\'adresse du bénéficiaire est requise.',
        'beneficiary.*.address.string' => 'L\'adresse doit être une chaîne de caractères.',
        'beneficiary.*.address.max' => 'L\'adresse ne doit pas dépasser 500 caractères.',

        'beneficiary.*.email.required' => "L'email du bénéficiaire est requis.",
        'beneficiary.*.email.email' => "L'email du bénéficiaire doit être valide.",
        'beneficiary.*.email.max' => "L'email du bénéficiaire ne doit pas dépasser 255 caractères.",

        'beneficiary.*.percentage_share.required' => 'La part en pourcentage du bénéficiaire est requise.',
        'beneficiary.*.percentage_share.numeric' => 'La part en pourcentage doit être un nombre.',
        'beneficiary.*.percentage_share.min' => 'La part en pourcentage doit être au moins 0.',
        'beneficiary.*.percentage_share.max' => 'La part en pourcentage ne peut pas dépasser 100.',
    ];
}

}
