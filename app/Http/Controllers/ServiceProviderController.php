<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ServiceProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $companies =  Company::pluck('name','id')->toArray();
        $data = array();
        $data = ServiceProvider::paginate(5);
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
                $ah = asset($nn);
                // $item->providerImage = $ah;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ServiceProvider $serviceProvider
     * @return \Illuminate\Http\Response
     */
    public function show(ServiceProvider $serviceProvider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ServiceProvider $serviceProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(ServiceProvider $serviceProvider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ServiceProvider $serviceProvider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServiceProvider $serviceProvider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ServiceProvider $serviceProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $provider = ServiceProvider::find($id);
        $provider->delete();
        return $provider;
    }

    public function providerByService(Request $request)
    {
        $data = array();
        $data = ServiceProvider::paginate(5);
        $services = Service::all();
        $company = Company::all();

        $serviceId = $request->serviceId;
        if ($serviceId != "") {
            $data = DB::table('providers')->join('providerservices', 'providers.id', '=', 'providerservices.provider_id')
                ->where('providerservices.service_id', '=', $serviceId)->get();
        }

        return view('admin.Provider.provider', ['data' => $data, 'services' => $services, 'company' => $company]);
    }
}
