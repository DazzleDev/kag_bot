<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    // use HasFactory;
    protected $url = "http://10.0.35.8/user/login_auth";

	public function __construct()
	{ 
		parent::__construct();
		
	}
	public function send_post($data)
	{
		//$request = new HTTPRequest($this->url, HTTP_METH_POST);
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
}
