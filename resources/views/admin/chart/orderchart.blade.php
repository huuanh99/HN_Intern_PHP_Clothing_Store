<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>{{ __('orderchart') }}</title>
        <script src="{{ asset('js/admin/Chart.min.js') }}" charset="utf-8"></script>
    </head>
    <body>
        <div>
            {!! $chart->container() !!}
        </div>
        {!! $chart->script() !!}
    </body>
</html>
