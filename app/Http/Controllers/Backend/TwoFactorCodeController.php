<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCodeNotification;

class TwoFactorCodeController extends Controller
{

    public function __construct(){
        $this->middleware(['auth','twoFactor']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.twoFactor');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
         'two_factor_code' => ['required','integer']
        ]);
        $user = auth()->user();
        if($request->input('two_factor_code') == $user->two_factor_code){
            $user->resetTwoFactorCode();
            return redirect("/admin");
        }
        return redirect()->back()->withErrors(['two_factor_code'=>'The Two factor code you have entered dones not match.']);
    }

    public function resend(){
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCodeNotification());
        return redirect()->back()->with('status','The two factor code have been sent again.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
