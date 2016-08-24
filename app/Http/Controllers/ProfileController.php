<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ProfileRequest;
use App\User;
use DB;
use Validator;
use Hash;

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
    public function show(ProfileRequest $request)
    {
      $id = $request->input('id');
      $user = $this->user->join('roles', 'users.role_id', '=', 'roles.id')
      ->join('coordinates', 'users.id', '=', 'coordinates.user_id')
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
    public function update(ProfileRequest $request)
    {
      $columns = ['id'];
      $changeUser = false;
      $changeCoord = false;
      $dataUser = $request->except(['_method', '_token']);
      $userPassword = DB::table('users')->where('id', $dataUser['id'])->select('password')->first();
      $oldUserData = DB::table('users')->where('id', $dataUser['id'])->select('*')->first();
      $oldCoordData = DB::table('coordinates')->where('user_id', $dataUser['id'])->select('*')->first();

      foreach ($oldUserData as $key => $value) {
        if(!in_array($key, $columns) && array_key_exists($key, $dataUser) && $dataUser[$key] !== $value) {
          if($key === 'password' && Hash::check($dataUser['password'],$userPassword->password)) {
            continue;
          }
          array_push($columns, $key);
          $changeUser = true;
        }
      }

      foreach ($oldCoordData as $key => $value) {
        if(!in_array($key, $columns) && array_key_exists($key, $dataUser) && $dataUser[$key] !== $value) {
          array_push($columns, $key);
          $changeCoord = true;
        }
      }

      $dataUser = $request->only($columns);

      if(array_key_exists('password', $dataUser) && $dataUser['password']) {
        $dataUser['password'] = bcrypt($dataUser['password']);
      }

      if(array_key_exists('email', $dataUser)) {
        $dataUser['email_valide'] = 0;
      }

      $dataCoordinate = $request->only(['address', 'country', 'phone', 'postal_code']);

      $user = DB::table('users')
          ->where('id', $dataUser['id'])
          ->update($dataUser);

      $coord = DB::table('coordinates')
        ->where('user_id', $dataUser['id'])
        ->update($dataCoordinate);

        if(!$changeUser && !$user) {
          $user = true;
        }
        if(!$changeCoord && !$coord) {
          $coord = true;
        }

        return ['status' => ($user && $coord)];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfileRequest $request)
    {
      $id = $request->input('id');
      $userStatus = $this->user->where('users.id', '=', $id)->delete();
      return ['status' => ($userStatus)];
    }
}
