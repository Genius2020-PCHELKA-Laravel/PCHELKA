<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatusEnum;
use App\Enums\ServicesEnum;
use App\Models\Booking;
use App\Models\QuestionDetails;
use App\Models\Schedule;
use App\Models\UserLocation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

trait BookingHelperTrait
{
    public function getBookingDetailes($bookingId)
    {
        $response = array();
        $book = Booking::where('id', $bookingId)->
        select(['serviceType', 'refCode', 'duoDate', 'duoTime', 'locationId', 'totalAmount', 'paymentWays', 'parentId', 'status', 'discount', 'subTotal'])->first();


        $response['serviceType'] = ServicesEnum::getKey($book->serviceType);
        $response['status'] = BookingStatusEnum::getKey($book->status);
        $response['totalAmount'] = $book->totalAmount;
        $response['refCode'] = $book->refCode;
        $response['duoDate'] = $book->duoDate;
        $response['duoTime'] = $book->duoTime;
        $response['paymentWays'] = $book->paymentWays;
        $response['discount'] = $book->discount;
        $response['subTotal'] = $book->subTotal;

        $address = UserLocation::where('id', $book->locationId)
            ->select(['address', 'details', 'area', 'street', 'buildingNumber', 'apartment'])->first();
        if ($address) {
            $response['addressDetails'] = [
                'locationId' => $book->locationId,
                'address' => $address->address,
                'details' => $address->details,
                'area' => $address->area,
                'street' => $address->street,
                'buildingNumber' => $address->buildingNumber,
                'apartment' => $address->apartment];
        } else {
            $response['addressDetails'] = null;
        }
        $response['parentId'] = $book->parentId;
        return $response;
    }

    public function getAnswer($id)
    {
        $temp = QuestionDetails::where('id', $id)->first()->name;
        return $temp;
    }

    public function frequencyConvert($id)
    {
        switch ($id) {
            case 1:
            case 2:
            case 3:
                $frequancy = QuestionDetails::where('id', $id)->first()->name;
                switch ($frequancy) {
                    case 'One-time' :
                        return 1;
                        break;
                    case 'Bi-weekly' :
                        return 2;
                        break;
                    case 'Weekly' :
                        return 3;
                        break;
                }
                return isTrue();
                break;
            default :
                return isFalse();
        }
    }

    public function materialsConvert($id)
    {
        switch ($id) {
            case 14:
            case 15:
                $material = QuestionDetails::where('id', $id)->first()->name;
                switch ($material) {
                    case 'No , I have them' :
                        return 0;
                        break;
                    case 'Yes , Please' :
                        return 1;
                        break;
                }
                return isTrue();
                break;
            default :
                return isFalse();
        }
    }

    public function removeGap($serviceProviderId)
    {
        $times = Schedule::where('serviceProviderId', 1)->select(['id', 'timeStart', 'isActive'])->get();

        foreach ($times as $time) {
            if ($time['isActive'] == 1) {
                $after2Hours = date('H:i', strtotime($time['timeStart']) + (60 * 60) * 2);
                $timeCond = Schedule::where('serviceProviderId', $serviceProviderId)
                    ->where('timeStart', $after2Hours)->select(['timeStart', 'isActive'])->first();
                if ($timeCond && $timeCond['isActive'] == false) {
                    $row = Schedule::where('id', $time['id'])->first();
                    $row['isActive'] = 0;
                    $row->save();
                }
            }
        }
    }

    public function switchHourAnswer($duoTime, $answare)
    {
        global $to;
        switch ($answare) {
            case 4 :
            case 17 :
            case 29 :
            case 41 :
            {
                $to = 60 * 60 * 2;
                break;
            }

            case 5 :
            case 18 :
            case 30 :
            case 42 :
            {
                $to = 60 * 60 * 3;
                break;
            }

            case 6 :
            case 19 :
            case 31 :
            case 43 :
            {
                $to = 60 * 60 * 4;
                break;
            }

            case 7 :
            case 20 :
            case 32 :
            case 44 :
            {
                $to = 60 * 60 * 5;
                break;
            }

            case 8 :
            case 21 :
            case 33 :
            case 45 :
            {
                $to = 60 * 60 * 6;
                break;
            }

            case 9 :
            case 22 :
            case 34 :
            case 46 :
            {
                $to = 60 * 60 * 7;
                break;
            }
            default:
            {
                return $this->apiResponse('Please select available time value', null, 404);
            }
        }
        $timestamp = strtotime($duoTime) + intval($to);
        $endTime = date('H:i', $timestamp);
        return $endTime;
    }


}
