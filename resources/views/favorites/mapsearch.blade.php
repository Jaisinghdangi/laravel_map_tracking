
@extends('layout.main')

@section('content')
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}


    <div class="container mt-5">
        <h2>Implement Google Autocomplete Address</h2>

        <div class="form-group">
            <label>Location/City/Address</label>
            <input type="text" name="autocomplete" id="autocomplete" class="form-control" placeholder="Choose Location">
        </div>

        <div class="form-group" id="latitudeArea">
            <label>Latitude</label>
            <input type="text" id="latitude" name="latitude" class="form-control">
        </div>

        <div class="form-group" id="longtitudeArea">
            <label>Longitude</label>
            <input type="text" name="longitude" id="longitude" class="form-control">
        </div>
        
        <div id="map" style="height: 500px; width: 100%;"></div>
        
        {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&callback=initialize&libraries=places&v=weekly"
      defer></script>

    <script>
        $(document).ready(function () {
            $("#latitudeArea").addClass("d-none");
            $("#longtitudeArea").addClass("d-none");
        });
    </script>

    <script>
        let map;
        let marker;

        function initialize() {
            var input = document.getElementById('autocomplete');
            var autocomplete = new google.maps.places.Autocomplete(input);
            var defaultLocation = { lat: 23.2599333, lng: 77.412615};

            map = new google.maps.Map(document.getElementById('map'), {
                center: defaultLocation,
                zoom: 13
            });

            marker = new google.maps.Marker({
                map: map,
                position: defaultLocation,
                draggable: true
            });

            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                console.log(place, 'place');
                $('#latitude').val(place.geometry['location'].lat());
                $('#longitude').val(place.geometry['location'].lng());

                $("#latitudeArea").removeClass("d-none");
                $("#longtitudeArea").removeClass("d-none");

                var location = place.geometry.location;
                map.setCenter(location);
                marker.setPosition(location);
            });
        }

        document.addEventListener('DOMContentLoaded', initialize);
    </script>
@endsection