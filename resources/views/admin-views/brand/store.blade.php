@extends('layouts.admin.app')
                @section('content')
@include('admin-views.brand.form',getFormInfo(isset($data)?true:false))
@endsection
