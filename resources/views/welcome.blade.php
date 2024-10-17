<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Vendors Style-->
    <link rel="stylesheet" href="{{ asset('main/css/vendors_css.css') }}">

    <!-- Style-->
    <link rel="stylesheet" href="{{ asset('main/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('main/css/skin_color.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Xschoolink</title>


    <script>
        (function() {
            window.Laravel = {
                csrfToken: '{{ Auth::user() }}'
            };
        })();
    </script>



</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
    <div id="app" class="wrapper">

        <example-component></example-component>

    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('main/js/vendors.min.js') }}"></script>
    <script src="{{ asset('main/js/pages/chat-popup.js') }}"></script>
    <script src="{{ asset('assets/icons/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor_components/datatable/datatables.min.js') }}"></script>
    {{-- <script src="{{ asset("assets/vendor_components/fullcalendar/fullcalendar.js") }}"></script> --}}

    <script src="{{ asset('main/js/pages/chat-popup.js') }}"></script>
    <script src="{{ asset('assets/icons/feather-icons/feather.min.js') }}"></script>

    {{-- <script src="{{ asset("assets/vendor_components/jquery-steps-master/build/jquery.steps.js") }}"></script> --}}
    {{-- <script src="{{ asset("assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.min.js") }}"></script> --}}
    {{-- <script src="{{ asset("main/js/pages/steps.js") }}"></script> --}}
    {{-- <script src="{{ asset("assets/vendor_components/sweetalert/sweetalert.min.js") }}"></script> --}}

    <script src="{{ asset('main/js/template.js') }}"></script>
    <script src="{{ asset('main/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('main/js/pages/calendar.js') }}"></script>
    <script src="{{ asset('main/js/pages/data-table.js') }}"></script>
    <script src="{{ asset('main/js/vendors.min.js') }}"></script>

</body>

</html>
