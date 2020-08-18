@extends('layouts.app')

@section('content')
<div>
    <productos_component></productos_component>
    <br />
    <prime_component></prime_component>
    <br />
    <bootstrap_component></bootstrap_component>
    <br>
    <vuetify_component></vuetify_component>
    <br>
    {{-- <tareas_component></tareas_component> --}}
</div>
@endsection
