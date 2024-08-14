<?php

namespace App\Http\Requests;

use App\Models\LedgerAccount;
use App\Rules\DateAfterOrEqual;
use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LedgerDetailFilterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'ledger_account_id' => ['required', Rule::exists(LedgerAccount::class, 'id')],
            'from_date' => ['required', new ValidDate],
            'to_date' => ['required', new ValidDate, new DateAfterOrEqual($this->from_date)],
        ];
    }
}
