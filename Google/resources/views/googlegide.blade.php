after creating laravel project
step # 1
composer require laravel/socialite

Step # 2
past in config->app.app
'providers' => [
        Laravel\Socialite\SocialiteServiceProvider::class,
],


'aliases' => [
        'Socialite'=>Laravel\Socialite\Facades\Socialite::class,
]

Step # 3
        Create Client id
        https://console.cloud.google.com/apis/credentials?project=carbide-ward-358411&supportedpurview=project
Step # 4
Add in config->services.php
return[
    'google'=>[
    'client_id'=>'Enter your clint id',
    'client_secret'=>'Enter your clint secret',
    'redirect' => 'Enter your callback url'
    ],
]

Step # 5
Controller
use Laravel\Socialite\Facades\Socialite;

public function redirectGoogle()
{
return Socialite::driver('google')->redirect();
}
public function getGoogleData()
{
$data=Socialite::driver('google')->user();
$user=User::where('google_id',$data->id)->first();
if ($user)
{
Auth::login($user);
return "Data Found login Sucessful";
}
else
{
$user=new User();
$user->name=$data->name;
$user->email=$data->email;
$user->google_id=$data->id;
$user->save();
Auth::login($user);
return "Data Not Found login Sucessful";
}
}

Step # 6
Route
Route::get('/google',[GoogleController::class,'redirectGoogle'])->name('redirectGoogle');
Route::get('/google/callback',[GoogleController::class,'getGoogleData'])->name('getGoogleData');
