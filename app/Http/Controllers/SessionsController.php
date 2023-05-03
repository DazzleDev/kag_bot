<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SessionsController extends Controller
{    
    protected $url = "http://10.0.35.30/user/login_auth";
    public function create()
    {
        return view('session.login-session');
    }

    public function store(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $data = array(
            "username" => $username,
            "password" => $password,
            "application" => "Absensi Mobile",
            "type" => "json"
        );
        $cek = $this->login_kag($data);
        $jdcode = json_decode($cek['data']);
        if ($jdcode->status) {
            $a = $jdcode->nik;
            $userss = DB::table('EMPLOYEE')
                        ->join('DIVISION','EMPLOYEE.DIVISIONID','=','DIVISION.DIVISIONID')
                        ->where('EMPLOYEE.EMPLOYEEID','=',$a)
                        ->select('EMPLOYEE.EMNAME','DIVISION.DIVNAME','EMPLOYEE.DEPTID')
                        ->first();
            // $dataLogin = $this->auth->autt($a);
            // foreach ($dataLogin as $userss);
            date_default_timezone_set('Asia/Jakarta');

            $key = "peRkasa$%";
            $data_token = array(
                "nik" => $jdcode->nik,
                'nik' => $jdcode->nik,
                'nama' => $userss->EMNAME,
                'level' => $jdcode->result,
                'divisi' => $userss->DIVNAME,
                'id_dept' => $userss->DEPTID,
                'is_login' => true,
                'jam_login' => date('d-m-Y h:i:s')
            );
            //$jwt = JWT::encode($data_token, $key, 'HS256');
            //$this->auth_absenmobile($jdcode->nik, $userss->DEPTID);

            $sess_data = array(
                'status' => true,
                'nik' => $jdcode->nik,
                'nama' => $userss->EMNAME,
                'level' => $jdcode->result,
                'divisi' => $userss->DIVNAME,
                'id_dept' => $userss->DEPTID,
                'waktu' => date('Y-m-d H:i:s'),
                'hak_approve' => $this->cek_akses_approve($jdcode->nik),
                //'JWT' => $jwt
            );
            session($sess_data);
            //$this->response($sess_data, 200);
            return redirect('dashboard')->with(['success'=>'You are logged in.']);
        } else {
            //$this->response($jdcode, 404);
            return back()->withErrors(['email'=>'Email or password invalid.']);
        }
        // $attributes = request()->validate([
        //     'email'=>'required|email',
        //     'password'=>'required' 
        // ]);

        // if(Auth::attempt($attributes))
        // {
        //     session()->regenerate();
        //     return redirect('dashboard')->with(['success'=>'You are logged in.']);
        // }
        // else{

        //     return back()->withErrors(['email'=>'Email or password invalid.']);
        // }
    }
    function cek_akses_approve($nik){
        $hak_approve = FALSE;
        $approve_data = DB::table('jenis_approve_detail')
                        ->where('nik','=',$nik)
                        ->get();
        if(count($approve_data)>0){
            $hak_approve = TRUE;
        }
        return $hak_approve;
    }
    function login_kag($data){
        $ch = curl_init($this->url); 
		$postString = http_build_query($data, '', '&');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);
		// var_dump($response);die();
		if ($err) {
			return array("status"=>false, "data"=>$err);
		}else{
			return array("status"=>true, "data"=>$response);			
		}
    }
    public function destroy()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'You\'ve been logged out.']);
    }
    
}
