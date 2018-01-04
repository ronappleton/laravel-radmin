<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap 4.0.0-alpha.3 -->
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <!-- wysihtml editor -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.min.css">
    @stack('head_styles')
    @stack('head_scripts')
</head>
<body>

@include('radmin::layouts.navbar.navbar')

<!-- NAVBAR -->
@yield('navbar')

@guest
    <div class="d-flex p-2 justify-content-center">
        @yield('content')
    </div>

@else

    <div class="container-fluid">
        <div class="row">
            @include('radmin::layouts.sidebar.left')
            <div class="col">
                @yield('content_header')
                <div class="col-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

@endguest


<footer>
    @include('radmin::layouts.footer.footer')
</footer>

<!-- Jquery 3.2.1 -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.all.min.js"
        type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
    });
</script>
@stack('scripts')
</body>
</html>