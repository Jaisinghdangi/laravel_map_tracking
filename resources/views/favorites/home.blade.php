@extends('layout.main')

@section('content')
    <div class="container mt-5">
        <h2>Implement Google Autocomplete Address with Directions</h2>

        <div class="form-group">
            <label>Current Location</label>
            <input type="text" name="currentLocation" id="currentLocation" class="form-control" placeholder="Enter current location">
        </div>

        <div class="form-group">
            <label>Destination</label>
            <input type="text" name="autocomplete" id="autocomplete" class="form-control" placeholder="Enter destination">
        </div>
        <button type="button" id="getDirections" class="btn btn-primary">Get Directions</button>

        <div class="form-group d-none" id="latitudeArea">
            <label>Latitude</label>
            <input type="text" id="latitude" name="latitude" class="form-control">
        </div>

        <div class="form-group d-none" id="longtitudeArea">
            <label>Longitude</label>
            <input type="text" name="longitude" id="longitude" class="form-control">
        </div>

        <div id="map" style="height: 500px; width: 100%;"></div>
        <div id="directionsPanel" style="margin-top: 20px;"></div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&callback=initialize&libraries=places&v=weekly" defer></script>


    <script>
        let map;
        let marker;
        let directionsService;
        let directionsRenderer;
        let currentLocationAutocomplete;
        let destinationAutocomplete;
        let currentLocation;
        let destinationLocation;

        function initialize() {
            var currentLocationInput = document.getElementById('currentLocation');
            var destinationInput = document.getElementById('autocomplete');

            currentLocationAutocomplete = new google.maps.places.Autocomplete(currentLocationInput);
            destinationAutocomplete = new google.maps.places.Autocomplete(destinationInput);

            var defaultLocation = { lat: -33.8688, lng: 151.2195 };

            map = new google.maps.Map(document.getElementById('map'), {
                center: defaultLocation,
                zoom: 13
            });

            marker = new google.maps.Marker({
                map: map,
                position: defaultLocation,
                draggable: true
            });

            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);
            directionsRenderer.setPanel(document.getElementById('directionsPanel'));

            currentLocationAutocomplete.addListener('place_changed', function () {
                var place = currentLocationAutocomplete.getPlace();
                console.log(place, 'current location');
                currentLocation = place.geometry.location;
            });

            destinationAutocomplete.addListener('place_changed', function () {
                var place = destinationAutocomplete.getPlace();
                console.log(place, 'destination');
                // $('#latitude').val(place.geometry['location'].lat());
                // $('#longitude').val(place.geometry['location'].lng());

                // $("#latitudeArea").removeClass("d-none");
                // $("#longtitudeArea").removeClass("d-none");

                destinationLocation = place.geometry.location;
                map.setCenter(destinationLocation);
                marker.setPosition(destinationLocation);
            });

            document.getElementById('getDirections').addEventListener('click', function () {
                calculateAndDisplayRoute();
            });
        }

        function calculateAndDisplayRoute() {
            if (currentLocation && destinationLocation) {
                directionsService.route({
                    origin: currentLocation,
                    destination: destinationLocation,
                    travelMode: 'DRIVING'
                }, function (response, status) {
                    if (status === 'OK') {
                        directionsRenderer.setDirections(response);
                    } else {
                        window.alert('Directions request failed due to ' + status);
                    }
                });
            } else {
                window.alert('Please select both current location and destination.');
            }
        }

        document.addEventListener('DOMContentLoaded', initialize);
    </script>
@endsection
