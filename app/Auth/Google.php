<?php
namespace App\Auth;

use League\OAuth2\Client\Provider\Google as LeagueGoogle;

class Google
{
    public static function createProvider()
    {
        return new LeagueGoogle([
            'clientId'     => env('GOOGLE_CLIENT_ID'),
            'clientSecret' => env('GOOGLE_CLIENT_SECRET'),
            'redirectUri'  => env('APP_URL') . '/auth/callback',
            'hostedDomain' => env('APP_URL'),
            'scopes' => 'profile',
        ]);
    }

    public static function getProfile($provider, $token)
    {
        $url = 'https://www.googleapis.com/oauth2/v3/userinfo';
        $request = $provider->getAuthenticatedRequest(LeagueGoogle::METHOD_GET, $url, $token);
        $response = $provider->getParsedResponse($request);
        if (false === is_array($response)) {
            throw new UnexpectedValueException(
                'Invalid response received from Authorization Server. Expected JSON.'
            );
        }
        return $response;
    }
}
