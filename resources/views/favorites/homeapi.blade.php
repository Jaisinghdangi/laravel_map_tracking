
@extends('layout.main')

@section('content')


    <style>
        /* Add some basic styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1{display: inline-block;
        width:70%;
        }
       
        a {
    color: #ffffff;
    text-decoration: none;
}
    </style>
<div>
    <h1>All Records via  Laravel API</h1>
<button class="btn btn-info pr-4"><a href="/tracking-route" class="text-lite">Track User On Map</a></button>

<button class="btn btn-info"><a href="/check-api" class="text-lite">Create Tracking</a></button>
</div>
    <div id="recordsContainer">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Date</th>
                    <th>Color</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="recordsTableBody">
                <!-- Data will be dynamically inserted here -->
            </tbody>
        </table>
    </div>

    <script>
     
        function fetchData() {
            fetch('http://127.0.0.1:8000/api/posts', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    // 'Authorization': 'Bearer YOUR_ACCESS_TOKEN' // Uncomment and replace with your access token if required
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => { throw new Error(text) });
                }
                return response.json();
            })
            .then(data => {
                console.log('Fetched data:', data);
                const recordsTableBody = document.getElementById('recordsTableBody');
                recordsTableBody.innerHTML = ''; // Clear existing data
            let sno =1;
                data.forEach(record => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${sno}</td>
                        <td>${record.username}</td>
                        <td>${record.lat}</td>
                        <td>${record.lng}</td>
                        <td>${record.date}</td>
                        <td>${record.color}</td>
                        <td><img src="${record.image}" alt="Image" width="50"></td>
                        <td><a href="/update-api?id=${record.id}" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
</svg></a><button onclick="confirmDelete(${record.id})" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
</svg></button></td>`;
                    recordsTableBody.appendChild(row);
                    sno++;
                });
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }

        // Fetch data on page load
        fetchData();


        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this record?')) {
                deleteRecord(id);
            }
        }

        function deleteRecord(id) {
            fetch(`http://127.0.0.1:8000/api/posts/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    // 'Authorization': 'Bearer YOUR_ACCESS_TOKEN' // Uncomment and replace with your access token if required
                },

            })
            .then(response => {
                // if (!response.ok) {
                //     return response.text().then(text => { throw new Error(text) });
                // }
                return response.json();
            })
            .then(data => {
                console.log('Record deleted successfully:', data);
                alert('Record deleted successfully via  Laravel API! ');
                 window.location.reload(); // Reload the page after delete

               // fetchRecords(); // Refresh records after delete
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }
    </script>

@endsection
