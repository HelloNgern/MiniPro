// แสดง/ซ่อนฟอร์มเพิ่ม Event เมื่อกดปุ่ม
document.getElementById('addEventButton').addEventListener('click', function() {
    var form = document.getElementById('eventForm');
    form.style.display = form.style.display === 'block' ? 'none' : 'block';
});

// การเปลี่ยนสีไอคอนหัวใจเมื่อกด
