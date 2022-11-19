<?php

declare(strict_types=1);

namespace App\Application\Exceptions;

use App\Infrastructure\Http\Response\ResponseCodesDict;
use InvalidArgumentException;

class BadRequestException extends InvalidArgumentException
{
    public static function forMissingRequiredParam(string $paramName): self
    {
        return new self("Required param $paramName is missing", ResponseCodesDict::HTTP_BAD_REQUEST);
    }

    public static function forInvalidParamValue(string $paramName, $paramValue): self
    {
        return new self("Invalid param value: $paramName => $paramValue", ResponseCodesDict::HTTP_BAD_REQUEST);
    }
}
