<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width: device-width, initial-scale: 1.0">
    <title>Contact List</title>
    <style>
        body {
    font-family: Century Gothic;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    position: relative;
    color: #333;
}

.container {
    width: 80%;
    margin: auto;
    overflow: hidden;
}

header {
    background-color: #333;
    color: white;
    padding: 10px 0;
    text-align: center;
}

/* Contact List Container */
.contact-list-container {
    background-color: white;
    margin-top: 20px;
    padding: 20px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    border-radius: 12px;
}

/* Align the search container to the left */
.search-container {
    margin-bottom: 5px;
    display: flex;
    justify-content: flex-start;
}

.search-container input {
    padding: 12px;
    width: 100%;
    max-width: 350px;
    border-radius: 50px;
    border: 1px solid #ccc;
    font-size: 16px;
    outline: none;
    transition: border-color 0.3s;
}

.search-container input:focus {
    border-color: #4CAF50;
}

/* Table Styles */
.contact-list {
    width: 100%;
    border-collapse: collapse;
    border-radius: 8px;
    background-color: white;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.contact-list th, .contact-list td {
    padding: 15px;
    text-align: left;
    border: 1px solid #ddd;
    font-size: 16px;
    color: #333;
}

/* Improved Table Header */
.contact-list th {
    background: linear-gradient(145deg, #4CAF50, #45a049); /* Subtle gradient */
    color: white;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.contact-list tr:hover {
    background-color: #f1f1f1;
    transform: scale(1.02);
    transition: all 0.3s ease;
}

/* Improved alternating row colors */
.contact-list tr:nth-child(even) {
    background-color: #f9f9f9; /* Light grey */
}

.contact-list tr:nth-child(odd) {
    background-color: #ffffff; /* White for odd rows */
}

/* Button Styles */
.btn-delete, .btn-edit {
    padding: 8px 16px;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s, transform 0.3s;
}

.btn-delete {
    background-color: #f44336;
}

.btn-delete:hover {
    background-color: #e53935;
    transform: scale(1.05);
}

.btn-edit {
    background-color: #4CAF50;
}

.btn-edit:hover {
    background-color: #45a049;
    transform: scale(1.05);
}

/* Logout Button */
.logout-btn {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 12px 24px;
    background-color: #f44336;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s, box-shadow 0.3s;
}

.logout-btn:hover {
    background-color: #e53935;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 30px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

/* Delete All Button */
.delete-all-btn {
    display: inline-block;
    margin-top: 20px;
    margin-bottom: 15px;
    padding: 12px 24px;
    background-color: #f44336;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
}

.delete-all-btn:hover {
    background-color: #e53935;
    transform: scale(1.05);
}

.delete-all-btn:focus {
    outline: none;
}

/* Generate Report Button Styling */
.generate-report-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 24px;
    background-color: #2196F3;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
}

.generate-report-btn:hover {
    background-color: #1976D2;
    transform: scale(1.05);
}

.generate-report-btn:focus {
    outline: none;
}

/* Pagination Styles */
.pagination {
    margin-top: 20px;
    text-align: center;
}

.pagination button {
    padding: 10px 15px;
    margin: 0 5px;
    border: 1px solid #ddd;
    background-color: #fff;
    cursor: pointer;
    border-radius: 4px;
}

.pagination button:hover {
    background-color: #f2f2f2;
}

.pagination button.active {
    background-color: #2196F3;
    color: white;
}


    </style>
</head>
<body>

    <header>
        <h1>Contact Management System</h1>
    </header>

    <div class="container">
        <div class="contact-list-container">
            <h2>Contact List</h2>

            <!-- Search Box -->
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search Contacts..." onkeyup="searchContacts()">
            </div>

            <!-- Improved Delete All Contacts Button -->
            <button class="delete-all-btn" onclick="deleteAllContacts()">Delete All Contacts</button>
            <button class="generate-report-btn" onclick="generateReport()">Generate Report</button>

            <table class="contact-list" id="contact-list">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Birthday</th>
                        <th>Tags</th>
                        <th>Zip Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Contacts will be dynamically added here -->
                </tbody>
            </table>

            <!-- Pagination Container -->
            <div id="pagination" class="pagination"></div>
        </div>
    </div>

    <!-- Logout Button -->
    <button class="logout-btn" onclick="logout()">Logout</button>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Edit Contact</h2>
            <form id="editForm" onsubmit="saveContact(event)">
                <label for="name">Name:</label>
                <input type="text" id="editName" name="name" required><br><br>
                <label for="phone">Phone:</label>
                <input type="text" id="editPhone" name="phone" required><br><br>
                <label for="email">Email:</label>
                <input type="email" id="editEmail" name="email" required><br><br>
                <label for="address">Address:</label>
                <input type="text" id="editAddress" name="address" required><br><br>
                <label for="birthday">Birthday:</label>
                <input type="date" id="editBirthday" name="birthday" required><br><br>
                <label for="tags">Tags:</label>
                <input type="text" id="editTags" name="tags" required><br><br>
                <label for="zip">Zip Code:</label>
                <input type="text" id="editZip" name="zip" required><br><br>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        let allContacts = []; // All contacts data
        let currentPage = 1;
        const contactsPerPage = 7; // Number of contacts per page

        // Function to fetch contacts from the server using AJAX
        function fetchContacts() {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_contact.php", true); // Make sure fetch_contact.php is returning the correct data
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log(xhr.responseText); // Check the structure of the response
                    allContacts = JSON.parse(xhr.responseText);
                    displayContacts(allContacts); // Display all contacts on the page
                    setupPagination(allContacts.length); // Set up pagination based on all contacts
                }
            };
            xhr.send();
        }

        // Function to display contacts in the table with pagination
        function displayContacts(contacts) {
            const contactList = document.getElementById('contact-list').getElementsByTagName('tbody')[0];
            contactList.innerHTML = '';  // Clear existing rows

            const startIndex = (currentPage - 1) * contactsPerPage;
            const endIndex = Math.min(startIndex + contactsPerPage, contacts.length);
            const contactsToDisplay = contacts.slice(startIndex, endIndex);

            contactsToDisplay.forEach((contact) => {
                const row = contactList.insertRow();
                row.insertCell(0).textContent = contact.id;
                row.insertCell(1).textContent = contact.name;
                row.insertCell(2).textContent = contact.phone;
                row.insertCell(3).textContent = contact.email;
                row.insertCell(4).textContent = contact.address;
                row.insertCell(5).textContent = contact.birthday;
                row.insertCell(6).textContent = contact.tags;
                row.insertCell(7).textContent = contact.zip;

                const actionsCell = row.insertCell(8);
                actionsCell.innerHTML = ` 
                    <button class="btn-edit" onclick="editContact(${contact.id}, '${contact.name}', '${contact.phone}', '${contact.email}', '${contact.address}', '${contact.birthday}', '${contact.tags}', '${contact.zip}')">Edit</button>
                    <button class="btn-delete" onclick="deleteContact(${contact.id})">Delete</button>
                `;
            });
        }

        // Function to setup pagination buttons
        function setupPagination(totalContacts) {
            const totalPages = Math.ceil(totalContacts / contactsPerPage);
            const paginationContainer = document.getElementById('pagination');
            paginationContainer.innerHTML = ''; // Clear existing pagination

            // Create pagination buttons
            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('button');
                pageButton.textContent = i;
                pageButton.onclick = function () {
                    currentPage = i;
                    displayContacts(allContacts);  // Re-display contacts for the selected page
                };
                paginationContainer.appendChild(pageButton);
            }
        }

        // Function to search contacts based on the input
        function searchContacts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();

            // Filter contacts based on the search term
            const filteredContacts = allContacts.filter(contact => {
                return contact.name.toLowerCase().includes(searchTerm) || 
                    contact.phone.includes(searchTerm) || 
                    contact.email.toLowerCase().includes(searchTerm) || 
                    contact.address.toLowerCase().includes(searchTerm) ||
                    contact.birthday.includes(searchTerm) ||
                    contact.tags.toLowerCase().includes(searchTerm) ||
                    contact.zip.includes(searchTerm);
            });

            // Call displayContacts with filtered results
            displayContacts(filteredContacts);

            // Re-setup pagination for filtered contacts
            setupPagination(filteredContacts.length);
        }

        // Function to handle logout
        function logout() {
    // Send request to server to destroy the session
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "logout.php", true); // Make sure logout.php destroys the session on the server
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert("You have logged out.");
            window.location.href = "login.php"; // Redirect to login page after logout
        } else {
            alert("Error logging out.");
        }
    };
    xhr.send();
}
        // Function to edit a contact
        function editContact(id, name, phone, email, address, birthday, tags, zip) {
            document.getElementById('editName').value = name;
            document.getElementById('editPhone').value = phone;
            document.getElementById('editEmail').value = email;
            document.getElementById('editAddress').value = address;
            document.getElementById('editBirthday').value = birthday;
            document.getElementById('editTags').value = tags;
            document.getElementById('editZip').value = zip;
            document.getElementById('editForm').onsubmit = function(event) {
                event.preventDefault();
                saveContact(event, id);
            };
            document.getElementById('editModal').style.display = "block";
        }

        // Function to save changes to the contact
        // Function to save changes to the contact
