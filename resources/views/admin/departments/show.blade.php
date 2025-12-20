@extends('layouts.app')

@section('title', $department->name . ' - Department Details')

@section('page-title', $department->name . ' - Department Details')

@section('content')
    @include('admin.partials.department_details', ['department' => $department])
@endsection