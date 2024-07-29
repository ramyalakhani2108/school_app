// Function to get the token from localStorage
function getToken() {
    return localStorage.getItem('authToken');
}

// Function to verify the token
async function verifyToken() {
    const token = getToken(); // Get token from localStorage

    if (!token || token == null) {

        console.log('Token not found, redirecting to login page.');
    } else {
        // Clear all items from local storage
        localStorage.setItem('authToken', token); // Set authToken back to local storage

        try {

            let response = await fetch('/verified_token.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    token: token
                }) // Send the token as JSON
            });

            let responseText = await response.text(); // Get raw response text

            console.log('Raw response:', responseText);


            let data;
            try {
                data = JSON.parse(responseText);
            } catch (e) {
                console.error('Failed to parse response as JSON:', e);
                console.error('Non-JSON response:', responseText);
                window.location.href = '/login';
                return;
            }

            // console.log();
            if (!data.valid) {
                // If token is invalid, redirect to login page
                console.log('Token is invalid, redirecting to login page.');

            } else {
                console.log('Token is valid:', data);


            }
        } catch (error) {
            console.error('Error verifying token:', error);
            window.location.href = '/login'; // Uncomment to redirect on error
        }
    }
}

// Call verifyToken on page load

