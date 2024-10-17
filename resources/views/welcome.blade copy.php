<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Vendors Style-->
	<link rel="stylesheet" href="{{ asset("main/css/vendors_css.css") }}">

	<!-- Style-->
	<link rel="stylesheet" href="{{ asset("main/css/style.css") }}">
	<link rel="stylesheet" href="{{ asset("main/css/skin_color.css") }}">

        <title> Xschoolink </title>


    </head>
    <body class="hold-transition light-skin sidebar-mini theme-primary fixed">
        <div id="app">
            
        </div>
        <script src="{{ asset("js/app.js") }}"></script>
        <script src="{{ asset("main/js/vendors.min.js") }}"></script>

    <script src="{{ asset("assets/icons/feather-icons/feather.min.js") }}"></script>
	<script src="{{ asset("assets/vendor_components/apexcharts-bundle/dist/apexcharts.js") }}"></script>
	<script src="{{ asset("assets/vendor_components/moment/min/moment.min.js") }}"></script>
	<script src="{{ asset("assets/vendor_components/fullcalendar/fullcalendar.js") }}"></script>

	<script src="{{ asset("main/js/pages/chat-popup.js") }}"></script>
    <script src="{{ asset("assets/icons/feather-icons/feather.min.js") }}"></script>

    <script src="{{ asset("main/js/template.js") }}"></script>
	<script src="{{ asset("main/js/pages/dashboard.js") }}"></script>
	<script src="{{ asset("main/js/pages/calendar.js") }}"></script>

    </body>
</html>
