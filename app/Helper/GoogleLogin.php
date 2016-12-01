<?php

namespace App\Helper;

//use Illuminate\Support\Facades\Cache;
//use Illuminate\Support\Facades\Config;

use Config;
use GuzzleHttp;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class GoogleLogin
{
    protected $client;

	public function __construct(){

		$this->client = new GuzzleHttp\Client();

	}

    public function get_email($request)
    {

        $params = [
            'code' => $request->input('code'),
            'client_id' => $request->input('clientId'),
            'client_secret' => Config::get('google.client_secret'),
            'redirect_uri' => $request->input('redirectUri'),
            'grant_type' => 'authorization_code',
        ];
    	
        $accessTokenResponse = $this->client->request('POST', 'https://accounts.google.com/o/oauth2/token', [
            'form_params' => $params
        ]);

        $accessToken = json_decode($accessTokenResponse->getBody(), true);

        if(isset($accessToken['error'])){
            return false;
        }

        $profileResponse = $this->client->request('GET','https://www.googleapis.com/plus/v1/people/me/openIdConnect', [
            'headers' => array('Authorization' => 'Bearer ' . $accessToken['access_token'])
        ]);

        $profile = json_decode($profileResponse->getBody(),true);

        return $profile;

    }

}
