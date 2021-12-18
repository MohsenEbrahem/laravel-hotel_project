<?php

namespace App\Http\Controllers;
require 'vendor/autoload.php';
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Resources\RoomResource;
use App\room;
use App\reservation;
use  App\Exceptions\NotFoundrecord;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\RoomRequest;


class roomController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(['message'=>'all rooms','data'=>RoomResource::collection(Room::all())],Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       /* Room::create([
            'roomType'=>'single'
        ]);*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(RoomRequest $request)
    {
        $room=new Room($request->all());
        $room->save();
        return response(['messaage'=>'created','data'=>new RoomResource($room)],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room=roomController::checkRoomIfFoundOrNo($id);
        return response(['message'=>'room','data'=>new RoomResource($room)],Response::HTTP_OK);
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
    public function update(RoomRequest $request, $id)
    {
        $room=roomController::checkRoomIfFoundOrNo($id);
        $room->update($request->all());
        return response(['messaage'=>'updated','data'=>new RoomResource($room)],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room=roomController::checkRoomIfFoundOrNo($id);
        $room->delete();
        return response(['messaage'=>'deleted','data'=>null],Response::HTTP_NO_CONTENT);
    }




    /*
    this function check if room reserved now or no
    */
    public function checkIfThisRoomReservedNowOrNO($roomNumber){
        $reservations=reservation::all()->where('roomNumber','=',$roomNumber);
        foreach($reservations as $reservation)
            if (roomController::checkCurrentRoomReservation($reservation))return response(['message'=>'NOTAVAILABLENOW'],Response::HTTP_NOT_FOUND);
        return response(['message'=>'AVAILABLENOW'],Response::HTTP_FOUND);
    }

    
    private function checkCurrentRoomReservation($reservation){
        $currentDate=now();
        return (Carbon::parse($reservation->incomeDate)<=$currentDate & Carbon::parse($reservation->exitDate)>=$currentDate);
    }



    /*
      this function check if this record found or no and throw exception if not found
    */
    private function checkRoomIfFoundOrNo($roomId){
        if(count($room=room::find($roomId))==0)
            throw new NotFoundRecord;
        return $room;
    }

    
}
