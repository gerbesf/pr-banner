<?php

namespace App\Http\Controllers\Helpers;

use App\Models\DiscrodHooks;
use App\Models\Server;
use Carbon\Carbon;

trait Discord {

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
                    'content' => '💩 Server Is Offline'
                ]);
            }
        }
    }

    public function dispatchHook(){

        // Hook Entity
        $hasHook = DiscrodHooks::first();

        // Server Entity
        $Server = Server::first();

        // Come back from offline
        if($Server->offline){
            $this->sendMessage( $hasHook['endpoint'] , [
                'username' => env('APP_NAME'),
                'content' => '👨‍💻 Connection to the server is active'
            ]);
            Server::where('id',$Server->id)->update([
                'offline' => null
            ]);
        }

        // Detect Change Map
        if( isset($hasHook->id)){
            if( $hasHook->actual_map==null or  $hasHook->actual_map!=$this->mapname){
                DiscrodHooks::where('id',$hasHook->id)->update([
                    'actual_map'=>$this->mapname,
                    'timestamp'=>Carbon::now()
                ]);
                $game_mode = str_replace('gpm_','',$this->gametype);
                $message = '🪖 '.$this->mapname. ' - '.$game_mode.' - '.$this->mapsize.' - ('.$this->numplayers.'/'.$this->maxplayers.') ';
                $this->sendMessage( $hasHook['endpoint'] , [
                    'username' => env('APP_NAME'),
                    'content' => $message
                ]);
            }
        }

    }

    public function sendMessage( $url ,$POST){
        $headers = [ 'Content-Type: application/json; charset=utf-8' ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($POST));
        $response   = curl_exec($ch);
    }
}
