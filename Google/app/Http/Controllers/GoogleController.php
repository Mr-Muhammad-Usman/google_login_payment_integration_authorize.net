<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;

class GoogleController extends Controller
{
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function getGoogleData()
    {
        $data=Socialite::driver('google')->stateless()->user();
        $user=User::where('google_id',$data->id)->first();
        if ($user)
        {
            Auth::login($user);
//            return "Data Found login Sucessful";
            return redirect()->route('authorizePage');
        }
        else
        {
            $user=new User();
            $user->name=$data->name;
            $user->email=$data->email;
            $user->google_id=$data->id;
            $user->save();
            Auth::login($user);
//            return "Data Not Found login Sucessful";
            return redirect()->route('authorizePage');
        }
    }



    public function redirectToInstagramProvider()
    {
        $appId = config('services.instagram.client_id');
        $redirectUri = urlencode(config('services.instagram.redirect'));
        return redirect()->to("https://api.instagram.com/oauth/authorize?app_id={$appId}&redirect_uri={$redirectUri}&scope=user_profile,user_media&response_type=code");
    }

    public function instagramProviderCallback(Request $request)
    {
        $code = $request->code;
        if (empty($code)) return redirect()->route('home')->with('error', 'Failed to login with Instagram.');

        $appId = config('services.instagram.client_id');
        $secret = config('services.instagram.client_secret');
        $redirectUri = config('services.instagram.redirect');

        $client = new Client();

        // Get access token
        $response = $client->request('POST', 'https://api.instagram.com/oauth/access_token', [
            'form_params' => [
                'app_id' => $appId,
                'app_secret' => $secret,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
                'code' => $code,
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            return redirect()->route('home')->with('error', 'Unauthorized login to Instagram.');
        }

        $content = $response->getBody()->getContents();
        $content = json_decode($content);

        $accessToken = $content->access_token;
        $userId = $content->user_id;

        // Get user info
        $response = $client->request('GET', "https://graph.instagram.com/me?fields=id,username,account_type&access_token={$accessToken}");

        $content = $response->getBody()->getContents();
        $oAuth = json_decode($content);

        // Get instagram user name
        $username = $oAuth->username;

        // do your code here
    }
    public function index()
    {
        return view('Login');
    }
}
