<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\phone;
use App\guest;
use App\Http\Resources\PhoneResource;
use Symfony\Component\HttpFoundation\Response;
use  App\Exceptions\NotFoundrecord;
use App\Http\Requests\PhoneRequest;

class guestphoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
       return response(['message'=>'all phoneNumbers','data'=>PhoneResource::collection(Phone::all()->where('phoneNumberOwner','=',$id))],Response::HTTP_OK);
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
    public function store($guestId,PhoneRequest $request)
    {
        $guest=guestphoneController::checkGuestIfFoundOrNo($guestId);
        $guest->phones()->create($request->all());
        return response(['message'=>'created','data'=>new PhoneResource(Phone::all()->where('phoneNumberOwner','=',$guestId)->last())],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($guestId,$phoneNumberId)
    {
        return response(['message'=>'phoneNumber','data'=>Phone::all()->where('phoneNumberOwner','=',$guestId)->where('id','=',$phoneNumberId)],Response::HTTP_OK);
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
    public function update(PhoneRequest $request,$guestId,$phoneNumberId)
    {
        $phone=Phone::find($phoneNumberId);
        $phone->update($request->all());
        return response(['message'=>'updated','data'=>new PhoneResource($phone)],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($guestId,$phoneNumberId)
    {
        $phone=Phone::find($phoneNumberId);
        $phone->delete();
        return response(['message'=>'deleted','data'=>null],Response::HTTP_NO_CONTENT);
    }
    /*
      this function check if this record found or no and throw exception if not found
    */
    private function checkGuestIfFoundOrNo($guestId){
        if(count($guest=guest::find($guestId))==0)
            throw new NotFoundRecord;
        return $guest;
    }
}
