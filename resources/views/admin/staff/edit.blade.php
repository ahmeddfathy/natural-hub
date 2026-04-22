@extends('admin.layout')
@section('title', 'تعديل موظفة')
@section('page-title', 'تعديل: ' . $staff->name)
@section('content')
@include('admin.staff.form', ['staff' => $staff])
@endsection
