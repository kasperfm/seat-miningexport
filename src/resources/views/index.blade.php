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

    <label for="datepicker_from">From date: </label> <input type="date" id="datepicker_from" name="datepicker_from">
    <label for="datepicker_to">To date: </label> <input type="date" id="datepicker_to" name="datepicker_to"><br>
    <label for="withdetails">Include characters in report</label>
    <input type="checkbox" name="withdetails" id="withdetails">
    <hr>
    <button class="btn btn-info" id="generate_mining_csv">Generate Report</button>  <button class="btn btn-warning" id="generate_tax_csv">Tax Report</button>
@endsection

@push('javascript')
    <script type="application/javascript">
        $( function() {
            function generateReport(url) {
                var params = {
                    from_date: $("#datepicker_from").val(),
                    to_date: $("#datepicker_to").val(),
                    with_details: $("#withdetails").prop('checked')
                };

                if (!params.from_date || !params.to_date) {
                    alert("Please select from and to date");
                    return;
                }

                var str = jQuery.param( params );
                var reportUrl = url + str;

                var newWindow = window.open(reportUrl, '_blank');
                if (newWindow) {
                    newWindow.focus();
                } else {
                    alert('Please allow popups for this website');
                }
            }

            $("#generate_mining_csv").click(function () {
                generateReport("{{ route('miningexport.generate') }}?");
            });

            $("#generate_tax_csv").click(function () {
                generateReport("{{ route('miningexport.taxgenerate') }}?");
            });
        });
    </script>
@endpush