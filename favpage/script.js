function toggleMenu() {
    var menu = document.getElementById("menu"); // เข้าถึงเมนูด้วย id="menu"
    menu.classList.toggle("show"); // สลับการเพิ่ม/ลบ class "show" เพื่อแสดงหรือซ่อนเมนู
}

 // ตัวอย่างข้อมูลผู้ใช้ที่สามารถดึงมาจาก backend
 const user = {
    id: '12345',
    name: 'John Doe',
    profileImage: 'https://via.placeholder.com/100' // ลิงก์ไปยังรูปโปรไฟล์ของผู้ใช้
};

// อัปเดตรูปโปรไฟล์และข้อมูลผู้ใช้ใน HTML
document.getElementById('profile-image').src = user.profileImage;
document.getElementById('username').textContent = `Username: ${user.name}`;
document.getElementById('user-id').textContent = `User ID: ${user.id}`;

// Function to render favorite items from localStorage
function renderFavorites() {
    const favoriteList = document.getElementById('favorite-list');
    favoriteList.innerHTML = ''; // Clear existing list

    // Get the favorites from localStorage
    let favorites = JSON.parse(localStorage.getItem('favorites')) || [];

    // Check if there are any favorites
    if (favorites.length === 0) {
        favoriteList.innerHTML = '<p>ไม่มีรายการโปรด</p>'; // Show a message if no favorites
        return;
    }

    // Render each favorite activity
    favorites.forEach((activity, index) => {
        const listItem = document.createElement('li');

        const circle = document.createElement('div');
        circle.classList.add('circle');

        const activityName = document.createElement('span');
        activityName.textContent = `${activity.name} (Start: ${activity.start}, End: ${activity.end})`;

        const heart = document.createElement('span');
        heart.classList.add('heart');
        heart.textContent = '❤️';

        // Add event listener to remove favorite
        heart.addEventListener('click', () => removeFavorite(index));

        listItem.appendChild(circle);
        listItem.appendChild(activityName);
        listItem.appendChild(heart);

        favoriteList.appendChild(listItem);
    });
}

// Function to remove a favorite item
function removeFavorite(index) {
    let favorites = JSON.parse(localStorage.getItem('favorites')) || [];
    favorites.splice(index, 1); // Remove the item from the array
    localStorage.setItem('favorites', JSON.stringify(favorites)); // Update localStorage
    renderFavorites(); // Re-render the list
}

// Call the function to render favorites on page load
window.onload = renderFavorites;


// Example data from previous page (replace with dynamic data from your app)
let favorites = [
    { name: 'Data Communication', isFavorite: true },
    { name: 'Math', isFavorite: true }
];

// // Function to render favorite items
// function renderFavorites() {
//     const favoriteList = document.getElementById('favorite-list');
//     favoriteList.innerHTML = ''; // Clear existing list

//     // Check if there are any favorites left
//     if (favorites.length === 0) {
//         favoriteList.innerHTML = '<p>ไม่มีรายการโปรด</p>'; // Show a message when no favorites
//         return;
//     }

//     favorites.forEach((activity, index) => {
//         const listItem = document.createElement('li');

//         const circle = document.createElement('div');
//         circle.classList.add('circle');

//         const activityName = document.createElement('span');
//         activityName.textContent = activity.name;

//         const heart = document.createElement('span');
//         heart.classList.add('heart');
//         heart.textContent = '❤️';

//         // Add event listener to remove favorite
//         heart.addEventListener('click', () => removeFavorite(index));

//         listItem.appendChild(circle);
//         listItem.appendChild(activityName);
//         listItem.appendChild(heart);

//         favoriteList.appendChild(listItem);
//     });
// }

// // Function to remove a favorite item
// function removeFavorite(index) {
//     favorites.splice(index, 1); // Remove the item from the favorites array
//     renderFavorites(); // Re-render the list to reflect the changes
// }

// // Call the function to render favorites on page load
// window.onload = renderFavorites;
