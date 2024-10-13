// script.js
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('userModal');
    var addUserBtn = document.getElementById('addUserBtn');
    var closeBtn = document.querySelector('.close');

    // Open modal
    addUserBtn.addEventListener('click', function () {
        modal.style.display = 'flex';
    });

    // Close modal
    closeBtn.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    // Close modal when clicking outside
    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    var userTableBody = document.getElementById('userTableBody');
    let deleteUserId = null;  // เก็บ user ID ที่จะลบ
    
    // Fetch user data from PHP
    fetch('connect.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(user => {
                var row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.id}</td>
                    <td>${user.username}</td>
                    <td>${user.email}</td>
                    <td>${user.role}</td>
                    <td>${user.status}</td>
                    <td>
                        <button class="editBtn" data-id="${user.id}" data-username="${user.username}" data-email="${user.email}" data-role="${user.role}" data-status="${user.status}">Edit</button>
                        <button class="deleteBtn" data-id="${user.id}">Delete</button>
                    </td>
                `;
                userTableBody.appendChild(row);
            });
            // Add event listeners to Edit buttons
            const editButtons = document.querySelectorAll('.editBtn');
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    const username = this.getAttribute('data-username');
                    const email = this.getAttribute('data-email');
                    const role = this.getAttribute('data-role');
                    const status = this.getAttribute('data-status');

                    // Fill in the modal form with the selected user's data
                    document.getElementById('userId').value = userId;
                    document.getElementById('username').value = username;
                    document.getElementById('email').value = email;
                    document.getElementById('role').value = role;
                    document.getElementById('status').value = status;

                    // Show the modal
                    document.getElementById('userEditModal').style.display = 'block';
                });
            });
            // Close modal when clicking the close button
    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('userEditModal').style.display = 'none';
    });

    // Close modal when clicking outside of the modal
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('userEditModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
       
            // Add event listeners to Delete buttons
            const deleteButtons = document.querySelectorAll('.deleteBtn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    deleteUserId = this.getAttribute('data-id');  // เก็บ ID ผู้ใช้ที่จะลบ
                    document.getElementById('deleteConfirmationModal').style.display = 'block';  // เปิด modal
                });
            });
        });

    // Handle Delete Confirmation
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        // Send request to delete user via PHP
        fetch(`delete_user.php?id=${deleteUserId}`, {
            method: 'DELETE'
        })
        .then(response => response.text())
        .then(result => {
            alert(result);
            // Reload the page or update the table to reflect the deletion
            location.reload();
        })
        .catch(error => console.error('Error:', error));

        // Close the modal after confirmation
        document.getElementById('deleteConfirmationModal').style.display = 'none';
    });

    // Handle Cancel button click
    document.getElementById('cancelDeleteBtn').addEventListener('click', function() {
        document.getElementById('deleteConfirmationModal').style.display = 'none';  // ปิด modal
    });

    // Close modal when clicking the close (X) button
    document.getElementById('closeDeleteModal').addEventListener('click', function() {
        document.getElementById('deleteConfirmationModal').style.display = 'none';
    });

    // Close modal when clicking outside of the modal
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('deleteConfirmationModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
        
document.addEventListener('DOMContentLoaded', function () {
    // ฟังก์ชันสำหรับกรองข้อมูลในตาราง
    const searchInput = document.getElementById('searchInput');
    const userTableBody = document.getElementById('userTableBody');

    // ฟังชันกรองตารางเมื่อพิมพ์ข้อความค้นหา
    searchInput.addEventListener('keyup', function () {
        const filter = searchInput.value.toLowerCase();
        const rows = userTableBody.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const username = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
            const email = rows[i].getElementsByTagName('td')[2].textContent.toLowerCase();

            if (username.includes(filter) || email.includes(filter)) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    });
});


function validateAddmemberForm() {
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    

    if (!username || !email || !password) {
        Swal.fire({
            icon: 'error',
            title: 'error',
            text: 'กรุณาใส่ข้อมูลให้ครบ',
        });
        return false; // Prevent form submission
    }
    
    return true; // Allow form submission
}



