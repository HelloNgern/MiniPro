// แสดง/ซ่อนฟอร์มเพิ่ม Event เมื่อกดปุ่ม
document.getElementById('addEventButton').addEventListener('click', function() {
    var form = document.getElementById('eventForm');
    form.style.display = form.style.display === 'block' ? 'none' : 'block';
});

// การเปลี่ยนสีไอคอนหัวใจเมื่อกด
document.getElementById('likeIcon').addEventListener('click', function() {
    var icon = document.getElementById('likeIcon');
    var checkbox = document.getElementById('likeEvent');
    if (icon.classList.contains('liked')) {
        icon.classList.remove('liked');
        checkbox.checked = false; // ไม่ชอบแล้ว
    } else {
        icon.classList.add('liked');
        checkbox.checked = true; // ชอบกิจกรรมนี้
    }
});
