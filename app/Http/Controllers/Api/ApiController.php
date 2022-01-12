<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class ApiController extends Controller
{

    /**
     * this response is for fetch data that have result only
     *
     * @param array $data
     * @param bool $status
     * @return JsonResponse
     */

    protected function successResponse($data = [], $status = true): JsonResponse
    {
        $array = [
            "status" => $status,
            "code" => Response::HTTP_OK,
            "data" => $data,
        ];

        return response()->json($array, Response::HTTP_OK);
    }

    /**
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */

    protected function failResponse($code = Response::HTTP_INTERNAL_SERVER_ERROR, $message = 'Something went wrong,please try again later'): JsonResponse
    {
        $array = [
            "code" => $code,
            "message" => $message,
        ];

        return response()->json($array, $code);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */

    protected function notFoundResponse($message = "No Data Found"): JsonResponse
    {
        $array = [
            "status" => false,
            "code" => Response::HTTP_NOT_FOUND,
            "message" => $message,
        ];

        return response()->json($array, Response::HTTP_NOT_FOUND);
    }

    /**
     * This function is using with delete and update methods
     * @param array $data
     * @return JsonResponse
     */
    protected function noContentResponse($data = []): JsonResponse
    {
        return response()->json($data, Response::HTTP_NO_CONTENT);
    }

    /**
     * Validate functions depend on rules,if false throw validation error
     * @param $rules
     * @return JsonResponse|true
     */

    protected function validateApiRequest($rules)
    {
        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            $errors = (new ValidationException($validator))->errors();

            return new JsonResponse([
                "status" => false,
                "code" => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $errors
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            return true;
        }
    }
}
