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
use Illuminate\Support\Str;

trait BookingHelperTrait
{
    public function getBookingDetailes($bookingId)
    {
        $response = array();
        $book = Booking::where('id', $bookingId)->
        select(['id','serviceType', 'refCode', 'duoDate', 'duoTime', 'locationId', 'totalAmount', 'paymentWays', 'parentId', 'status', 'discount', 'subTotal','materialPrice'])
            ->first();

        if ($book->locationId == null) {
            $book->locationId = Booking::where('id', $book['parentId'])->select('locationId')->first()->locationId;
        }
        $response['id'] = $book->id;
        $response['serviceType'] = ServicesEnum::getKey($book->serviceType);
        $response['status'] = BookingStatusEnum::getKey($book->status);
        $response['totalAmount'] = $book->totalAmount;
        $response['refCode'] = $book->refCode;
        $response['duoDate'] = $book->duoDate;
        $response['duoTime'] = $book->duoTime;
        $response['paymentWays'] = $book->paymentWays;
        $response['discount'] = $book->discount;
        $response['subTotal'] = $book->subTotal;
        $response['materialPrice']=$book->materialPrice;
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
            dd('hi');
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
            case 27:
            case 28:
            case 39:
            case 40:
            case 51:
            case 52:
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

    public function removeGap($serviceProviderId, $availableDate)
    {
        $times = Schedule::where('serviceProviderId', $serviceProviderId)->where('availableDate', $availableDate)
            ->select(['id', 'timeStart', 'isActive'])
            ->get();
        global $data;
        $data = array();
        global $counter;
        $counter = 0;
        foreach ($times as $time) {
            if ($time['isActive'] == 1) {
                array_push($data, $time['id']);
                $counter++;

            } else if ($time['isActive'] == 0) {
                if ($counter < 5) {
                    for ($i = 0; $i < $counter; $i++) {
                        $row = Schedule::where('id', $data[$i])->first();
                        $row['isActive'] = 0;
                        $row['isGap'] = 1;
                        $row->save();
                    }
                } else {
                    $data = [];
                    $counter = 0;

                }
            }
        }
        if ($counter < 5) {
            for ($i = 0; $i < $counter; $i++) {
                $row = Schedule::where('id', $data[$i])->first();
                $row['isActive'] = 0;
                $row['isGap'] = 1;
                $row->save();
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

    public function convertString($enum)
    {
        $temp = preg_replace('%([a-z])([A-Z])%', '\1 \2', $enum);
        return $temp;
    }

    public function createRefCode()
    {
        global $data;
        do {
            $data = strtoupper(Str::random(6));
            $refCode = Booking::where('refCode', $data)->first();
        } while ($refCode != null);
        return $data;
    }

    public function deActiveSchdule($duoDate, $providerId, $answare, $duoTime)
    {
        $endTime = $this->switchHourAnswer($duoTime, $answare);

        $data = Schedule::where('availableDate', $duoDate)
            ->where('serviceProviderId', $providerId)
            ->whereBetween('timeStart', [$duoTime, $endTime])
            ->get();
        foreach ($data as $singleData) {
            $schedule = Schedule::where('id', $singleData['id'])->first();
            $schedule['isActive'] = 0;
            $schedule->save();
        }
    }

    public function activeSchdule($duoDate, $providerId, $answare, $duoTime)
    {

        $endTime = $this->switchHourAnswer($duoTime, $answare);

        $data = Schedule::where('availableDate', $duoDate)
            ->where('serviceProviderId', $providerId)
            ->whereBetween('timeStart', [$duoTime, $endTime])
            ->get();
        foreach ($data as $singleData) {
            $schedule = Schedule::where('id', $singleData['id'])->first();
            $schedule['isActive'] = 1;
            $schedule->save();
        }
        $times = Schedule::where('serviceProviderId', $providerId)->where('availableDate', $duoDate)->where('isGap', 1)
            ->select(['id', 'timeStart', 'isActive'])
            ->get();
        if ($times) {
            foreach ($times as $time) {
                $row = Schedule::where('id', $time['id'])->first();
                $row->isGap = 0;
                $row->isActive = 1;
                $row->save();
            }
        }
        $this->removeGap($providerId, $duoDate);
    }

    public function autoAssignId($duoDate, $serviceType)
    {
        $response = array();
        $res = DB::table('providers')->select(['providers.id'])
            ->join('providerservices', 'providers.id', '=', 'providerservices.provider_id')
            ->where('providerservices.service_id', '=', ServicesEnum::coerce($serviceType))
            ->get();
        if ($res == null) return null;
        $result = json_decode($res, true);
        foreach ($result as $newData) {
            $this->removeGap($newData['id'], $duoDate);
            $row = DB::table('schedules')->where('serviceProviderId', $newData['id'])
                ->where('isActive', 1)
                ->where('availableDate', '=', $duoDate)
                ->groupBy('serviceProviderId')->count();
            array_push($response, $row);
        }
        if ($response != null) {
            $minShift = max($response);


            $result = DB::table('schedules')->where('isActive', 1)->where('availableDate', '=', $duoDate)
                ->select(['serviceProviderId', DB::raw("COUNT(*) as 't' ")])
                ->groupBy('serviceProviderId')
                ->having('t', '=', $minShift)
                ->first();
            if ($result == null) {
                return null;
            }
            return $result->serviceProviderId;
        } else {
            return null;
        }
    }
}
