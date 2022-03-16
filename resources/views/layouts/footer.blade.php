
<!-- Scripts -->
<script src="{{ asset('/js/vendor.js') }}"></script>
<script src="{{ asset('/js/hyper.js') }}"></script>

<!-- third party js -->
<script src="{{ asset("/js/vendor/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset("/js/vendor/dataTables.bootstrap4.js") }}"></script>
<script src="{{ asset("/js/vendor/dataTables.responsive.min.js") }}"></script>
<script src="{{ asset("/js/vendor/responsive.bootstrap4.min.js") }}"></script>
<script src="{{ asset("/js/vendor/dataTables.checkboxes.min.js") }}"></script>
<script src="{{ asset("/js/vendor/Chart.bundle.min.js") }}"></script>
<script src="{{ asset("/js/vendor/apexcharts.min.js") }}"></script>
<!-- third party js ends -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/r-2.2.9/sr-1.1.0/datatables.min.js"></script>

<script src="{{ asset('/js/app.js') }}"></script>

@stack('page-scripts')

@yield('page-scripts')

</body>
</html>
