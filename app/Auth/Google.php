<?php
namespace App\Auth;

use Google_Client;
use Google_Service_Oauth2;

class Google
{
    public static function createClient()
    {
        return new Google_Client([
            'client_id'     => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect_uri'  => env('APP_URL') . '/auth/callback',
        ]);
    }

    public static function getLoginUrl()
    {
        $client = self::createClient();
        return $client->createAuthUrl('profile');
    }

    public static function getProfile($client, $token)
    {
        $oauth2 = new Google_Service_Oauth2($client);
        $profile = $oauth2->userinfo->get();
        return $profile;
    }
}
