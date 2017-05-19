<?php

namespace App\Util;

class StatusCodes
{
    // 200 Range
    const SUCC = 200;
    const SUCCESS = 200;
    const CREATED = 201;
    const NO_CONTENT = 204;

    // 400 Range
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const UNPROCESSABLE_ENTITY = 422;
    const IM_A_TEAPOT = 418;
}
