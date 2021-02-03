<?php

namespace App\Http\Controllers\Helpers;

use App\Models\DiscrodHooks;
use App\Models\Server;
use Carbon\Carbon;

trait Discord {

    protected $size_names = [
        '16' => 'Infantry',
        '32' => 'Alternative',
        '64' => 'Standard',
        '128' => 'Large',
    ];


    public function dispatchHookOffline(){

        // Hook Entity
        $hasHook = DiscrodHooks::first();

        // Server Entity
        $Server = Server::first();

        // Detecta Server Offline
        if( $Server->offline == null ){
            Server::where('id',$Server->id)->update([
                'offline' => Carbon::now()
            ]);
            if( isset($hasHook->id)){
                $this->sendMessage($hasHook['endpoint'], [
                    'username' => env('APP_NAME'),
                    'content' => date('d/m/Y').' - '.date('H:i') . ' - ' .'Oh 💩, Server is Offline'
                ]);
            }
        }
    }

    public function dispatchHook(){

        // Hook Entity
        $hasHook = DiscrodHooks::first();

        $hasHook = DiscrodHooks::first();

        // Server Entity
        $Server = Server::first();

        $offlined = false;

        // Come back from offline
        if($Server->offline){
            $this->sendMessage( $hasHook['endpoint'] , [
                'username' => env('APP_NAME'),
                'content' => date('d/m/Y').' - '.date('H:i') . ' - ' . '👨‍💻 Server Online!'
            ]);
            Server::where('id',$Server->id)->update([
                'offline' => null
            ]);

            $offlined = true;

        }

        // Detect Change Map
        if( isset($hasHook->id)){
            if( $hasHook->actual_map==null or  $hasHook->actual_map!=$this->mapname){

                if($offlined==false){
                    $tempo = str_replace('há ','',Carbon::parse( $hasHook->timestamp )->subMinutes(32)->diffForHumans());
                    $this->sendMessage($hasHook['endpoint'] , [
                        'username' => env('APP_NAME'),
                        'content' => date('d/m/Y').' - '.date('H:i') . ' - ' .$this->mapname.' terminou com '.$tempo.' de jogo.'
                    ]);
                }

                DiscrodHooks::where('id',$hasHook->id)->update([
                    'actual_map'=>$this->mapname,
                    'timestamp'=>Carbon::now()
                ]);
                $game_mode = str_replace('gpm_','',$this->gametype);

                if($game_mode=="cq"){
                    $game_mode='aas';
                    $icon = '⛳';
                }elseif($game_mode=="insurgency"){
                    $icon = '💣🍻';
                }else{
                    $icon = '🎖️';
                }

                $message =  date('d/m/Y').' - '.date('H:i') . ' - ' .$this->mapname . ' - ' . strtoupper($game_mode) . ' - ' . $this->size_names[$this->mapsize] . ' - Players: '.$this->numplayers.'/'.$this->maxplayers.'';
                $res = $this->sendMessage($hasHook['endpoint'] , [
                    'username' => env('APP_NAME'),
                    'content' => $message
                ]);
            }
        }

    }

    public function sendMessage(  $url ,$POST){
        $headers = [ 'Content-Type: application/json; charset=utf-8' ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($POST));
        return curl_exec($ch);
    }
}
