<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\Prspy;
use App\Models\Administrators;
use App\Models\DiscrodHooks;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use Prspy;

    public function __construct()
    {

    }

    public function login( Request $request ){
        return view('admin.login');
    }

    public function auth( Request $request ){

        $input_email = $request->email;
        $input_password = $request->password;

        try {
            $selectUser = Administrators::where('email',$input_email)->firstOrFail();
        }catch( \Exception $exception ){
            return redirect()->back()->withErrors('Auth Failed');
        }

        if( Hash::check( $input_password, $selectUser->password )){
            session()->put('logged',$selectUser->id);
            return redirect('/admin');
        }else{
            return redirect()->back()->withErrors('Auth Failed');
        }


        return redirect('/login');
    }

    public function logout(){
        session()->forget('logged');
        return redirect('/');
    }

    public function admin()
    {
        if( Server::count() == 0 ){
            return redirect('/admin/configure');
        }
        $server = Server::first();
        return view('admin.dashboard',[
            'server' => $server
        ]);
    }

    public function configure( Request $request ){


        $this->populateServers();

        // Set a New Server
        if($request->ip){
            foreach($this->servers as $server){

                if( $server->serverIp==$request->ip){

                    if( Server::count() == 0 ) {
                        Server::create([
                            'ip' => $server->serverIp,
                            'name' => $this->getServerName( $server),
                            'status' => 'active'
                        ]);
                    }else{
                        $ServerEntity = Server::first();
                        Server::where('id',$ServerEntity->id)->update([
                            'ip' => $server->serverIp,
                            'name' => $this->getServerName( $server),
                            'status' => 'active'
                        ]);
                    }

                    return redirect('/admin');
                }
            }
        }

        return view('admin.select_server',[
            'servers' => $this->servers
        ]);
    }


    public function getServerName( $server ){
        $hostname = $server->properties->hostname;
        $_ihostname = explode(' ',$hostname);
        unset($_ihostname[0]);
        unset($_ihostname[1]);
        $name = implode(' ',$_ihostname);
        return $name;
    }
}
