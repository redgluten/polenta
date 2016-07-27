<div id="map" class="map"></div>

@push('styles')
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
    <style>
        .map {
            height: 400px;
            width: 100%;
        }
    </style>
@endpush

@push('scripts')
<!-- Leaflet library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js"></script>

<script type="text/javascript">
    var locations = {!! $locations !!};
    function loadMap() {
        var map = L.map('map').setView([45.57, 5.9], 12);
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
            maxZoom: 18,
            id: '{!! config('app.mapbox-id') !!}',
            accessToken: '{!! config('app.mapbox-token') !!}'
        }).addTo(map);

        for (var i = locations.length - 1; i >= 0; i--) {
            var marker = L.marker([locations[i].latitude, locations[i].longitude]).addTo(map);
            marker.bindPopup("<b>" + locations[i].name + "</b><br>" + locations[i].description);
        }
    }
</script>
@endpush