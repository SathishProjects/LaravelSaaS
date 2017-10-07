@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-{{ session('status') }}">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-default">
                            <div class="panel-heading">Initial Setup</div>
                            <div class="panel-body">
                                <p>
                                    <a href="{{ route('createdb') }}">Create Fresh DB</a>
                                </p>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="panel panel-default">
                            <div class="panel-heading">Initial Setup</div>
                            <div class="panel-body">
                                <p>
                                    <a href="{{ route('migratedb') }}">Migrate DB</a>
                                </p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
