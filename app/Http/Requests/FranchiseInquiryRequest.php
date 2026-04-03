<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FranchiseInquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:190'],
            'phone' => ['required', 'string', 'max:64'],
            'email' => ['required', 'email:rfc', 'max:190'],
            'postal_code' => ['required', 'string', 'max:32'],
            'has_independent_activity' => ['required', Rule::in(['0', '1', 'yes', 'no', 'oui', 'non'])],
            'geographic_sector' => ['required', 'string', 'max:255'],
            'personal_contribution' => ['nullable', 'string', 'max:120'],
            'message' => ['nullable', 'string', 'max:8000'],
        ];
    }

    public function hasIndependentActivityAsBool(): bool
    {
        $v = (string) $this->input('has_independent_activity', '');

        return in_array(strtolower($v), ['1', 'yes', 'oui', 'true', 'on'], true);
    }

    /**
     * @return array{name: string, phone: string, email: string, postal_code: string, has_independent_activity: bool, geographic_sector: string, personal_contribution: ?string, message: ?string}
     */
    public function inquiryPayload(): array
    {
        return [
            'name' => trim((string) $this->input('name')),
            'phone' => trim((string) $this->input('phone')),
            'email' => trim((string) $this->input('email')),
            'postal_code' => trim((string) $this->input('postal_code')),
            'has_independent_activity' => $this->hasIndependentActivityAsBool(),
            'geographic_sector' => trim((string) $this->input('geographic_sector')),
            'personal_contribution' => ($s = trim((string) $this->input('personal_contribution', ''))) !== '' ? $s : null,
            'message' => ($m = trim((string) $this->input('message', ''))) !== '' ? $m : null,
        ];
    }
}
