<?php

namespace App\Http\Controllers\Helpers;

use App\Models\DiscrodHooks;
use App\Models\Server;
use Carbon\Carbon;

trait Prspy{

    // Api Data
    private $uri = 'https://servers.realitymod.com';
    protected $servers = [];

    // Server Data
    protected $hostname = '';
    protected $gamever = '';
    protected $mapname = '';
    protected $gametype = '';
    protected $mapsize = '';
    protected $numplayers = '';
    protected $maxplayers = '';
    protected $flag_county = '';
    protected $offline = true;
    protected $failed = false;

    /**
     * Populate Servers
     */
    protected function populateServers() {
       # \Cache::forget('prspyx');
        $response = \Cache::remember('prspyx',60,function (){
            return \Ixudra\Curl\Facades\Curl::to($this->uri . '/api/ServerInfo')
                ->asJson()
                ->get();
        });


        if( isset($response->servers)){
            $this->servers = $response->servers;
            sort($this->servers);
        }else{
            $this->failed = true;
            dd($response);
        }
    }

    /**
     * Configure Server
     */
    protected function configureServer(){

        if($this->failed) {
            exit(0);
        }

        $activeServer = Server::first();
        foreach($this->servers as $server){

            if($server->serverId==$activeServer->ip){

                $this->offline = false;

                $gVer = explode('-',$server->properties->gamever);
                $this->hostname = substr($server->properties->hostname,14,99999);
                $this->gamever = $gVer[0];
                $this->mapname = $server->properties->mapname;
                $this->gametype = $server->properties->gametype;
                $this->mapsize = $server->properties->bf2_mapsize;
                $this->numplayers = $server->properties->numplayers;
                $this->maxplayers = $server->properties->maxplayers;
                $this->flag_county = @$server->countryFlag;


            }
        }

    }

}
