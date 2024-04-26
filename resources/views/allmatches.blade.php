<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Sign up </title> --}}
    <link rel="stylesheet" href="{{asset('css/match.css')}}">
</head>
<body>
    <a href="/api/backtrainerhomepage">Back</a></span>

    <div class="container">
        <h1>All Matches</h1>
        <table id="matches-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Trainer</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="matches-body">
                <!-- Matches will be inserted here -->
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Make AJAX request to fetch matches
    $.ajax({
        url: '/viewallmatches',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Handle successful response
            var matches = response.matches;
            var matchesBody = $('#matches-body');

            // Clear existing table rows
            matchesBody.empty();

            // Populate table with matches data
            $.each(matches, function(index, match) {
                matchesBody.append(
                    '<tr>' +
                        '<td>' + match.id + '</td>' +
                        '<td>' + match.name + '</td>' +
                        '<td>' + match.date + '</td>' +
                        '<td>' + match.location + '</td>' +
                        '<td>' + match.trainer_id + '</td>' + // Assuming you want to display trainer ID
                        '<td>' +
                            '<form action="/api/match/' + match.id + '" method="GET">' +
                                '<button class="btn btn-primary" type="submit">Show Match</button>' +
                            '</form>' +
                        '</td>' +
                    '</tr>'
                );
            });
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(error);
        }
    });
});

</script>

</body>
</html>
