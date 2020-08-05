<?php

namespace App\Http\Controllers;

use App\Enums\BookingStatusEnum;
use App\Enums\ServicesEnum;
use App\Http\Controllers\Api\BookingHelperTrait;
use App\Models\Booking;
use App\Models\BookingAnswers;
use App\Models\Company;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\ServiceProvider;
use App\Models\UserLocation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use NunoMaduro\Collision\Provider;

class ServiceProviderController extends Controller
{
    use BookingHelperTrait;

    public function canDeleteProvider($id)
    {
        $temp = Booking::where('providerId', $id)
            ->where(function ($q) {
                $q->where('status', '=', BookingStatusEnum::Confirmed)
                    ->orWhere('status', '=', BookingStatusEnum::Rescheduled)
                    ->orWhere('status', '=', BookingStatusEnum::Completed)
                    ->orWhere('status', '=', BookingStatusEnum::Canceled);
            })
            ->first();

        if ($temp) return false;
        else  return true;
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function providerByCompany(Request $request)
    {
        $data = array();
        $data = ServiceProvider::all();
        $services = Service::all();
        $company = Company::all();

        $serviceId = $request->serviceId;
        if ($serviceId != "") {
            $data = DB::table('providers')->join('providerservices', 'providers.id', '=', 'providerservices.provider_id')
                ->where('providerservices.service_id', '=', $serviceId)->get();
        }

        return view('admin.Provider.showBycompany', ['data' => $data, 'services' => $services, 'company' => $company]);
    }

    public function providerByService(Request $request)
    {
        $data = array();

        $services = Service::all();
        $company = Company::all();

        $serviceId = $request->serviceId;
        if ($serviceId != null) {
            $data = DB::table('providers')->join('providerservices', 'providers.id', '=', 'providerservices.provider_id')
                ->where('providerservices.service_id', '=', $serviceId)->distinct()->get();
        } else {
            $data = DB::table('providers')
                ->join('providerservices', 'providers.id', '=', 'providerservices.provider_id')
                ->where('providerservices.service_id', '=', 1)
                ->distinct()
                ->get();

        }
        return view('admin.Provider.provider', ['data' => $data, 'services' => $services, 'company' => $company]);
    }

    public function ShowBYcompany(Request $request)
    {
        $FindProvider = $request->input('serviceType');
        $services = Service::all();
        $company = Company::all();
        $data = DB::table('providers')->select(['providers.mobileNumber', 'providers.name', 'providers.id', 'providers.email'])
            ->join('companies', 'providers.companyId', '=', 'companies.id')
            ->where('companies.name', '=', $FindProvider)->distinct()
            ->get();
        return view('admin.Provider.showBycompany', compact('data', 'company', 'services'));
        //
    }

    public function ShowBYservices(Request $request)
    {
        $FindProvider = $request->input('serviceType');
        $services = Service::all();
        $company = Company::all();
        $data = DB::table('providerservices')->select(['providers.mobileNumber', 'providers.name', 'providers.id', 'providers.email'])
            ->join('providers', 'providerservices.provider_Id', '=', 'providers.id')
            ->join('services', 'providerservices.service_Id', '=', 'services.id')
            ->where('services.id', '=', $FindProvider)
            ->get();
        return view('admin.Provider.provider', compact('data', 'services', 'company'));
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $companies =  Company::pluck('name','id')->toArray();
        $data = array();
        $data = ServiceProvider::all();
        $services = Service::all();
        $company = Company::all();
        return view('admin.Provider.index', ['data' => $data, 'services' => $services, 'company' => $company]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        if ($request->isMethod('post')) {
            if ($request->has('providerImage')) {
                $imagex = $request->file('providerImage')->store('/public');
                $nn = Storage::url($imagex);
                $ah = $nn;
                // $item->providerImage = x
                $request['imageUrl'] = $ah;
            } else {
                $request['imageUrl'] = 'test';
            }
            $provider = ServiceProvider::create($request->all());
            foreach ($request->services as $service) {
                DB::table('providerservices')->insert(['service_id' => $service, 'provider_id' => $provider->id]);
            }
            //return redirect()->back();
        } else {
            $services = Service::all();
            $company = Company::all();
            // return view('admin.Provider.addProvider', ['services' => $services, 'company' => $company]);
        }
    }

    public function edit(Request $request, $id)
    {
        $provider = ServiceProvider::find($id);
        if ($request->isMethod('post')) {
            if ($request->has('providerImage')) {
                $TheImage = $request->file('providerImage')->store('/public');
                //$move = Storage::url($TheImage);
                $contents = Storage::url($TheImage);
                $ah = $contents;
                $request['imageUrl'] = $ah;
                $provider->imageUrl = $request['imageUrl'];
            }
            $provider->name = $request['name'];
            $provider->email = $request['email'];
            $provider->mobileNumber = $request['mobileNumber'];
            $provider->companyId = $request['companyId'];
            $provider->save();

            DB::table('providerservices')->where('provider_id', '=', $id)->delete();

            $newServices = $request['services'];
            foreach ($newServices as $service) {
                DB::table('providerservices')->insert(['service_id' => $service, 'provider_id' => $id]);
            }

            return redirect('/provider');
        } else {
            $ser = ServiceProvider::find($id);
            $company = Company::all();
            $services = DB::table('providerservices')->where('provider_id', $ser->id)->get();
            $emptyArray = [];
            foreach ($services as $sacoOo) {
                $se = Service::find($sacoOo->service_id);
                array_push($emptyArray, $se->name);
            }
            $AllServ = Service::all();
            return view('admin.Provider.editProvider', ['data' => $ser, 'company' => $company, 'services' => $emptyArray, 'AllServ' => $AllServ]);
        }
    }

    public function changeProvider($id, Request $request)
    {

        $response = array();
        if ($request->isMethod('POST')) {

            global $oldHourId;
            $booking = Booking::find($id);

            if ($booking->parentId != null) {
                $oldHourId = BookingAnswers::where('bookingId', $booking->parentId)->where('questionId', 2)
                    ->orWhere('questionId', 6)->orWhere('questionId', 9)->orWhere('questionId', 12)
                    ->select(['answerId'])->first();

            } else {
                $oldHourId = BookingAnswers::where('bookingId', $id)->where('questionId', 2)
                    ->orWhere('questionId', 6)->orWhere('questionId', 9)->orWhere('questionId', 12)
                    ->select(['answerId'])->first();
            }
            $duoDate = $booking->duoDate;
            $duoTime = $booking->duoTime;
            $newProvider = ServiceProvider::where('id', $request->providerId)->first();
            $oldProvider = $booking->providerId;
            $booking->providerId = $newProvider->id;
            if ($oldHourId['answerId'] != null) {
                $this->deActiveSchdule($duoDate, $newProvider->id, $oldHourId['answerId'], $duoTime);
                $this->activeSchdule($duoDate, $oldProvider, $oldHourId['answerId'], $duoTime);
            }
            $booking->save();
            $this->removeGap($oldProvider,$duoDate);
            $this->removeGap($newProvider->id,$duoDate);
            return redirect('Booking/upComingBooking');
        } else {

            global $oldHourId;
            $availableProvider = array();
            $booking = Booking::where('id', $id)->first();
            $provider = ServiceProvider::where('id', $booking->providerId)->first();
            $client = User::where('id', $booking->userId)->first();
            $response["refCode"] = $booking->refCode;
            $response["duoDate"] = $booking->duoDate;
            $response["duoTime"] = $booking->duoTime;
            if ($booking->parentId == null) {
                $response ['userLocation'] = UserLocation::where('id', '=', $booking->locationId)->select('address')->first()->address;
            } else {
                $locationId = Booking::where('id', $booking->parentId)->select('locationId')->first();
                $response ['userLocation'] = UserLocation::where('id', '=', $locationId->locationId)->select('address')->first()->address;
            }
            $response["providerName"] = $provider->name;
            $response["providerMobileNumber"] = $provider->mobileNumber;
            $response["clientName"] = $client->fullName;
            $response["clientMobileNumber"] = $client->mobile;
            $response["serviceType"] = ServicesEnum::getKey($booking->serviceType);

            $autoId = ServiceProvider::where('email', '=', 'auto@auto.auto')->first();
            $providersByService = DB::table('providerservices')->where('provider_id', '!=', $autoId->id)
                ->where('service_id', '=', $booking->serviceType)->get();

            if ($booking->parentId != null) {
                $oldHourId = BookingAnswers::where('bookingId', $booking->parentId)->where('questionId', 2)
                    ->orWhere('questionId', 6)->orWhere('questionId', 9)->orWhere('questionId', 12)
                    ->select(['answerId'])->first();

            } else {
                $oldHourId = BookingAnswers::where('bookingId', $id)->where('questionId', 2)
                    ->orWhere('questionId', 6)->orWhere('questionId', 9)->orWhere('questionId', 12)
                    ->select(['answerId'])->first();

            }

            foreach ($providersByService as $provider) {
                $row = ServiceProvider::where('id', $provider->provider_id)->first();
                if ($row) {
                    $active = $this->testIfActive($booking->duoDate, $booking->duoTime, $row->id, $oldHourId->answerId);
                    if ($active) {
                        array_push($availableProvider, $row);
                    }
                }
            }
            $availableProvider = array_unique($availableProvider);
            return view('admin.Provider.changeProvider', compact('response', 'availableProvider'));
        }
    }

    public function search(Request $request)
    {
        if ($request->isMethod('post')) {
            $search = ServiceProvider::where('name', 'like', '%' . $request['searchForAll'] . '%')
                ->orWhere('mobileNumber', 'like', '%' . $request['searchForAll'] . '%')->get();
            if (count($search) > 0) {
                $services = Service::all();
                $company = Company::all();
                return view('admin.Provider.index', ['data' => $search, 'search' => true, 'services' => $services, 'company' => $company]);
            } else {
                return redirect()->route('viewProvider');
            }
        }

    }

    public function destroy($id)
    {
        $canDelete = $this->canDeleteProvider($id);
        if ($canDelete) {
            $provider = ServiceProvider::find($id);
            $provider->delete();
        } else return false;

    }

    public function getSchedules($id)
    {
        $response = array();
        $providerSchedules = Schedule::where('serviceProviderId', $id)->orderBy('availableDate', 'asc')->get();
        if ($providerSchedules) {
            foreach ($providerSchedules as $single) {
                $response[$single->availableDate] = Schedule::where('availableDate', $single->availableDate)
                    ->where('serviceProviderId', $id)
                    ->select(['timeStart', 'isActive', 'isGap'])
                    ->orderBy('timeStart', 'asc')
                    ->get();

            }
        }
        $providerName = ServiceProvider::where('id', $id)->select('name')->first()->name;

        return view('admin.Provider.showSchedules', compact('response', 'providerName', 'id'));
    }

    public function deleteSchedules(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            DB::table('schedules')
                ->where('availableDate', $request->availableDate)
                ->where('serviceProviderId', $request->id)
                ->delete();
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
