<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Nationality;
use App\guest;
use App\Http\Resources\nationalityResource;
use App\Http\Requests\NationalityRequest;
use Symfony\Component\HttpFoundation\Response;



class guestNationalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return response(['message'=>'All nationalities','data'=>NationalityResource::collection(Nationality::all()->where('nationalityOwner','=',$id))],Response::HTTP_OK);
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
    public function store(NationalityRequest $request,$guestId)
    {
        $guest=guestNationalityController::checkGuestIfFoundOrNo($guestId);
        $guest->nationalities()->create($request->all());
        return response(['message'=>'created','data'=>new NationalityResource(nationality::all()->where('nationalityOwner','=',$guestId)->last())],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($guestId,$nationalityId)
    {
        return response(['message'=>'nationality','data'=>Nationality::all()->where('nationalityOwner','=',$guestId)->where('id','=',$nationalityId)],Response::HTTP_OK);
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
    public function update(NationalityRequest $request, $guestId, $nationalityId)
    {
        $nationality=Nationality::find($nationalityId);
        $nationality->update($request->all());
        return response(['message'=>'updated','data'=>new NationalityResource($nationality)],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($guestId, $nationalityId)
    {
        $nationality=Nationality::find($nationalityId);
        $nationality->delete();
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
