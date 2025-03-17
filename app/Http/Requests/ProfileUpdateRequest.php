<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];

        Log::info('ProfileUpdateRequest rules', $rules);
        Log::info('Request has file: ' . ($this->hasFile('profile_photo') ? 'yes' : 'no'));
        if ($this->hasFile('profile_photo')) {
            Log::info('File info: ' . $this->file('profile_photo')->getClientOriginalName());
        }

        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        // Log the profile photo data before validation
        if ($this->hasFile('profile_photo')) {
            $file = $this->file('profile_photo');
            Log::info('ProfileUpdateRequest preparing for validation with file: ' . $file->getClientOriginalName());
        }
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation(): void
    {
        Log::info('ProfileUpdateRequest passed validation with data', $this->validated());
    }
}
