@extends('admin.layout')
@section('title', 'تعديل فرع')
@section('page-title', 'تعديل: ' . $branch->name)
@section('content')
@include('admin.branches.form', ['branch' => $branch])
@endsection
