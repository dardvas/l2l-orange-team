<?php

declare(strict_types=1);

namespace App\Application\Exceptions;

use App\Infrastructure\Http\Response\ResponseCodesDict;
use RuntimeException;

class UnauthorizedException extends RuntimeException
{
    protected $code = ResponseCodesDict::HTTP_UNAUTHORIZED;
}
