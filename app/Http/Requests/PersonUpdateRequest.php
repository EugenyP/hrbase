<?php

namespace App\Http\Requests;

use App\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonUpdateRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
	/*
    public function authorize(): bool
    {
        return false;
    }
*/
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
	public function rules(): array
	{
		return [
			'fio'	=> ['required', 'string', 'max:255'],
	//		'firstname'	=> ['required', 'string', 'max:255'],
	//		'surname'	=> ['string', 'max:255'],
	//		'lastname'	=> ['required', 'string', 'max:255'],
			'category_id'	=> ['required'],
			'position'	=> ['required', 'string', 'max:255'],
			'birthday'	=> ['required', 'date'],
			'city'		=> ['required', 'string', 'max:255'],
	//		'address'		=> ['required', 'string', 'max:255'],
	//		'description'	=> ['string'],
		];
	}
}
