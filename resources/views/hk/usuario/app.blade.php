@extends('layouts.hk')

@section('content')
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ Request::segment(3) == '' ? 'active' : ''}}" href="{{ url('housekeeping/usuarios') }}">Usuários</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            @yield('content-app')
        </div>
    </div>
@endsection
