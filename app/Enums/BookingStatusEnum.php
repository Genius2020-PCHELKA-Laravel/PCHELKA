<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Pending()
 * @method static static Confirm()
 * @method static static Completed()
 * @method static static Canceled()
 */
final class BookingStatusEnum extends Enum
{
    const Confirm = 2;
    const Completed = 3;
    const Canceled = 4;
    const Pending = 5;
}
