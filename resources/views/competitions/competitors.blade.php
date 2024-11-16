@extends('layouts.main')
@section('content')
<!-- Content Header (Page header) -->
<competitors-index
    :competition="{{$competition}}"
    :coach_constant="{{json_encode(\App\Models\Coach::TYPE)}}"
    :is_owner="{{$isOwner}}"
    :user="{{$user}}"></competitors-index>
@endSection