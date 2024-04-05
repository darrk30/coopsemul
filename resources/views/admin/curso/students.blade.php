@extends('adminlte::page')
@section('title', 'Dashboard | Coopsemul')

@section('content_header')
    <x-breadcrumb-curso :curso="$curso">
    </x-breadcrumb-curso>
@stop

@section('content')
    @livewire('admin.curso.cursos-estudiantes', ['curso' => $curso])
@stop
