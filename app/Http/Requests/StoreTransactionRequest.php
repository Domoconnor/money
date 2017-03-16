<?php

namespace App\Http\Requests;

use App\Account;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

    	//Check if the user owns the account they are trying to add a transaction for
    	$account = Account::find($this->route('account'));

    	if($account->user_id === Auth::user()->id)
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
			"budget_id"	=> "integer"
		];
    }
}
