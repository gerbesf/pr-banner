<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\Prspy;
use App\Models\Server;
use Spatie\Browsershot\Browsershot;

class BannerController extends Controller
{
    use Prspy;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function proxy(){


        if( Server::count() == 0 ){
            echo 'Banner Not Configured';
            die();
        }

        $this->populateServers();
        $this->configureServer();

        if($this->hostname){
            #@unlink(public_path('banner.jpg')); 
            Browsershot::url(env('APP_URL').'/html')    ->setScreenshotType('jpeg', 100)
                ->noSandbox()
                ->windowSize(800, 240)
                ->save('banner.jpg');
        }

        return view('welcome');
        #return '<img src="'.env('APP_URL').'/banner.jpg">';
    }

    public function index(){

        $this->populateServers();
        $this->configureServer();

        return view('banner',[
            'hostname' => $this->hostname,
            'gamever' => $this->gamever,
            'mapname' => $this->mapname,
            'gametype' => $this->gametype,
            'mapsize' => $this->mapsize,
            'numplayers' => $this->numplayers,
            'maxplayers' => $this->maxplayers,
            'flag_county' => $this->flag_county,
        ]);
/*
        dd( [
            'hostname' => $this->hostname,
            'gamever' => $this->gamever,
            'mapname' => $this->mapname,
            'mapsize' => $this->mapsize,
            'numplayers' => $this->numplayers,
            'maxplayers' => $this->maxplayers,
            'flag_county' => $this->flag_county,
        ]);*/

    }
}
