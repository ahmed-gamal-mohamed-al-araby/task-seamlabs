<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Auth;
class AllController extends Controller
{

    public function countNumber(Request  $request)
    {
        $start = $request->start;
        $end = $request->end;
        $data = [];
        for ($start ; $end >= $start ; $start++) {
            $arrOFNumber =  str_split($start);
            if(!in_array('5',$arrOFNumber)) {
                $data [] =  $start;
            }
        }
        return response()->json([
           'list' => $data,
           'count' => count($data)
        ]);
    }

    public function indexString(Request $request)
    {
        $input_string = $request->input_string;
        function getrange($min,$max){
            $upper = strtoupper($min);
            $output = array();
            while(positional($upper,strtoupper($max))<=0){
                array_push($output,$upper);
                $upper++;
            }
            return $output;
        }

        function positional($a,$b){
            $a1 = stringtointvalue($a); $b1 = stringtointvalue($b);
            if ($a1 > $b1)
                return 1;
            else if ($a1 < $b1)
                return -1 ;
            else
                return 0;
        }

        function stringtointvalue($str){
            $amount=0;
            $arra = array_reverse(str_split($str));

            for($i=0; $i <strlen($str); $i++){
                $amount +=(ord($arra[$i])-64)*pow(26,$i);
            }
            return $amount;
        }
        $array = getrange('A',$input_string);
        return response()->json([
            'count' => count($array)
        ]);
    }

    public function countMinimumSteps(Request $request) {

         function count($num)
        {
            $count = 0;
            $steps = [$num];
            $data = [];
            while ($num > 0)
            {
                if ($num % 2 == 0)
                    $num /= 2;
                else
                    $num--;

                $steps[]= $num;
                $count++;
            }

            $data['steps'] = $steps;
            $data['count'] = $count;
            return $data;
        }
        $array =  array_map(function () {
            return rand(0, 100);
        }, array_fill(0, $request->number, null));
         $response = [];
        foreach ($array as $s) {
            $response [] = count($s);
        }
        return response()->json([
            'steps' => $response
        ]);
    }

    public function login(Request $request)
    {
        // ( exist request validation ) but i used this for shortage of time ( php artisna make:request LoginRequester )
        try {
            $rules = [
                'username' => 'required',
                'password' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
            }
            $credentials = $request->only(['username', 'password']);
            $token = Auth::attempt($credentials);
            if (!$token) {
                return response()->json([
                    'message' =>  ' بيانات الدخول غير صحيحه'
                ]);
            }
            $user = Auth::user();
            $user->token = $token;
            return response()->json([
                'user' => $user,
                'message' =>  ' تم تسجيل الدخول بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'some thing wrong']);
        }

    }

    public function Register(Request $request)
    {
        try {
            $rules = [
                'username' => 'required',
                'phone' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'date_of_birth' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
        //Request is valid, create new user
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }
        $userId = User::insertGetId([
            'username' => $request->username,
            'phone' => $request->phone ,
            'email' => $request->email ,
            'date_of_birth' => $request->date_of_birth,
            'password' => bcrypt($request->password)
        ]);
        $user = User::find($userId);
        if ($user) {
            $token = Auth::attempt(['username' => $request->username, 'password' => $request->password]);
            $user->token = $token;
            //User created, return success response
            return response()->json([
                'Message' => "login_success",
                'user' => $user,
            ]);
        }
        } catch (\Exception $e) {
            return $e;
            return response()->json(['error' => 'some thing wrong']);
        }
    }

    public function showUser(Request $request)
    {
        try {
            $rules = [
                'id' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
            }
            $user = User::find($request->id);
            if (!$user)
                return response()->json(['status' => 401, 'msg' => 'User Not Found']);

            return response()->json([
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'some thing wrong']);
        }

    }

    public function allUser()
    {
        try {
           $users = User::all();

            return response()->json([
                'user' => $users,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'some thing wrong']);
        }
    }

    public function updateUser(Request  $request)
    {
        try {
            $rules = [
                'username' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'date_of_birth' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
            }
            $id = Auth::user()->id;
            $user = User::find($id);
            if (!$user)
                return response()->json(['status' => 401, 'msg' => 'User Not Found']);
            $user->update([
               'username' => $request->username  ,
               'phone' => $request->phone ,
               'email' => $request->email ,
                'date_of_birth' => $request->date_of_birth
            ]);

            return response()->json([
                'user' => $user,
                'Message' => "User Update Information"
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'some thing wrong']);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            return response()->json([
                'success' => 200,
                'message' => 'User has been logged out'
            ]);
         } catch (\Exception $e) {
             return response()->json(['error' => 'some thing wrong']);
         }
    }
}
