<?php

namespace App\Http\Controllers;

use App\Models\DiscrodHooks;
use App\Models\Server;
use Illuminate\Http\Request;

class DiscordController extends Controller
{
    public function dashboard($id, Server $server ){

        $hook = DiscrodHooks::first();
       # dd($hook);
        return view('admin.discord',[
            'server' => $server->where('id',$id)->firstOrFail(),
            'hook'=>$hook
        ]);
    }

    public function store_hook(  $id, Request $request ){

        DiscrodHooks::where([])->delete();

        $vetor = [
            'server_id' => $id,
            'endpoint' => $request->get('endpoint'),
        ];

        $object = DiscrodHooks::firstOrCreate($vetor);


        DiscrodHooks::where('id',$object->id)->update([
            'status'=>'active'
        ]);

        return redirect(route('admin'));

    }

}
