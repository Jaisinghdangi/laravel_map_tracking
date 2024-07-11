<!DOCTYPE html>
{{-- <html> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>OLIVE</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> --}}
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCnr2cIpAbxu32ce__6vwmr8vuLWbz5L4M"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

<body>
    <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('favorites.index') }}" style="color:#e28b3d;font-weight:bold;">View All
                        Favourites</a></li>
                <li><a href="{{ route('favorites.create') }}" style="color:#e28b3d;font-weight:bold;">Add New
                        Favourite</a>
                        <li><a href="/send-pdf-email" style="color:#ade916;font-weight:bold;">send pdf email</a>

            <li><a href="/auto-complete-address" style="color:#17c9f9;font-weight:bold;">Find location (LAT LNG)</a>

                <li><a href="/auto-complete-direction" style="color:#17c9f9;font-weight:bold;">PickUp to Drop Route</a>
                    {{-- <li><a href="/home-api" style="color:#17c9f9;font-weight:bold;">MAP User Tracking</a> --}}
                <li><a href="/tracking-route" style="color:#17c9f9;font-weight:bold;">MAP User Tracking</a>


            </ul>

        </div>
        {{-- <a href="{{ session()->has('loginId') ? route('logout') : route('auth.login') }}"  --}}
            <a
            onclick="{{ session()->has('loginId') ? 'logout()' : '' }}" 
            href="{{ session()->has('loginId') ? 'javascript:void(0);' : route('auth.login') }}"
            style="float: right;margin-right: 3%;color:white;" 
            class="mt-4 text-white btn">
             @if(session()->has('loginId'))
                 <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                      alt="User Image" style="height:30px; border-radius:50%;">
             @else
                 Login
             @endif
         </a>
         
    </nav>
    <div class="container">
        @yield('content')
    </div>
</body>
<script>
    function logout() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('http://127.0.0.1:8000/api/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text) });
            }
            return response.json();
        })
        .then(data => {
            console.log('Logged out successfully:', data);
            localStorage.removeItem('auth_token'); // Clear the token from local storage
            window.location.href = '{{ route('auth.login') }}'; // Redirect to the login page
        })
        .catch((error) => {
            console.error('Error logging out:', error);
            alert('Error logging out. Please try again.');
        });
    }
</script>

</html>
