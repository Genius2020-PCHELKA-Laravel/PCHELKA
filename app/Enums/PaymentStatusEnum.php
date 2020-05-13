<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Paid()
 * @method static static NotPaid()
 * @method static static REFUNDED()
 */
final class PaymentStatusEnum extends Enum
{
    const Paid = 1;
    const NotPaid = 2;
    const REFUNDED = 3;
}
