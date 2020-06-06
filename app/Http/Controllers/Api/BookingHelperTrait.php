<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatusEnum;
use App\Enums\ServicesEnum;
use App\Models\Booking;
use App\Models\QuestionDetails;
use App\Models\UserLocation;
use Illuminate\Support\Facades\Validator;

trait BookingHelperTrait
{
    public function getBookingDetailes($bookingId)
    {
        $response = array();
        $book = Booking::where('id', $bookingId)->
        select(['serviceType', 'refCode', 'duoDate', 'duoTime', 'locationId', 'totalAmount', 'paymentWays', 'parentId', 'status'])->first();


        $response['serviceType'] = ServicesEnum::getKey($book->serviceType);
        $response['status'] = BookingStatusEnum::getKey($book->status);
        $response['totalAmount'] = $book->totalAmount;
        $response['refCode'] = $book->refCode;
        $response['duoDate'] = $book->duoDate;
        $response['duoTime'] = $book->duoTime;
        $response['paymentWays'] = $book->paymentWays;

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
}
