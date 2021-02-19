<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="baseUrl" content="{{ base_url() }}">
	<meta name="adminPath" content="{{ ADMIN_PATH }}">
	<meta name="apiPath" content="{{ API_PATH }}">
	<meta name="_token" content="{{ $_SESSION['token'] }}">
	<title>IPDN | {{ $title ?? 'Administrator' }}</title>
	<link rel="shortcut icon" type="image/jpg" href="https://rumahscript.com/demo/ipdn/wp-content/uploads/2019/04/mainlogo.png"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<link rel="stylesheet" href="{{ base_url('assets/admin/') }}plugins/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="{{ base_url('assets/admin/') }}plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
	<link rel="stylesheet" href="{{ base_url('assets/admin/') }}dist/css/adminlte.min.css">
	<link rel="stylesheet" href="{{ base_url('assets/admin/') }}plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<link rel="stylesheet" href="{{ base_url('assets/admin/') }}plugins/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="{{ base_url('assets/admin/') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="{{ base_url('assets/admin/') }}plugins/select2/css/select2.min.css">
  	<link rel="stylesheet" href="{{ base_url('assets/admin/') }}plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	<link rel="stylesheet" href="{{ base_url('assets/modules/iziToast.min.css') }}">
	@yield('head')
</head>