<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Exception;

abstract class BaseApiController
{
    public function action(callable $callback)
    {
        try {
            if (is_callable($callback)) {
                call_user_func($callback);
            }
        } catch (Exception $e) {
            report($e);

            throw new Exception("Error Processing Request", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
