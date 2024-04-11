@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    
@stop

@section('content')
    @livewire('admin.ciclo.ciclo-estudiantes', ['ciclo' => $ciclo])
@stop
