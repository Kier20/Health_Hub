function performSearch() {
    const searchInput = document.getElementById('searchInput').value;

    // Display a loading indicator
    $('#searchResults').html('<p>Loading...</p>');

    fetch(`http://127.0.0.1:5000/details?id=${searchInput}`, {
        method: 'GET',
        mode: 'cors',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        // Handle the data as needed
        console.log(data);
        // Display the search results
        displaySearchResults(data);
    })
    .catch(error => {
        console.error('Error fetching details:', error);
        alert('Error fetching details. Please try again.');
    });
}

function displaySearchResults(results) {
    // Clear previous search results
    $('#searchResults').empty();

    // Display new search results
    if (results.length > 0) {
        var resultList = '<ul>';
        var previousResultId = null;  // Variable to store the previous result's ID

        for (var i = 0; i < results.length; i++) {
            // Check if the current result has the same ID as the previous one
            if (results[i].id === previousResultId) {
                // Break out of the loop if the ID is the same
                break;
            }

            // Update the previousResultId for the next iteration
            previousResultId = results[i].id;

            // Append the result to the resultList string
            resultList += '<li><div style="text-align: left;"><a href="details_page.php?id=' + results[i].id + '"><strong>' + results[i].name + '</strong></a>:<br>' + results[i].short_description + '</div></li>';
        }

        resultList += '</ul>';
        $('#searchResults').html(resultList);
    } else {
        $('#searchResults').html('<p>No results found.</p>');
    }
}