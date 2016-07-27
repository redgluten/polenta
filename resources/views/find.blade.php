@extends('layouts.public')

@section('title')
Où nous trouver
@stop

@section('content')
<div class="public-content container">
    <h1>@yield('title')</h1>

    <h2>Carte</h2>
    @include('partials._map')

    <h2>Liste</h2>

    <div class="table-responsive">
        <table class="table table-striped">
                <tbody>
                <?php $currentCity = ''; ?>
                @foreach ($locations as $location)
                    @unless ($currentCity === $location->city)
                        <?php $currentCity = $location->city ?>
                        <thead>
                            <tr>
                                <th colspan="2">
                                    <h3>{{ $currentCity }}</h3>
                                </th>
                            </tr>
                            <tr>
                                <th>Nom</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                    @endunless

                        <tr>
                            <td>{{ $location->name }}</td>
                            <td>{{ $location->description }}</td>
                        </tr>
                @endforeach
                </tbody>
        </table>
    </div>
</div>
@stop

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        loadMap();
    });
</script>
@endpush