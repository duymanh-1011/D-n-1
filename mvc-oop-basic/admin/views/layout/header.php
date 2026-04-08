<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ORVANI</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./assets/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="./assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./assets/dist/css/adminlte.min.css?v=2">

  <style>
      /* Softer admin sidebar and text contrast */
      body {
          background: #f4f6f9 !important;
      }
      .main-header {
          border-bottom: 1px solid rgba(92, 125, 217, 0.15) !important;
          box-shadow: 0 2px 12px rgba(31, 45, 64, 0.07) !important;
          margin-bottom: 18px !important;
      }
      .main-footer {
          border-top: 1px solid rgba(92, 125, 217, 0.15) !important;
          box-shadow: 0 -2px 12px rgba(31, 45, 64, 0.05) !important;
          margin-top: 24px !important;
      }
      .btn-primary, .btn-primary:hover, .btn-primary:focus {
          background: #5c7dd9 !important;
          border-color: rgba(92, 125, 217, 0.25) !important;
          box-shadow: 0 5px 18px rgba(92, 125, 217, 0.18) !important;
          transition: all 0.25s ease !important;
      }
      .btn-primary:hover {
          background: #4b6aca !important;
          transform: translateY(-1px) !important;
      }
      .text-primary, a.text-primary:hover {
          color: #5c7dd9 !important;
      }
      .bg-primary {
          background: #5c7dd9 !important;
      }
      .main-sidebar.sidebar-dark-primary,
      .main-sidebar.sidebar-dark-primary .sidebar,
      .main-sidebar.sidebar-dark-primary .sidebar::before {
          background: #495057 !important;
          background-image: none !important;
          box-shadow: none !important;
          border-right: 1px solid rgba(255,255,255,0.08) !important;
      }
      .main-sidebar.sidebar-dark-primary .brand-link {
          background: #3e494f !important;
          color: #ffffff !important;
          border-bottom: 1px solid rgba(255,255,255,0.08) !important;
      }
      .main-sidebar.sidebar-dark-primary .brand-link .brand-image {
          background: #5a6570 !important;
          border: 1px solid rgba(255,255,255,0.14) !important;
      }
      .main-sidebar.sidebar-dark-primary .user-panel {
          background: rgba(255,255,255,0.08) !important;
          border-radius: 12px !important;
      }
      .main-sidebar.sidebar-dark-primary .user-panel .image img {
          border-color: rgba(255,255,255,0.22) !important;
          background: #6d7882 !important;
      }
      .main-sidebar.sidebar-dark-primary .brand-link,
      .main-sidebar.sidebar-dark-primary .nav-link,
      .main-sidebar.sidebar-dark-primary .user-panel .info a {
          color: #f5f7fa !important;
      }
      .sidebar .nav-link:hover {
          background: rgba(255,255,255,0.1) !important;
          color: #ffffff !important;
      }
      .sidebar .nav-link.active {
          background: #5d6a73 !important;
          color: #ffffff !important;
          border-left: 3px solid #ced7e0 !important;
      }
      .sidebar .nav-icon {
          color: #d7dde4 !important;
      }
      .sidebar .nav-header {
          color: rgba(255,255,255,0.7) !important;
      }
      .sidebar .nav-link.active {
          background: #5c7dd9 !important;
          color: #ffffff !important;
          border-left: 3px solid #4b6aca !important;
      }
      .sidebar .nav-icon {
          color: #c1d0e7 !important;
      }
      .sidebar .nav-header {
          color: rgba(255,255,255,0.72) !important;
      }
      .sidebar .user-panel .info a {
          color: #dce3f2 !important;
      }
      .main-header .navbar-nav .nav-link:hover {
          color: #5c7dd9 !important;
      }
      .card-primary .card-header {
          background: #5c7dd9 !important;
          border-color: rgba(92, 125, 217, 0.25) !important;
      }
      .card {
          box-shadow: 0 6px 20px rgba(31, 45, 64, 0.06) !important;
          background: #ffffff !important;
          border-color: rgba(92, 125, 217, 0.15) !important;
      }
      .card:hover {
          transform: translateY(-2px) !important;
          transition: transform 0.25s ease !important;
      }
      .table thead th {
          background: #5c7dd9 !important;
          color: #ffffff !important;
      }
  </style>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">