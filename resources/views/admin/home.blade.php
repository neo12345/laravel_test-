@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    Email sent!
                    <a href="{{ url('/admin/logout') }}"><h3>Logout</h3></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
