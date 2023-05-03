<?php 

namespace App\Http\Clients;

use GuzzleHttp\Client;

class ReqresApiClient
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function login($email, $password)
    {
        $response = $this->client->request('POST', config('app.reqres_api_url') . config('app.reqres_login_endpoint'), [
            'json' => [
                'email' => $email,
                'password' => $password,
            ],
        ]);

        return json_decode($response->getBody()->getContents());
    }
}

?>