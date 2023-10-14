@section('title', 'Export Mining Ledger')
@section('page_header', 'Export Mining Ledger')
@section('page_description', 'For the whole corporation')

@extends('web::layouts.grids.12')

@section('content')
    <p>
        Select a FROM and TO date, and press the generate button.
        <br>
        A .csv file will then be generated with all mined ore in the corporation for the selected period.
        <br>
        Please note the longer period, the longer it takes to generate the report.
    </p>

    <hr>

    <p>From date: <input type="text" id="datepicker_from"> - To date: <input type="text" id="datepicker_to"></p>
    <button id="generate_mining_csv">Generate report</button>
@endsection

@push('javascript')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script type="application/javascript">
        $( function() {
            $("#datepicker_from").datepicker({ minDate: "-4M", maxDate: "+1D", firstDay: 1, dateFormat: "yy-mm-dd" });
            $("#datepicker_to").datepicker({ minDate: "-4M", maxDate: "+1D", firstDay: 1, dateFormat: "yy-mm-dd" });

            $("#generate_mining_csv").click(function () {
                var params = {
                    from_date: $("#datepicker_from").val(),
                    to_date: $("#datepicker_to").val()
                };

                if (!params.from_date || !params.to_date) {
                    alert("Please select from and to date");
                    return;
                }

                var str = jQuery.param( params );
                var reportUrl = "{{ route('miningexport.generate') }}?" + str;

                var newWindow = window.open(reportUrl, '_blank');
                if (newWindow) {
                    newWindow.focus();
                } else {
                    alert('Please allow popups for this website');
                }
            });
        });
    </script>
@endpush