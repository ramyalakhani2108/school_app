
{/* <script> */ }
// Function to get the token from localStorage
function getToken() {
    return localStorage.getItem('authToken');
}

// Function to verify the token
async function verifyToken() {
    const token = getToken(); // Get token from localStorage
    if (!token) {
        // Redirect to login page if no token is found
        console.log('Token not found, redirecting to login page.');

        window.location.href = '/login';
        // return;
    }
    localStorage.clear(); // Clear all items from local storage

    if (token) {
        localStorage.setItem('authToken', token);
        // Set authToken back to local storage
    }
    try {
        let response = await fetch('verified_token.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                token: token
            }) // Send the token as JSON
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        let data = await response.json();
        console.log(data);
        if (!data.valid) {
            // If token is invalid, redirect to login page
            console.log('Token is invalid, redirecting to login page.');
            window.location.href = '/login';
        } else {
            console.log('Token is valid:', data);
        }
    } catch (error) {
        console.error('Error verifying token:', error);
        // Handle error, usually redirect to login page
        var Cookies = document.cookie.split(';');

        // set 1 Jan, 1970 expiry for every cookies
        for (var i = 0; i < Cookies.length; i++)
            document.cookie = Cookies[i] + "=;expires=" + new Date(0).toUTCString();
        window.location.href = '/';
    }
}

// Call verifyToken on page load
window.onload = verifyToken;
{/* </script> */ }