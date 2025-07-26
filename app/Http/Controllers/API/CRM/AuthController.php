<?php

namespace App\Http\Controllers\API\CRM;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Http;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
    //    echo "EN LOGIN CONTROLL";
        $success = false;
        $data = [];
        $message = 'Invalid credentials';

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $http = new \GuzzleHttp\Client;
        $credentials = $request->only('email', 'password');
  //      echo "credentials!";

        if (Auth::attempt($credentials)) {


            try {

/*                $response = $http->post(config('services.passport.login_endpoint'), [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => config('services.passport.client_id'),
                        'client_secret' => config('services.passport.client_secret'),
                        'username' => $request->email,
                        'password' => $request->password,
                    ]
                ]);*/
//                echo "credentials PASS";

                $user = User::find(Auth::user()->id);

                $user_token['token'] = $user->createToken('appToken')->accessToken;

/*                $user = User::select('users.id', 'name', 'email', 'image')
                    ->where('email', $request->email)
                    ->first();
*/
                $data['roles'] = $user->getRoleNames();
                $data['permissions'] = $user->getAllPermissions();

                $user = $user->toArray();

                $data['userData'] = $user;
                $user['userData']['username'] = explode('@', $user['email'])[0];
                $data['accessToken'] =    $user_token['token'];


            //    json_decode($response->getBody()->getContents())->access_token;

                foreach ($data['permissions'] as $permissions) {
                    $actionSubject = explode(' ', $permissions->name);
                    $data['userAbilities'][] = ['action' => $actionSubject[0], 'subject' => $actionSubject[1]];
                }

                $success = true;
                $message = 'User ' . $user['email'] . ' succes authenticated';

                activity()->log($message);

                return response()->json([
                    'data' => $data,
                    'success' => $success,
                    'message' => $message
                ]);
            } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                if ($e->getCode() === 400) {
                    $message = 'Invalid Request. Please enter a username or a password. ' . $e->getCode();
                    activity()->log($message);
                    return response()->json();
                } else if ($e->getCode() === 401) {
                    $message = 'Your credentials are incorrect. Please try again ' . $e->getCode();
                    activity()->log($message);
                    return response()->json($message);
                } else if ($e->getCode() === 404) {
                    $message = 'API EndPoint Not Found ' . $e->getCode();
                    activity()->log($message);
                    return response()->json($message);
                }

                $message = 'Something went wrong on the server.' . $e->getCode();
                activity()->log($message);

                $token = auth()->user()->createToken('API Token')->accessToken;
                $user = User::select('users.id', 'name', 'email', 'image')
                    ->where('email', $request->email)
                    ->first();

                $data['roles'] = $user->getRoleNames();
                $data['permissions'] = $user->getAllPermissions();

                $user = $user->toArray();


                $data['userData'] = $user;
                $user['userData']['username'] = explode('@', $user['email'])[0];
                $data['accessToken'] = $token;

                $message = 'User ' . $user['email'] . ' succes authenticated';


                foreach ($data['permissions'] as $permissions) {
                    $actionSubject = explode(' ', $permissions->name);
                    $data['userAbilities'][] = ['action' => $actionSubject[0], 'subject' => $actionSubject[1]];
                }

                    return response()->json([
                        'data' => $data,
                        'success' => true,
                        'message' => $message
                    ]);

                return response()->json($message);
            }
        } else {
            $message = 'Your credentials are incorrect. Please try again';
            activity()->log($message);

            return response()->json([
                'data' => '',
                'success' => false,
                'message' => $message
            ]);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        $message = 'Logged out successfully.';
        activity()->log($message);

        return response()->json($message, 200);
    }
}
