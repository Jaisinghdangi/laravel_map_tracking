
@extends('layout.main')

@section('content')


<style>
      h1{display: inline-block;
        width:90%;
        }
       
        a{
            color:white;
            text-decoration: none
        }
</style>

    <div>
        <h1>Add User Location via  Laravel API</h1>
    <button  class="btn btn-info"><a href="/home-api">Back</a></button>
    </div>
    <form id="postForm">
        <label for="username">username:</label>
        <input type="text" id="username" name="username" class="form-control" required><br>

        <label for="lat">Latitude:</label>
        <input type="text" id="lat" name="lat" class="form-control" required><br>
        
        <label for="lng">Longitude:</label>
        <input type="text" id="lng" name="lng" class="form-control" required><br>
        
        <label for="color">Date:</label>
        <input type="date" id="date" name="date" class="form-control" required><br>

        <label for="color">Color:</label>
        <input type="text" id="color" name="color" class="form-control" required><br>
        
        <label for="image">Image URL:</label>
        <input type="text" id="image" name="image" class="form-control" required><br>
        
        <button type="submit" class="btn btn-success">Submit</button>
    </form>

    <script>
        
        document.getElementById('postForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const data = {
                
                username: document.getElementById('username').value,
                lat: document.getElementById('lat').value,
                lng: document.getElementById('lng').value,
                date: document.getElementById('date').value,
                color: document.getElementById('color').value,
                image: document.getElementById('image').value
            };

            fetch('http://127.0.0.1:8000/api/posts', {
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
                alert('Record Inserted successfully via  Laravel API!');
                window.location.href = '/home-api'; // Redirect to /home-api
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        });
    </script>

@endsection

