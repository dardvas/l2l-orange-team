<?php
declare(strict_types=1);

namespace App\Domain\DomainException;

use App\Infrastructure\Http\Response\ResponseCodesDict;

class DomainRecordNotFoundException extends DomainException
{
    public static function forClassAndId(string $class, int $id): self
    {
        return new self("Object $class with ID $id not found", ResponseCodesDict::HTTP_NOT_FOUND);
    }

    public static function forClassAndParams(string $class, array $params): self
    {
        $paramsString = print_r($params, true);

        return new self("Object $class with params $paramsString not found", ResponseCodesDict::HTTP_NOT_FOUND);
    }
}
