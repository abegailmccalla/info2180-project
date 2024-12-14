// window.onload = function() {
//     document.getElementById("login").addEventListener("click", function(event) {
//         event.preventDefault();

//         let email = document.getElementById("email").value.trim().replace(/(<([^>]+)>)/gi, "");
//         let password = document.getElementById("password").value.trim().replace(/(<([^>]+)>)/gi, "");

//         const xhttp = new XMLHttpRequest();
//         xhttp.onreadystatechange = function() {
//             if (this.readyState == 4 && this.status == 200) {
//                 document.getElementById("result").innerHTML = this.responseText;
//             }
//         }

//         xhttp.open("POST", "login.php?email="+email+"&password="+password);
//         xhttp.send();
//     });
// }

// window.onload = function() {
//     document.getElementById("login").addEventListener("click", function(event) {
//         event.preventDefault();
        
//         let email = document.getElementById("email").value.trim().replace(/(<([^>]+)>)/gi, "");
//         let password = document.getElementById("password").value.trim().replace(/(<([^>]+)>)/gi, "");
        
//         console.log("Email:", email);  // Debug logging
//         console.log("Password:", password);  // Debug logging

//         const formData = new FormData();
//         formData.append('email', email);
//         formData.append('password', password);

//         fetch('login.php', {
//             method: 'POST',
//             body: formData
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 window.location.href = 'dashboard.php';
//             } else {
//                 document.getElementById("result").innerHTML = data.message;
//             }
//         })
//         .catch(error => {
//             console.error('Error:', error);
//         });
//     });
// }

window.onload = function() {
    document.getElementById("login").addEventListener("click", function(event) {
        event.preventDefault();
        
        let email = document.getElementById("email").value.trim().replace(/(<([^>]+)>)/gi, "");
        let password = document.getElementById("password").value.trim().replace(/(<([^>]+)>)/gi, "");
        
        console.log("Email:", email);  // Debug logging
        console.log("Password:", password);  // Debug logging

        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);

        fetch('login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            // Check if response is OK
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            // Try to parse as JSON
            return response.json();
        })
        .then(data => {
            console.log("Received data:", data);  // Additional debug logging
            if (data.success) {
                window.location.href = 'dashboard.html';
            } else {
                document.getElementById("result").innerHTML = data.message;
            }
        })
        .catch(error => {
            console.error('Full error:', error);
            document.getElementById("result").innerHTML = 'Login failed. Please try again.';
        });
    });
};
