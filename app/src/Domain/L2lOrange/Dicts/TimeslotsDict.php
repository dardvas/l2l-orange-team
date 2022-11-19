<?php


namespace App\Domain\L2lOrange\Dicts;

use http\Exception\InvalidArgumentException;

class TimeslotsDict
{
    public const VALUES = [
        1 => 'From 8:00 to 11:00',
        2 => 'From 11:00 to 14:00',
        3 => 'From 14:00 to 17:00',
        4 => 'From 17:00 to 20:00',
        5 => 'From 20:00 to 23:00',
    ];

    public static function validate(int $inputValue): void
    {
        if (!array_key_exists($inputValue, self::VALUES)) {
            throw new InvalidArgumentException("Invalid timeslot value");
        }
    }
}
