@extends('layouts.app')

@section('title', 'Employees')
@section('page-title', 'Employees')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection

@section('content')
    @include('admin.partials.employeelist')
@endsection
