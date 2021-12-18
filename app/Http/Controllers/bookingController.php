<?php

namespace App\Http\Controllers;
require 'vendor/autoload.php';
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\reservation;
use App\room;
use App\Http\Controllers\reservationController;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\BookingRequest;


class bookingController extends Controller
{

    private const NOTFOUNDROOM=-1;


    /*
    order room
    */
    public function orderAnAvailableRoom(BookingRequest $request){
        if(($request->roomNumber=bookingController::checkIfThisOrderAvailable($request->roomType ,$request->requiredIncomeDate,$request->requiredExitDate))>=0)   
            return response(['message'=>'Founded room ','data'=>$request->roomNumber],Response::HTTP_FOUND);
        return response(['message'=>'This room Not Found','data'=>null],Response::HTTP_NOT_FOUND);
    }


    
    /*
    check if required room is available or no
    */
    private function checkIfThisOrderAvailable($requiredRoomType ,$requiredIncomeDate,$requiredExitDate){
        foreach(room::all()->where('roomType','=',$requiredRoomType) as $room)
            if(($availableRoomNumber=bookingController::checkIfThisRoomCanBeReserved($room->id,$requiredIncomeDate,$requiredExitDate))>=0)return $availableRoomNumber;
        return bookingController::NOTFOUNDROOM;
    }


    /*
    check if specific room can reserved or no
    */
    private function checkIfThisRoomCanBeReserved($roomNumber,$requiredIncomeDate,$requiredExitDate){
        $reservation=reservation::all()->where('roomNumber','=',$roomNumber);
        if(count($reservation)==0)
            return $roomNumber;
        return bookingController::CheckIfTheReservationDatesForThisRoomConflictWithTheRequestedDate($reservation,$roomNumber,$requiredIncomeDate,$requiredExitDate);
    }



    /*
    check if this specific room already reserved in this date or no
    */
    private function CheckIfTheReservationDatesForThisRoomConflictWithTheRequestedDate($reservation,$roomNumber,$requiredIncomeDate,$requiredExitDate){
        $thisRoomCanBeReserved=true;
        foreach($reservation as $res)
            $thisRoomCanBeReserved=$thisRoomCanBeReserved & bookingController::checkIfThisDateConflictWithRequiredDate($res->incomeDate,$res->exitDate,$requiredIncomeDate,$requiredExitDate);
        if($thisRoomCanBeReserved)
            return $roomNumber;
        return bookingController::NOTFOUNDROOM;
    }



    /*
    check if date conflict with required date
    */
    private function checkIfThisDateConflictWithRequiredDate($reservedIncomeDate ,$reservedExitDate,$requiredIncomeDate,$requiredExitDate){
        return (! (Carbon::parse($requiredIncomeDate) >=Carbon::parse($reservedIncomeDate) & Carbon::parse($requiredIncomeDate)<= Carbon::parse($reservedExitDate)) )
            & ! (Carbon::parse($requiredExitDate) >= Carbon::parse($reservedIncomeDate) & Carbon::parse($requiredExitDate) <=Carbon::parse($reservedExitDate))
            & !(Carbon::parse($requiredExitDate)  >Carbon::parse($reservedExitDate) & Carbon::parse($requiredIncomeDate) <Carbon::parse($reservedIncomeDate));  
    }
}