function saveContact(event, id) {
    // Prevent form submission
    event.preventDefault();

    const name = document.getElementById('editName').value;
    const phone = document.getElementById('editPhone').value;
    const email = document.getElementById('editEmail').value;
    const address = document.getElementById('editAddress').value;
    const birthday = document.getElementById('editBirthday').value;
    const tags = document.getElementById('editTags').value;
    const zip = document.getElementById('editZip').value;

    const updatedContact = {
        id: id, // The contact's ID
        name: name,
        phone: phone,
        email: email,
        address: address,
        birthday: birthday,
        tags: tags,
        zip: zip
    };

    // Send the updated contact data to the server
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_contact.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Contact updated successfully');
            fetchContacts();  // Refresh the contact list
            closeModal(); // Close the modal after updating
        } else {
            alert('Error updating contact');
        }
    };

    xhr.onerror = function() {
        alert('An error occurred while trying to update the contact.');
    };

    xhr.send(JSON.stringify(updatedContact));  // Send the contact data as JSON
}

// Function to close the modal
function closeModal() {
    const modal = document.getElementById('editModal');
    modal.style.display = "none";  // This will hide the modal
}



        // Function to delete a single contact
        function deleteContact(id) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_contact.php", true); // PHP file to handle the deletion
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert('Contact deleted successfully');
                    fetchContacts();  // Refresh the contact list
                } else {
                    alert('Error deleting contact');
                }
            };
            xhr.send(JSON.stringify({ id }));
        }

        // Function to delete all contacts
        function deleteAllContacts() {
            if (confirm("Are you sure you want to delete all contacts?")) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_all_contacts.php", true); // PHP file to handle the bulk deletion
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        alert('All contacts deleted successfully');
                        fetchContacts();  // Refresh the contact list
                    } else {
                        alert('Error deleting all contacts');
                    }
                };
                xhr.send();
            }
        }

        // Function to generate a report of contacts
        function generateReport() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "generate_reports.php", true); // PHP file to generate the report
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Create a blob with the CSV data
            const blob = new Blob([xhr.responseText], { type: 'text/csv' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);  // Create a URL for the blob
            link.download = 'contact_report.csv';  // Set the filename for the download
            link.click();  // Trigger the download
        } else {
            alert('Error generating report');
        }
    };
    xhr.send();
}

        window.onload = fetchContacts; // Fetch contacts when the page loads

    </script>

</body>
</html>
