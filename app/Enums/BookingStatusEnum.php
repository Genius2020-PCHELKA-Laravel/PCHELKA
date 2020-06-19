<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Confirmed()
 * @method static static Completed()
 * @method static static Rescheduled()
 * @method static static Canceled()
 */
final class BookingStatusEnum extends Enum
{
    const Confirmed = 1;
    const Completed = 2;
    const Rescheduled = 3;
    const Canceled = 4;
}
