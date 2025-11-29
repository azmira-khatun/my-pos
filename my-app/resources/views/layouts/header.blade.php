<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets-admin/plugins/fontawesome/css/all.min.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
      href="{{ asset('assets-admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets-admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('assets-admin/plugins/jqvmap/jqvmap.min.css') }}">

    <!-- AdminLTE Theme style -->
    <link rel="stylesheet" href="{{ asset('assets-admin/dist/css/adminlte.min.css') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <style>
      /* 🔹 Navbar color change */
      .main-header.navbar {
        background-color: #9dc6f1 !important;
        /* তোমার পছন্দের রঙ */
        color: #ffffff !important;
        /* টেক্সট সাদা */
      }

      /* Navbar links & icons white */
      .main-header .nav-link,
      .main-header .navbar-nav .nav-item .nav-link i,
      .main-header .navbar-nav .nav-item .badge {
        color: #ffffff !important;
      }

      /* Navbar search input background & text */
      .main-header .form-control-navbar {
        background-color: rgba(255, 255, 255, 0.2) !important;
        color: #ced5dbff !important;
      }

      /* Navbar search button icon white */
      .main-header .btn-navbar i {
        color: #ffffff !important;
      }

      /* 🔹 Sidebar search box input field background change */
      .form-control-sidebar {
        background-color: #ffffff !important;
        /* তোমার পছন্দের রঙ */
        color: #000000 !important;
        /* টেক্সট কালো */
        border: 1px solid #ccc !important;
        /* হালকা বর্ডার চাইলে */
      }

      /* 🔹 Search button (icon area) background & icon color change */
      .btn-sidebar {
        background-color: #9dc6f1 !important;
        /* তোমার পছন্দমতো রঙ */
        color: #000000 !important;
        /* আইকন কালার */
        border: none !important;
      }

      /* Optional: placeholder color light gray */
      .form-control-sidebar::placeholder {
        color: #666 !important;
      }



      /* Sidebar-er Background Color */
      .main-sidebar,
      .sidebar-dark .nav-sidebar>.nav-item>.nav-link.active,
      .sidebar-dark .nav-sidebar>.nav-item:hover>.nav-link {
        background-color: #e6f7f893 !important;
      }


      .main-sidebar .nav-link,
      .main-sidebar .user-panel>.info>a,
      .main-sidebar .brand-text,
      .main-sidebar .brand-link .image,
      .main-sidebar .nav-icon {
        color: #130c0cff !important;
      }

      /* Search input box-er background transparent ebong text white korar jonne */
      .sidebar-search .form-control-sidebar {
        background-color: transparent !important;
        color: #FFFFFF !important;
      }

      /* 🔹 Brand Logo (AdminLTE 3) background color change */
      .brand-link {
        background-color: #f5b87fff !important;
        /* তোমার পছন্দের রঙ */
        color: #000000 !important;
        /* টেক্সটের রঙ কালো */
      }

      /* 🔹 Logo text color */
      .brand-link .brand-text {
        color: #000000 !important;
      }

      /* 🔹 Logo image opacity normal (optional) */
      .brand-link .brand-image {
        opacity: 1 !important;
      }
    </style>
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('assets-admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('assets-admin/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('assets-admin/plugins/summernote/summernote-bs4.min.css')}}">
  </head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

  <div class="wrapper">