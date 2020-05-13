<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static HomeCleaning()
 * @method static static ACCleaning()
 * @method static static CurtainCleaning()
 * @method static static CarpetCleaning()
 * @method static static MattressCleaning()
 * @method static static SofaCleaning()
 * @method static static DeepCleaning()
 * @method static static CarWash()
 * @method static static Laundry()
 * @method static static FullTimeMaid()
 * @method static static DisinfectionService()
 * @method static static BabysitterService()
 */
final class ServicesEnum extends Enum
{
    const HomeCleaning = 1;
    const ACCleaning = 2;
    const CurtainCleaning = 3;
    const CarpetCleaning = 4;
    const MattressCleaning = 5;
    const SofaCleaning = 6;
    const DeepCleaning = 7;
    const CarWash = 8;
    const Laundry = 9;
    const FullTimeMaid = 10;
    const DisinfectionService = 11;
    const BabysitterService = 12;
}
