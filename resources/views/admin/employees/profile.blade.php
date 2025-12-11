@extends('layouts.app')

@section('title', $employee->name . ' - Profile')

@section('page-title', $employee->name . ' - Profile')

@section('content')
    @include('admin.partials.profile_details', ['employee' => $employee])
@endsection

