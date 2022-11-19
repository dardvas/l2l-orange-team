<?php


namespace App\Domain\L2lOrange\Dicts;

use http\Exception\InvalidArgumentException;

class CategoriesDict
{
    public const VALUES = [
        1 => 'Work',
        2 => 'Rent',
        3 => 'Visa, documents',
        4 => 'Language',
        5 => 'Health',
        6 => 'Childcare',
        7 => 'Other',
    ];

    public static function validate(int $inputValue): void
    {
        if (!array_key_exists($inputValue, self::VALUES)) {
            throw new InvalidArgumentException("Invalid category value");
        }
    }
}
