<?php
// Start the session at the very beginning
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) { // Changed 'user' to 'user_id' to match your session variable
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// User is logged in, continue rendering the page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Management System</title>
    <style>
        body {
    font-family: 'Century Gothic', sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
    position: relative;
    color: #333;
}

.container {
    width: 80%;
    margin: 30px auto;
    overflow: hidden;
}

header {
    background-color: #333;
    color: white;
    padding: 10px 0;
    text-align: center;
}

.form-container {
    background-color: #ffffff;
    margin-top: 30px;
    padding: 30px;
    border-radius: 12px; /* Rounded corners for a smoother look */
    
    /* Soft and elegant shadow */
    /* Subtle gradient border for a premium feel */
    border: 1px solid #3498db; /* Cool, subtle blue border */
    
    /* Clean background */
    background-color: #ffffff;
    position: relative;
    overflow: hidden;
    
    /* Ensure that all elements inside have enough space */
    padding: 35px;
}

.form-container input,
.form-container select,
.form-container button {
    padding: 12px;
    margin: 12px 0;
    width: 100%; /* Ensure elements are aligned with full width */
    border: 1px solid #ccc;
    border-radius: 8px; /* Slightly rounded input boxes */
    font-size: 16px;
    color: #555;
    box-sizing: border-box; /* Make sure padding doesn't affect width */
    transition: border-color 0.3s ease;
}

.form-container input:focus,
.form-container select:focus {
    border-color: #2196F3;
    outline: none;
}

.form-container button {
    background-color: #2196F3;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    transition: background-color 0.3s ease;
    padding: 12px 20px; /* Consistent button padding */
}

.form-container button:hover {
    background-color: #2196F3;
}

.add-contact-btn {
    background-color: #2196F3;
    color: white;
    border: none;
    font-size: 16px;
    padding: 10px 20px; /* Smaller, more compact button */
    width: auto;
    border-radius: 6px;
    cursor: pointer;
    margin-top: 10px;
    transition: background-color 0.3s ease;
}

.add-contact-btn:hover {
    background-color: #2196F3;
}



.form-container input, 
.form-container select, 
.form-container button {
    padding: 10px;
    margin: 12px 0;
    width: 100%; /* Ensures all elements take the full width of the container */
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
    color: #555;
    box-sizing: border-box; /* Ensures padding doesn't affect width */
    transition: border-color 0.3s ease;
}

.form-container input:focus, 
.form-container select:focus {
    border-color: #2196F3;
    outline: none;
}

.form-container button{
    background-color: #2196F3;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px; /* Smaller font size */
    padding: 8px 16px; /* Smaller padding */
    width: auto; /* Ensures button is not stretched to full width */
    margin-left: 0; /* Align the button to the left */
    border-radius: 6px;
    transition: background-color 0.3s ease;
}

.form-container button:hover {
    background-color: #2196F3;
}

.logout-btn {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 12px 24px;
    background-color: #e74c3c;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.logout-btn:hover {
    background-color: #c0392b;
}

.go-to-contact-list-btn {
    padding: 12px 24px;
    background-color: #2196F3;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.go-to-contact-list-btn:hover {
    background-color: #2196F3;
}

/* Optional: Add smooth transition for hover effects */
button, .logout-btn, .go-to-contact-list-btn {
    transition: transform 0.3s ease;
}

button:hover, .logout-btn:hover, .go-to-contact-list-btn:hover {
    transform: translateY(-2px);
}

/* Additional styling for smaller screens */
@media (max-width: 768px) {
    .container {
        width: 95%;
    }

    header {
        font-size: 20px;
    }

    .form-container {
        padding: 20px;
    }

    .form-container input, 
    .form-container select, 
    .form-container button {
        font-size: 14px;
    }

    .logout-btn, .go-to-contact-list-btn {
        font-size: 14px;
        padding: 10px 20px;
    }
}


        /* Success message styles */
        .success-message {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
            z-index: 9999;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

    <header>
        <h1>Contact Management System</h1>
    </header>

    <div class="container">
        <div class="form-container">
            <h2 id="form-title">Add Contact</h2>
            <form id="contact-form">
                <input type="text" id="name" placeholder="Name" required>
                <input type="text" id="phone" placeholder="Phone Number" required>
                <input type="email" id="email" placeholder="Email Address" required>
                <input type="text" id="address" placeholder="Address" required>
                <!-- New input fields -->
                <input type="date" id="birthday" placeholder="Birthday">
                <input type="text" id="tags" placeholder="Tags (comma-separated)">
                <input type="text" id="zip-code" placeholder="Zip Code" required>
                <button type="submit">Add Contact</button>
            </form>
        </div>

        <!-- Go to Contact List Button -->
        <div style="margin-top: 20px;">
            <button class="go-to-contact-list-btn" onclick="window.location.href = 'contact_list.php';">Go to Contact List</button>
        </div>
    </div>

    <!-- Success Message -->
    <div id="success-message" class="success-message">
        Contact has been added successfully!
    </div>

    <!-- Logout Button -->
    <button class="logout-btn" onclick="logout()">Logout</button>

    <script>
        let editingContactId = null;

        // Function to add or update a contact
        document.getElementById('contact-form').addEventListener('submit', function (event) {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const phone = document.getElementById('phone').value;
            const email = document.getElementById('email').value;
            const address = document.getElementById('address').value;
            const birthday = document.getElementById('birthday').value;
            const tags = document.getElementById('tags').value;
            const zipCode = document.getElementById('zip-code').value;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", editingContactId ? "update_contact.php" : "add_contact.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
    if (xhr.status === 200) {
        console.log(xhr.responseText);  // Log server response for debugging
        document.getElementById('contact-form').reset();
        const successMessage = document.getElementById('success-message');
        successMessage.style.display = 'block';

        setTimeout(function () {
            successMessage.style.display = 'none';
        }, 3000);
    } else {
        console.log("Error: " + xhr.statusText);  // Log any errors
    }
};


            const data = `name=${name}&phone=${phone}&email=${email}&address=${address}&birthday=${birthday}&tags=${tags}&zip_code=${zipCode}` + (editingContactId ? `&id=${editingContactId}` : '');
            xhr.send(data);
        });

        // Function to logout
        function logout() {
            window.location.href = "logout.php"; // Redirect to a PHP logout page
        }
    </script>

</body>
</html>
