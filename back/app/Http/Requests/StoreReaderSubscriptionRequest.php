<?php

namespace App\Http\Requests;

use App\Rules\UniqueSubscriptionPerBlog;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class StoreReaderSubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'blog_id' => ['required', 'integer', 'exists:blogs,id', new UniqueSubscriptionPerBlog($this->route('user'))],
            'subscription_plan_id' => ['required', 'integer', 'exists:subscription_plans,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'status' => ['nullable', 'string', 'in:holding,active,canceled'],
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
