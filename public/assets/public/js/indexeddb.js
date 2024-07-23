function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}


// Function to set the token in localStorage
function setToken(token) {
    localStorage.setItem('authToken', token);
}

// Example login function
function login() {
    // setTimeout(login, 200);
    const token = getCookie('token');
    // const deviceDetails = getDeviceDetails();
    if (token) {
        setToken(token);
        console.log('Token set in localStorage:', token);

    } else {
        if (localStorage.getItem('authToken')) {
            localStorage.removeItem('authToken');
        }

        console.log('No token found in cookies.');

    }
}

window.onload = login();



// function getDeviceDetails() {
// const userAgent = navigator.userAgent;
// // const platform = navigator.platform;
// const deviceDetails = {
//     userAgent: userAgent,
//     platform: platform,
//     // appVersion: navigator.appVersion,
//     // vendor: navigator.vendor
// };
//     return deviceDetails;
// }

// function login() {
//     console.log("first");
//     const deviceDetails = getDeviceDetails();
//     alert(deviceDetails);
//     fetch('/login', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({
//             email: document.getElementById('email').value,
//             password: document.getElementById('password').value,
//             deviceDetails: deviceDetails
//         })
//     })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 localStorage.setItem('token', data.token);
//                 window.location.href = '/home';
//             } else {
//                 console.error('Login failed:', data.message);
//             }
//         })
//         .catch(error => console.error('Error:', error));
// }
