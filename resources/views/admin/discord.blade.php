@extends('admin.template')
@section('main')

    @if($hook)
        <div class="card card-body mb-5">

            <b>Actual endpoint</b>
            <div>
                {{ $hook->endpoint }}
            </div>

        </div>
    @endif
    <div class="card card-body mb-5">
        <form action="{{ route('discord_store',[$server->id]) }}" method="post">
            @csrf
            <p>Configure ne Discord Hook</p>
            <label>Discord Hook Endpoint</label>
            <input type="text" name="endpoint" class="form-control" placeholder="URL to hook">
            {{--  <div>
                  <code>https://discordapp.com/api/webhooks/804453245057368064/ZPj0xQ2nU2wODfH-ap1IdX88d-zPOMg_RmUHv3OYsmbvU7HppvyY2rl6mdi4W5A2EgKT</code>
              </div>--}}
            <div class="py-3">
                <button class="btn btn-primary">Save</button>
            </div>
        </form>

    </div>
@endsection
