@extends('admin.template')
@section('main')


    <div class="py-3">
            @foreach($servers as $server)

                <div class="card card-body mb-2">
                    {{-- <div class="float-right"><span>{{ $server->config->countryFlag }}</span></div>--}}
                    <div class="lead font-weight-bold"><b>{{ $server->properties->hostname }}</b></div>

                    <div class="row">
                        <div class="col-md-12">
                            <div>Actual MAP: <b>{{ $server->properties->mapname }}</b></div>
                        </div>
                        <div class="col-md-12">
                            <div>Players: <b><span>{{ $server->properties->numplayers }}</span> / <span>{{ $server->properties->maxplayers }}</span></b></div>
                        </div>
                        <div class="col-md-12">
                            <div>Server IP:<span>{{ $server->serverIp }}</span>:{{ $server->queryPort }}</div>
                        </div>
                        <div class="col-md-12">
                            <a href="/admin/configure?ip={{ $server->serverIp }}" class="btn btn-success btn-sm">Select This</a>
                        </div>
                    </div>
                </div>

            @endforeach
    </div>

@endsection
