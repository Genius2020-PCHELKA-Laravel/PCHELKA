<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Confirmed()
 * @method static static Completed()
 */
final class BookingStatusEnum extends Enum
{
    const Confirmed = 1;
    const Completed = 2;
}
