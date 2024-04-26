<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matches</title>
</head>
<body>
    <h1>Matches</h1>
    <div id="matches-container"></div>
    <div id="pagination-container">
        {{-- onclick="fetchMatches('{{ response.links.prev }}')" --}}
        <button >Previous</button>
        {{-- onclick="fetchMatches('{{ response.links.next }}')" --}}
        <button >Next</button>
    </div>

    {{-- <script>
        function fetchMatches(url) {
            fetch(url)
            .then(response => response.json())
            .then(data => {
                renderMatches(data.data);
                renderPagination(data.links);
            })
            .catch(error => console.error('Error:', error));
        }

        function renderMatches(matches) {
            const matchesContainer = document.getElementById('matches-container');
            matchesContainer.innerHTML = '';
            matches.forEach(match => {
                const matchDiv = document.createElement('div');
                matchDiv.textContent = `ID: ${match.id}, Name: ${match.name}, Date: ${match.date}, Location: ${match.location}, Trainer ID: ${match.trainer_id}`;
                matchesContainer.appendChild(matchDiv);
            });
        }

        function renderPagination(links) {
            const paginationContainer = document.getElementById('pagination-container');
            paginationContainer.innerHTML = '';
            if (links.prev) {
                const prevButton = document.createElement('button');
                prevButton.textContent = 'Previous';
                prevButton.onclick = () => fetchMatches(links.prev);
                paginationContainer.appendChild(prevButton);
            }
            if (links.next) {
                const nextButton = document.createElement('button');
                nextButton.textContent = 'Next';
                nextButton.onclick = () => fetchMatches(links.next);
                paginationContainer.appendChild(nextButton);
            }
        }

        // Initial fetch
        fetchMatches('/matches');
    </script> --}}
</body>
</html>
