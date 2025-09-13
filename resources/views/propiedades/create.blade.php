@extends('layout')

@section('title', 'Crear Nueva Propiedad - Bienes Raices')

@section('contenido')

<div class="section">
    <div class="contenedor">
        <div class="formulario formulario--property">
            <div class="formulario__header">
                <h1>Crear Nueva Propiedad</h1>
                <p>Complete la información para agregar una nueva propiedad al catálogo</p>
            </div>
            
            <div class="formulario__actions" style="margin-bottom: 2rem;">
                @if(Auth::guard('seller')->check())
                    <a href="{{ route('seller.dashboard') }}" class="btn btn--outline-primary">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Volver al Dashboard
                    </a>
                @else
                    <a href="{{ route('admin') }}" class="btn btn--outline-primary">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Volver al Panel Admin
                    </a>
                @endif
            </div>
            
            <form action="{{ Auth::guard('seller')->check() ? route('seller.properties.store') : route('admin.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-formulario-propiedad />
                
                <div class="formulario__actions">
                    <button type="submit" class="btn btn--accent btn--lg">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Crear Propiedad
                    </button>
                    <button type="reset" class="btn btn--outline-secondary">
                        <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Limpiar Formulario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
