@extends('layout.main')

@section('content')


    <style>
        /* Add some basic styling */
        form {
            margin-bottom: 20px;
        }
        label {
            display: inline-block;
            width: 100px;
            margin-bottom: 10px;
        }
        input {
            margin-bottom: 10px;
        }
        button {
            display: block;
            margin-top: 10px;
        }
    </style>

    <h1>Update Record via  Laravel API</h1>
    <form id="updateForm">
        <input type="hidden" id="id" name="id" value="<?= $_GET['id'] ;?>">
        
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" class="form-control" required><br>

        <label for="lat">Latitude:</label>
        <input type="text" id="lat" name="lat" class="form-control" required><br>
        
        <label for="lng">Longitude:</label>
        <input type="text" id="lng" name="lng" class="form-control" required><br>
        
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" class="form-control" required><br>

        <label for="color">Color:</label>
        <input type="text" id="color" name="color" class="form-control" required><br>
        
        <label for="image">Image URL:</label>
        <input type="text" id="image" name="image" class="form-control" required><br>
        
        <button type="submit" class="btn btn-success">Update</button>
    </form>

    <script>
        $( document ).ready(function() {
    console.log( "ready!" );
    console.log(localStorage.getItem('auth_token'),'tokan')

});
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get('id');
            if (id) {
                fetchRecord(id);
            }
            
            document.getElementById('updateForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const id = document.getElementById('id').value;
                updateRecord(id);
            });
        });

        function fetchRecord(id) {
            fetch(`http://127.0.0.1:8000/api/posts/${id}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),

                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text) });
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('id').value = data.id;
                document.getElementById('username').value = data.username;
                document.getElementById('lat').value = data.lat;
                document.getElementById('lng').value = data.lng;
                document.getElementById('date').value = data.date;
                document.getElementById('color').value = data.color;
                document.getElementById('image').value = data.image;
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }

        function updateRecord(id) {
            const data = {
                username: document.getElementById('username').value,
                lat: document.getElementById('lat').value,
                lng: document.getElementById('lng').value,
                date: document.getElementById('date').value,
                color: document.getElementById('color').value,
                image: document.getElementById('image').value
            };

            fetch(`http://127.0.0.1:8000/api/posts/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('auth_token'),
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text) });
                }
                return response.json();
            })
            .then(data => {
                console.log('Record updated successfully:', data);
                alert('Record updated successfully! via  Laravel API');
                window.location.href = '/home-api'; // Redirect to /home-api
            })
            .catch((error) => {
                alert('Record not updated , try again!');

                console.error('Error:', error);
            });
        }
    </script>
@endsection
