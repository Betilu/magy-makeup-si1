@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card" style="border:none; border-radius:15px; box-shadow: 0 4px 6px rgba(0,0,0,0.06);">
        <div class="card-header" style="background: linear-gradient(135deg, #662d91 0%, #662a5b 100%); color:white; border-radius:15px 15px 0 0; padding:1.25rem;">
            <h4 class="mb-0" style="font-weight:600;">
                <svg class="icon me-2" style="width:20px; height:20px;"><use xlink:href="{{ asset('icons/coreui.svg#cil-plus') }}"></use></svg>
                Crear Servicio
            </h4>
        </div>
        <div class="card-body" style="padding:1.5rem;">
            <form action="{{ route('servicios.store') }}" method="post">
                @include('servicios._form')
                <div class="mt-3">
                    <a href="{{ route('servicios.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn text-white" style="background-color:#662a5b;">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
