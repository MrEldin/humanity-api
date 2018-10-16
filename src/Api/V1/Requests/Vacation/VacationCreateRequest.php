<?php

namespace Humanity\Api\V1\Requests\Organisation;

use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @SWG\Definition (
 *      definition="PhaseCreateRequestV1",
 *      required={"name"},
 *      @SWG\Property(
 *          property="name",
 *          description="name",
 *          type="string",
 *          example="New Year"
 *      )
 * )
 *
 * Class VacationCreateRequest
 * @package Tempest\Api\V1\Requests\User
 */
class VacationCreateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => 'required',
            'dates'   => 'array|required'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return mixed
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new StoreResourceFailedException('error', $validator->errors());
    }
}
