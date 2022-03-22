<?php namespace App\Providers;

use App\Validations\ValidacionesPersonalizadas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider {

    public function boot()
    {
        Validator::resolver(function($translator, $data, $rules, $messages){
            return new ValidacionesPersonalizadas($translator, $data, $rules, $messages);
        });
    }

    public function register()
    {
        //
    }
}
