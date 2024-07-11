@extends('layout.main')

@section('content')

<style>
     h1{display: inline-block;
        width:80%;
        }
        a{
            color:white;
            text-decoration: none
        }
</style>


    <div class="container">
        <h1>User Tracking</h1>
        <button  class="btn btn-info"><a href="/home-api">Create User Tracking</a></button>

    </div>
<div>
    <div id="map" style="height: 500px; width: 100%;"></div>

</div>
    <script type="text/javascript">
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: { lat: 23.2599333, lng: 77.412615 }
            });

            var locations = @json($records);

            // Group locations by username
            var groupedLocations = {};
            locations.forEach(function(location) {
                if (!groupedLocations[location.username]) {
                    groupedLocations[location.username] = [];
                }
                groupedLocations[location.username].push(location);
            });

            // Iterate over each user's locations
            Object.keys(groupedLocations).forEach(function(username) {
                var userLocations = groupedLocations[username];
                // var color = getRandomColor(); // Function to generate random color
                
                // Draw route for each user
                userLocations.forEach(function(location, index) {
                    var employeeName = location.username;
                    var color = location.color || '#000000';
                var photoUrl = location.image || '';
                    // Marker for current location
                    var marker = new google.maps.Marker({
                        position: { lat: parseFloat(location.lat), lng: parseFloat(location.lng) },
                        map: map,
                        title: employeeName + ' Route Location',
                        icon: {
                             url: photoUrl,
                            scaledSize: new google.maps.Size(50, 50),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(25, 25)
                        },
                        animation: google.maps.Animation.DROP
                    });

                    // Draw polyline for movement (if there's a previous location)
                    if (index > 0) {
                        var previousLocation = userLocations[index - 1];
                        var linePath = new google.maps.Polyline({
                            path: [
                                { lat: parseFloat(previousLocation.lat), lng: parseFloat(previousLocation.lng) },
                                { lat: parseFloat(location.lat), lng: parseFloat(location.lng) }
                            ],
                            geodesic: true,
                            strokeColor: color,
                            strokeOpacity: 1.0,
                            strokeWeight: 4
                        });

                        linePath.setMap(map);
                    }
                });
            });
        }

        // Function to generate random color
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        $(document).ready(function() {
            initMap();
        });
    </script>
@endsection
