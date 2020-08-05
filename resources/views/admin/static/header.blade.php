<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>PCHLEKA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/mainStyle.css')}}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('modules/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('modules/fontawesome/css/all.min.css')}}">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/components.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />


</head>
<body class="sidebar-mini" data-hasqtip="0" data-gr-c-s-loaded="true">
<div id="app">
    <div class="main-wrapper main-wrapper-1">
@include ('admin.static.nav')
