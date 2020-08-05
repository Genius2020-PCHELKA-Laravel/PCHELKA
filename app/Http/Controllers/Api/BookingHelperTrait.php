<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookingStatusEnum;
use App\Enums\ServicesEnum;
use App\Http\Controllers\ItemSizeController;
use App\Models\Booking;
use App\Models\BookingAnswers;
use App\Models\Evaluation;
use App\Models\QuestionDetails;
use App\Models\Schedule;
use App\Models\ServiceProvider;
use App\Models\UserLocation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlockFactory;

trait BookingHelperTrait
{
    public function getBookingDetailes($bookingId)
    {
        $response = array();
        $book = Booking::where('id', $bookingId)->first();

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
        $response['updatedAt'] = date('Y-m-d', strtotime($book->updated_at));
        $response['materialPrice'] = $book->materialPrice;
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
        $bookingEvaluation = Evaluation::where('bookingId', $book->id)->first();
        $response['bookingEvaluation'] = $bookingEvaluation == null ? 0 : $bookingEvaluation->starCount;
        $response['providerEvaluation'] = number_format(doubleval(Evaluation::where('serviceProviderId', $book->providerId)->avg('starCount')), 1, '.', '');
        $response['parentId'] = $book->parentId;
        return $response;
    }

    public function getAnswer($id)
    {
        $temp = QuestionDetails::where('id', $id)->first();
        if ($temp)
            return $temp->name;
        else {
            return null;
        }
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
                return null;
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
//            ->whereBetween('timeStart', ["17:00:00", "19:00:00"])
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

    public function autoAssignId($duoDate, $duoTime = null, $serviceType, $answare = null)
    {

        $response = array();
        $res = DB::table('providers')->where('email', '!=', 'auto@auto.auto')->select(['providers.id'])
            ->join('providerservices', 'providers.id', '=', 'providerservices.provider_id')
            ->where('providerservices.service_id', '=', ServicesEnum::coerce($serviceType))->distinct()
            ->get();
        $result = json_decode($res, true);
        if (empty($result)) {
            $auto = DB::table('providers')->where('email', '=', 'auto@auto.auto')
                ->select(['providers.id'])->first();
            if (!$auto) {
                $this->createAutoAssignProvider();
            }
            $auto = DB::table('providers')->where('email', '=', 'auto@auto.auto')
                ->select(['providers.id'])->first();
            return $auto->id;
        }
        foreach ($result as $newData) {
            $active = $this->testIfActive($duoDate, $duoTime, $newData['id'], $answare);
            if ($active) {
                $this->removeGap($newData['id'], $duoDate);
                $row['count'] = DB::table('schedules')->where('serviceProviderId', $newData['id'])
                    ->where('isActive', 1)
                    ->where('availableDate', '=', $duoDate)
                    ->groupBy('serviceProviderId')->count();
                $row['providerId'] = $newData['id'];
                array_push($response, $row);
            }
        }

        $ff = $response ? max(array_column($response, 'count')) : null;

        global $providerId;
        if ($ff > 0) {
            $availableProvider = array();
            foreach ($response as $key => $val) {
                if ($val['count'] === $ff) {
                    $active = $this->testIfActive($duoDate, $duoTime, $response[$key]['providerId'], $answare);
                    if ($active)
                        array_push($availableProvider, $key);
                }
            }
            $randomValue = array_rand($availableProvider);
            $providerId = $response[$availableProvider[$randomValue]]['providerId'];
        }

        if ($response != null) {
            return $providerId;
        } else {
            $auto = ServiceProvider::where('email', '=', 'auto@auto.auto')->first();
            if ($auto)
                return $auto->id;
            else {
                $this->createAutoAssignProvider();
                $auto = ServiceProvider::where('email', '=', 'auto@auto.auto')->first();
                return $auto->id;
            }
        }
    }

    public function autoAssignRefresh()
    {
        $prov = DB::table('providers')->where('email', '=', 'auto@auto.auto')->select('id')->first();
        DB::table('schedules')->where('serviceProviderId', $prov->id)->delete();

        $begin = new \DateTime("08:00");
        $end = new \DateTime("20:30");
        $interval = \DateInterval::createFromDateString('30 min');
        $times = new \DatePeriod($begin, $interval, $end);
        global $date;
        $date = date("Y-m-d");
        for ($i = 0; $i < 20; $i++) {
            foreach ($times as $time) {
                DB::table('schedules')->insert(
                    [
                        'availableDate' => date('Y-m-d', strtotime($date)),
                        'timeStart' => $time->format('H:i'),
                        'timeEnd' => $time->add($interval)->format('H:i'),
                        'serviceProviderId' => $prov->id,
                    ]);
            }
            $date = date('Y-m-d', strtotime($date . ' +1 day'));
        }
        return 0;
    }

    public function createAutoAssignProvider()
    {
        $auto = DB::table('providers')->where('email', '=', 'auto@auto.auto')
            ->select(['providers.id'])->first();
        if (!$auto) {
            DB::table('providers')->insert([
                [
                    'name' => 'Auto Assign',
                    'email' => "auto@auto.auto",
                    'mobileNumber' => "",
                    'imageUrl' => 'https://s3.amazonaws.com/uifaces/faces/twitter/ladylexy/128.jpg'
                ]]);
            $autoProviderId = DB::table('providers')->where('email', '=', 'auto@auto.auto')
                ->select(['providers.id'])->first();
            for ($i = 1; $i < 13; $i++) {
                DB::table('providerservices')->insert([
                    'service_id' => $i,
                    'provider_id' => $autoProviderId->id,
                ]);
            }
        }
    }

    public function testIfActive($duoDate, $duoTime, $providerId, $answare)
    {
        global $counter;
        global $endTime;
        $counter = 0;
        if ($answare == null) {
            $to = 60 * 60 * 2;
            $timestamp = strtotime($duoTime) + intval($to);
            $endTime = date('H:i', $timestamp);
        } else {
            $endTime = $this->switchHourAnswer($duoTime, $answare);
            if ($endTime == null) {
                $to = 60 * 60 * 2;
                $timestamp = strtotime($duoTime) + intval($to);
                $endTime = date('H:i', $timestamp);
            }
        }
        $data = Schedule::where('availableDate', $duoDate)
            ->where('serviceProviderId', $providerId)
            ->whereBetween('timeStart', [$duoTime, $endTime])
            ->get();
        foreach ($data as $signal) {
            if ($signal->isActive == 1) {
                $counter++;
            }
        }
        if ($counter == count($data)) {
            return true;
        } else {
            return false;
        }


    }

    public function checkIfHasHour($answers)
    {
        global $temp;
        $temp = false;
        foreach ($answers as $answer) {
            if ($answer['questionId'] == 2 || $answer['questionId'] == 6 || $answer['questionId'] == 9 || $answer['questionId'] == 12)
                $temp = true;
        }
        if ($temp == false) {
            $row = ['questionId' => 2,
                'answerId' => 4,
                'answerValue' => null];
            array_push($answers, $row);
            return $answers;
        } else {
            return $answers;
        }
    }

}
