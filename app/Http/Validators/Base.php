<?php

namespace App\Http\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Base
{
    /**
     * @param Request $request
     * @param array $rules
     * @param array $aliases
     * @param array|null $only
     * @return array{valid: bool, data: array|null}
     */
    public function make(Request $request, array $rules, array $aliases = [], array $only = []): array
    {
        $data = $request instanceof Request ? $request->all() : $request;

        if (!empty($only)) {
            $data = array_intersect_key($data, array_flip($only));

            if (empty($data)) {
                return [
                    'status' => false,
                    'data'  => null,
                    'error' => ['Empty data provided for validation.']
                ];
            }
        }

        $validator = Validator::make($data, $rules);

        if (!empty($aliases)) {
            $validator->setAttributeNames($aliases);
        }

        if ($validator->fails()) {
            return [
                'status' => false,
                'data' => null,
                'error'  => $validator->errors()->all(),
            ];
        }

        return [
            'status' => true,
            'data'  => $validator->validated(),
            'error' => null
        ];
    }
}
