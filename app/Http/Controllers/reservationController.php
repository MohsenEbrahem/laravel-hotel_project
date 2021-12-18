<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Reservation;
use App\room;
use App\Http\Resources\ReservationResource;
use  App\Exceptions\NotFoundrecord;
use Symfony\Component\HttpFoundation\Response;


class reservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(['message'=>'reservations','data'=>ReservationResource::collection(Reservation::all())],Response::HTTP_OK);
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
        $reservation =new Reservation($request->all());
        $reservation->save();
        return response(['message'=>'created','data'=>new ReservationResource($reservation)],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation=reservationController::checkGuestIfFoundOrNo($id);
        return response(['message'=>'reservation','data'=>new ReservationResource($reservation)],Response::HTTP_OK);
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
        $reservation=reservationController::checkGuestIfFoundOrNo($id);
        $reservation->update($request->all());
        return response(['message'=>'updated','data'=>new ReservationResource($reservation)],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation=reservationController::checkGuestIfFoundOrNo($id);
        $reservation->delete();
        return response(['message'=>'deleted','data'=>null],Response::HTTP_NO_CONTENT);
    }



    /*
      this function check if this record found or no and throw exception if not found
    */
    private function checkGuestIfFoundOrNo($reservationId){
        if(count($reservation=reservation::find($reservationId))==0)
            throw new NotFoundRecord;
        return $reservation;
    }

}
