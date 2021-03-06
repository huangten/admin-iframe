<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('app.name')}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('admin.layouts.css')

    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
</head>
<body class="hold-transition skin-blue sidebar-mini fixed" style="overflow: hidden">
<div class="wrapper">
    <!-- 顶部 -->
    <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">{{config('app.name')}}</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">{{config('app.name')}}</span>
        </a>
        <!-- 顶部菜单 -->
        <nav class="navbar navbar-static-top">
            <!-- 隐藏左边菜单-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <!-- 右边部分 -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <!-- 日志 -->
                        <a href="{{route('log-viewer::dashboard')}}" target="_blank"><i class="fa fa-flag"></i></a>
                    </li>
                    <li>
                        <!-- 打开右边隐藏的部分 -->
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-user"></i> {{$user->name?:$user->username}}</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- 右边隐藏的部分 -->
    <aside class="control-sidebar control-sidebar-dark">
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="">
                <a href="#control-sidebar-skin" data-toggle="tab">
                    <i class="fa fa-wrench"></i>
                </a>
            </li>
            <li class="active">
                <a href="#control-sidebar-password" data-toggle="tab">
                    <i class="fa fa-gears"></i>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" id="control-sidebar-skin">
                <h3 class="control-sidebar-heading">Skins</h3>
                @component('component.skins')
                @endcomponent
            </div>
            <div class="tab-pane active" id="control-sidebar-password">
                <h3 class="control-sidebar-heading">个人信息</h3>
                <form action="{{route('admin.profile')}}" method="post" class="form-line" autocomplete="off">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="" class="control-label">登录名(不可修改)</label>
                        <span>{{$user->username}}</span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{$user->name}}">
                        <span class="fa fa-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <span class="fa fa-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">修改</button>
                    </div>
                    <div class="form-group">
                        <a href="{{route('admin.logout')}}" class="btn btn-block btn-warning">退出</a>
                    </div>

                </form>
            </div>
        </div>
    </aside>
    <div class="control-sidebar-bg"></div>

    <!-- 左边菜单 js填充 -->
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
            @foreach($menus as $item)
                <li class="treeview">
                    <a href="{{isset($item['url'])?url($item['url']):'javascript:void(0)'}}" class="nav-link">
                        <i class="{{$item['icon']}}"></i>
                        <span class="title menu-text">{{$item['text']}}</span>
                        @if(isset($item['children']))
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        @endif
                    </a>
                    @if(isset($item['children']))
                    <ul class="treeview-menu">
                        @foreach($item['children'] as $child)
                        <li>
                            <a href="{{isset($child['url'])?url($child['url']):'javascript:void(0)'}}" class="nav-link">
                                <i class="{{$child['icon']}}"></i>
                                <span class="title menu-text">{{$child['text']}}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
            @endforeach
            </ul>
        </section>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Page Header
                <small>Optional description</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <!--------------------------
              | Your Page Content Here |
              -------------------------->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <b>Serrt</b>
    </footer>
</div>

@include('admin.layouts.js')

</body>
</html>