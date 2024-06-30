<?php

namespace App\Http\Requests;

use App\Constants\Constants;
use Illuminate\Foundation\Http\FormRequest;

class MicrositeRequest extends FormRequest
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
        $types = implode(',', Constants::MICROSITE_TYPES);
        $currrency = implode(',', Constants::MICROSITE_CURRENCY);

        return [
            'name' => 'required|string|max:255',
            'logo' => '',
            'category_id' => 'required|exists:categories,id',
            'currency' => "required|string|max:3|in:{$currrency}",
            'payment_expiration' => 'required|integer',
            'type' => "required|string|in:{$types}",
        ];
    }
}
