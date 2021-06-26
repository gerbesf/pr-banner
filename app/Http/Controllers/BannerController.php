<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\Discord;
use App\Http\Controllers\Helpers\Prspy;
use App\Models\DiscrodHooks;
use App\Models\Server;
use Spatie\Browsershot\Browsershot;

class BannerController extends Controller
{
    use Prspy;
    use Discord;

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

        if($this->offline==true){
            #$this->dispatchHookOffline();
            Browsershot::url(env('APP_URL').'/offline')    ->setScreenshotType('jpeg', 100)
                ->noSandbox()
                ->windowSize(800, 240)
                ->save('banner.jpg');
        }else{
            #$this->dispatchHook();

            try {
                file_get_contents(env('APP_URL').'/html');

                #dd($this);
                if($this->hostname){
                    #@unlink(public_path('banner.jpg'));
                    Browsershot::url(env('APP_URL').'/html')    ->setScreenshotType('jpeg', 100)
                        ->noSandbox()
                        ->windowSize(800, 240)
                        ->save('banner.jpg');
                }
            }catch (\Exception $exception){
                \Log::info( $exception->getMessage() );
                \Log::info( $exception->getTrace() );
            }


        }
        return view('welcome');

        #return '<img src="'.env('APP_URL').'/banner.jpg">';
    }

    public function offline(){
        return view('offline');
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
