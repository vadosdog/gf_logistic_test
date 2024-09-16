<?php

namespace App\Http\Requests;

use App\Support\Status;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeStatusRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = ['status' => ['required', 'string', Rule::in(Status::statuses())]];

        $additionalRules = Status::rules($this->getStatus());

        return array_merge($rules, $additionalRules);
    }

    /**
     * @return int
     */
    public function deliveryId(): int
    {
        return (int) $this->route('delivery');
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->input('status', '');
    }
}
