<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreBudetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		$user = $this->route('user');

		if($user->id === Auth::user()->id)
		{
			return true;
		}

		return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			"name"		=> "required|string|max:255",
			"amount" 	=> "required|regex:/^\d*(\.\d{1,2})?$/",
        ];
    }
}
