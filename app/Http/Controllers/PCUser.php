<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PCUser extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::where('password', '!=', null)->paginate(5);
        $data->count = User::all()->count();
        return view('admin.User.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = new User();
            $user->fullName = $request->input('fullName');
            $user->email = $request->input('email');
            $user->mobile = $request->input('mobile');
            $user->password = bcrypt($request->input('password'));
            $user->save();
            return redirect()->back()->with('add', ' ');
        } else {
            return view('admin.Company.addCompany');
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $user = User::find($id);
            if ($request->has('password')) {
                $user->password = bcrypt($request->input(['password']));
            }
            $user->fullName = $request->input('fullName');
            $user->email = $request->input('email');
            $user->mobile = $request->input('mobile');
            $user->save();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return $user;
    }
}
