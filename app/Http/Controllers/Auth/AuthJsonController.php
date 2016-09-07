<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Models\Coordinate;
use App\User;
use Validator;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;

// Surcharge de la classe AuthController pour prendre en charge les réponses JSON

class AuthJsonController extends AuthController
{
  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
      return Validator::make($data, [
          'lastName' => 'required|max:255',
          'firstName' => 'required|max:255',
          'address' => 'required|max:255',
          'country' => 'required|max:100',
          'phone' => 'required|max:30',
          'postalCode' => 'required|max:20',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6|confirmed',
      ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return User
   */
  protected function create(array $data)
  {
      // Création d'une coordonnée destinée à la foreign key User.coordinate_id
      $user = User::create([
          'lastname' => $data['lastName'],
          'firstname' => $data['firstName'],
          'email' => $data['email'],
          'role_id' => 2,
          'password' => bcrypt($data['password']),
      ]);

      Coordinate::create([
        'address' => $data['address'],
        'country' => $data['country'],
        'phone' => $data['phone'],
        'postal_code' => $data['postalCode'],
        'user_id' => $user['id'],
      ]);

      return $user;
  }

  public function handleUserWasAuthenticated(Request $request, $throttles)
  {
      if ($throttles) {
          $this->clearLoginAttempts($request);
      }

      if (method_exists($this, 'authenticated')) {

          return $this->authenticated($request, Auth::guard($this->getGuard())->user());
      }
      
      $user = User::findOrFail(Auth::user()->id)->join('roles', 'users.role_id', '=', 'roles.id')
      ->join('coordinates', 'users.id', '=', 'coordinates.user_id')
      ->select('*')->where('users.id', '=', Auth::user()->id)->first();

      return ['status' => 'success', 'userData' => $user];
  }

  protected function sendFailedLoginResponse(Request $request)
  {
    return ['status' => 'fail', 'errorMessage' => $this->getFailedLoginMessage()];
  }

  protected function sendLockoutResponse(Request $request)
  {
      $seconds = $this->secondsRemainingOnLockout($request);
      return ['status' => 'fail', 'errorMessage' => $this->getLockoutErrorMessage($seconds)];
  }
}
