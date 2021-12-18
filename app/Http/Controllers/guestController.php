<?php

namespace App\Http\Controllers;
require 'vendor/autoload.php';
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\guest;
use App\reservation;
use App\Http\Resources\GuestResource;
use  App\Exceptions\NotFoundrecord;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\GuestRequest;


class guestController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return response(['message'=>'all guests','data'=>GuestResource::collection(Guest::all())],Response::HTTP_OK);
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
    public function store(GuestRequest $request)
    {
        $guest=new Guest($request->all());
        $guest->save();
        return response(['message'=>'created','data' => new GuestResource($guest)],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guest=guestController::checkGuestIfFoundOrNo($id);
        return response(['message'=>'guest','data'=>new GuestResource($guest)],Response::HTTP_OK);
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
    public function update(GuestRequest $request, $id)
    {
        $guest=guestController::checkGuestIfFoundOrNo($id);
        $guest->update($request->all());
        return response(['message'=>'updated','data' => new GuestResource($guest)],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guest=guestController::checkGuestIfFoundOrNo($id);
        $guest->delete();
        return response(['message'=>'deleted','data'=>null],Response::HTTP_NO_CONTENT);
    }

    
    /*
    this function check if this guest found in hotel now or no
    */
    public function checkIfThisGuestInhotelNow($guestNumber){
        $reservedRooms=reservation::all()->where('guestNumber','=',$guestNumber);
        foreach($reservedRooms as $room)
            if (guestController::checkReservationDateOfThisGuest($room))return response(['message'=>'FOUNDGUEST'],Response::HTTP_FOUND);
        return response(['message'=>'NOTFOUNDGUEST'],Response::HTTP_NOT_FOUND);
    }
    
    private function checkReservationDateOfThisGuest($reservedRoom){
        $currentDate=now();
        return (Carbon::parse($reservedRoom->incomeDate)<=$currentDate & Carbon::parse($reservedRoom->exitDate)>=$currentDate);
    }


    /*
    this function search about any guests by name
    */
    public function searchingForGuestByName($name){
      // $guests=Guest::all()->where('firstName','like','%'.$name.'%');
      $guests=Guest::all()->where('firstName',$name);
     return response(['message'=>'FOUND','data'=>GuestResource::collection($guests)],Response::HTTP_OK);
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
