<!DOCTYPE html>
<html lang="en">

<head>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="forntEnd-Developer" content="Mamunur Rashid">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title')</title>
	<!-- favicon -->
	<link rel="shortcut icon" href="{{ asset('assets/images/favicon.html') }}" type="image/x-icon">
	<!-- bootstrap -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<!-- Plugin css -->
	<link rel="stylesheet" href="{{ asset('assets/css/plugin.css') }}">

	<!-- stylesheet -->
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	<!-- responsive -->
	<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
	
	<link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

	<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>