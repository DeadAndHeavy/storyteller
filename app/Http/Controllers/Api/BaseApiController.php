<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class BaseApiController extends Controller
{
    const CONTENT_TYPE_JSON = 'json';

    protected $request;
    protected $method;
    protected $responseContentType = self::CONTENT_TYPE_JSON;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->method = $request->getMethod();
    }

    public function formattedResponse($responseData)
    {
        return response()->json($responseData);
    }
}
