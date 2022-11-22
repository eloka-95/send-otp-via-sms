<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use illuminate\Support\Facades\DB;
use Exception;
use Twilio\Rest\Client;
class otpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userData = auth()->user();
        // dd($userData->otp);
   
        $receiverNumber = $userData->phone;
        $message = $userData->otp;
  
        try {
  
            $account_sid = getenv("TWILO_SID");
            $auth_token = getenv("TWILO_TOKEN");
            $twilio_number = getenv("TWILO_FROM");
  
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);
  
            // dd('SMS Sent Successfully.');
  
        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }
    
        
       
        return view('otp.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('welcome');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data = user::orderBy('id', 'Desc')->get();//geting user info from users table 
        
        $this->validate($request,[
            'sentotp' => 'required|min:6|max:6',
        ]);// validating OTP

        $otpData = $request->all();// grabing otp 
        $newOtp =  random_int(100000, 999999);
        
        $verifyOtp = User::where('otp', '=', $otpData['sentotp'])->update(['otp' => $newOtp]);
        // dd($verifyOtp);
        if($verifyOtp ==true){
            $updateOtp=  User::where('otp', '=', $otpData['sentotp'])->update(['otp' => $newOtp]);
            return redirect()->route('otp.create');  

        }else{
            return redirect()->back()->with('error', 'wrong Otp');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
