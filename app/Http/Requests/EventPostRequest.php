<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class EventPostRequest extends FormRequest
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
        $tenantId = $this->segment(3);

        return [
            'title' => [
                'required','string','max:255',
                Rule::unique('events')->where(function ($query) use ($tenantId) {
                    return $query->where('tenant_id', $tenantId);
                }),
            ],
            'description' => 'string|max:400',
            'start_date' => ['date_format:Y-m-d'],
            'end_date' => ['date_format:Y-m-d'],
            'attributes' => ['json']
        ];
    }



        /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.unique' => 'The event name has already been used in this tenant',
        ];
    }
}
