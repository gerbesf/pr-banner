<?php

namespace App\Http\Controllers\Helpers;

use App\Models\Server;

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

    /**
     * Populate Servers
     */
    protected function populateServers() {
        $response = \Cache::remember('prspy',60,function (){
            return \Ixudra\Curl\Facades\Curl::to($this->uri . '/api/ServerInfo')
                ->asJson()
                ->get();
        });
        $this->servers = $response->servers;
        sort($this->servers);
    }

    /**
     * Configure Server
     */
    protected function configureServer(){



        $activeServer = Server::first();
      #  dd(env('SERVER_IP'));
        foreach($this->servers as $server){

            if($server->serverIp==$activeServer->ip){

          #      dd($server);

                $gVer = explode('-',$server->properties->gamever);
                $this->hostname = substr($server->properties->hostname,14,99999);
                $this->gamever = $gVer[0];
                $this->mapname = $server->properties->mapname;
                $this->gametype = $server->properties->gametype;
                $this->mapsize = $server->properties->bf2_mapsize;
                $this->numplayers = $server->properties->numplayers;
                $this->maxplayers = $server->properties->maxplayers;
                $this->flag_county = $server->config->countryFlag;

            }
        }

    }
}
