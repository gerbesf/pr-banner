@extends('admin.template')
@section('main')

    <div class="py-2">
        <div class="card card-body">
            @if( $server->count() == 0 )
                No have server
            @else

                <div class="row">
                    <div class="col-md-4">
                        <div class="small text-uppercase text-white-50">Server Name</div>
                        <div>
                            {{ $server->name }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="small text-uppercase text-white-50">Target IP</div>
                        <div>
                            {{ $server->ip }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <a href="/logout" class="float-right">Logout</a>
    @if( $server->count() == 0 )
        <a href="/admin/configure">Configure a new server</a>
    @else
        <a href="/admin/configure">Change server</a>
    @endif

@endsection
