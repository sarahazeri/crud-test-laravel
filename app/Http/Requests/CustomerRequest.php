<?php

namespace App\Http\Requests;

use App\Models\Enums\CustomerPrefixPhoneNumberEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;

class CustomerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(Request $request): array
    {
        return [
            'first_name' => [
                'required', 'string', 'max:50',
                Rule::unique('customers')
                    ->where(function ($query) use ($request) {
                        return $query->where('first_name', $request->first_name)
                            ->where('last_name', $request->last_name)
                            ->where('date_of_birth', $request->date_of_birth);
                    })->ignore($request->id),
            ],
            'last_name' => 'required|string|max:50',
            'date_of_birth' => ['date', 'required'],
            'prefix_phone_number' => 'required',
            'prefix_phone_number' => [new Enum(CustomerPrefixPhoneNumberEnum::class)],
            'phone_number' => 'required|int',
            'email' => ['required', 'string', 'max:255',
                Rule::unique('customers', 'email')->ignore($request->id),
            ],
            'bank_account_number' => 'nullable|string'
        ];
    }
}
