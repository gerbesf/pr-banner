@extends('admin.template')
@section('main')

    <div class="row">
        <div class="col-md-6">

            @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach

            <div class="card card-body">

                <form action="/auth" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="E-mail">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-dark">Log in</button>
                    </div>
                </form>

            </div>

        </div>
    </div>

@endsection
