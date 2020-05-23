<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{env('Project_title')}}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('modules/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('modules/fontawesome/css/all.min.css')}}">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/components.css')}}">
</head>
<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
@include ('admin.static.nav')
