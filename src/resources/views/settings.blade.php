@section('title', 'Export Mining Ledger')
@section('page_header', 'Tax Settings')
@section('page_description', 'Change tax percentage for the mining export tool')

@extends('web::layouts.grids.12')

@section('content')
    <p>
        Fill out the tax percentage values, if you want to generate a report of taxed ore.
    </p>

    <form>
        @foreach($moonOres as $groupTypeID => $oreTypes)
            @if($groupTypeID == '1923')
                    <h3>R64</h3>
            @endif
            @if($groupTypeID == '1922')
                <h3>R32</h3>
            @endif
            @if($groupTypeID == '1921')
                <h3>R16</h3>
            @endif
            @if($groupTypeID == '1920')
                <h3>R8</h3>
            @endif
            @if($groupTypeID == '1884')
                <h3>R4</h3>
            @endif

            @foreach($oreTypes as $moonOre)
                <input id="ore-type-{{ $moonOre->typeID }}" name="ore-type-{{ $moonOre->typeID }}" data-groupid="{{ $groupTypeID }}" rel="{{ $moonOre->typeID }}" class="ore-type-input" type="number" max="100" min="0" value="{{ $taxSettingValues->where('type_id', $moonOre->typeID)->first()->tax ?? 0 }}">
                <label for="ore-type-{{ $moonOre->typeID }}">{{ $moonOre->typeName }}</label>
                <br>
            @endforeach
            <hr>
        @endforeach
        <button id="save-settings" name="save-settings">Save</button>
    </form>
@endsection

@push('javascript')
    <script type="application/javascript">
        $( function() {
            $("#save-settings").click(function (e) {
                var values = [];
                $('.ore-type-input').each(function(){
                    values.push({ type_id: $(this).attr('rel'), value: this.value, group_id: $(this).attr('data-groupid') });
                });

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        taxvalues: values,
                    },
                    url: '{{ route('miningexport.settings.save') }}',
                    success: function(response) {
                        alert('Tax settings has been saved!');
                    }
                });

                e.preventDefault();
            });
        });
    </script>
@endpush