<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Pending()
 * @method static static Confirm()
 * @method static static Completed()
 * @method static static Canceled()
 * @method static static Created()
 */
final class BookingStatusEnum extends Enum
{
    const Pending = 1;
    const Confirm = 2;
    const Completed = 3;
    const Canceled = 4;
    const Created = 4;
}
