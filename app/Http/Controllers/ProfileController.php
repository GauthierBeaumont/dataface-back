<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use DB;

class ProfileController extends Controller
{

    protected $user;

    public function __construct(User $user){
      $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $user = $this->user->join('roles', 'users.role_id', '=', 'roles.id')
      ->join('coordinates', 'users.coordinate_id', '=', 'coordinates.id')
      ->select('*')->where('users.id', '=', $id)->first();
      return json_encode($user, JSON_UNESCAPED_UNICODE);
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
      $coordinateId = $this->user->select('coordinate_id')->where('users.id', '=', $id)->first();

      //$coordinateStatus = DB::table('coordinates')->where('coordinates.id', '=', $coordinateId['coordinate_id'])->delete();
      $userStatus = $this->user->where('users.id', '=', $id)->delete();
      return ['status' => ($userStatus)];
    }
}
