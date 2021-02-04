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

                    if(Carbon::parse( $hasHook->timestamp )->diffInMinutes()>=60){
                        $tempoHora = str_replace(['há '],'',Carbon::parse( $hasHook->timestamp )  ->diffInHours());
                        $tempoMin = str_replace(['há '],'',Carbon::parse( $hasHook->timestamp ) ->addHour( (int) $tempoHora )->diffInMinutes());

                        if($tempoHora==1 && $tempoMin==1){
                            $tempo = $tempoHora.' hora e '.$tempoMin.' minuto'; // karai
                        }elseif($tempoHora==1 && $tempoMin>=2){
                            $tempo = $tempoHora.' hora e '.$tempoMin.' minutos';
                        }elseif( $tempoMin==1){
                            $tempo = $tempoHora.' horas e '.$tempoMin.' minuto';
                        }else{
                            $tempo = $tempoHora.' horas e '.$tempoMin.' minutos';
                        }

                    }else{
                        $tempo = str_replace('há ','',Carbon::parse( $hasHook->timestamp )->diffForHumans());
                    }

                    $message  = date('d/m/Y').' - '.date('H:i') . ' - 🎉 ' .$hasHook->actual_map.' terminou com '.$tempo.' de jogo.';

                    $this->sendMessage($hasHook['endpoint'] , [
                        'username' => env('APP_NAME'),
                        'content' => $message
                    ]);
                }

                DiscrodHooks::where('id',$hasHook->id)->update([
                    'actual_map'=>$this->mapname,
                    'timestamp'=>Carbon::now()
                ]);

                $game_mode = str_replace('gpm_','',$this->gametype);

                if($game_mode=="cq"){
                    $icon = '⛳';
                    $game_mode='aas';
                }elseif($game_mode=="insurgency"){
                    $icon = '💣';
                }elseif($game_mode=="vehicles"){
                    $game_mode='Vehicle Warfare';
                    $icon = '⚠';
                }elseif($game_mode=="skirmish"){
                    $game_mode='skirmish';
                    $icon = '🪖';
                }else{
                    $icon = '🎖️';
                }

                $message =  date('d/m/Y').' - '.date('H:i') . ' - ⚔ ' .$this->mapname . ' '.$icon.' ' . strtoupper($game_mode) . ' ' . $this->size_names[$this->mapsize] . '  ('.$this->numplayers.'/'.$this->maxplayers.')';

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
