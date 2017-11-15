<?php
namespace App\Auth;

use League\OAuth2\Client\Provider\Google as LeagueGoogle;

class Google
{
    public static function createProvider()
    {
        return new LeagueGoogle([
            'clientId'     => '126721452745-upva91988msbg60c3rcqv0v5elr62chb.apps.googleusercontent.com',
            'clientSecret' => 'B-XxWVx_Flh4jGqWApO4bJQN',
            'redirectUri'  => 'http://localhost:8000/auth/callback',
            'hostedDomain' => 'http://localhost:8000',
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