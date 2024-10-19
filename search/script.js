let dropdownBtn = document.getElementById("drop-text");
let list = document.getElementById("list");
let icon = document.getElementById("icon");
let span = document.getElementById("span");
let input = document.getElementById("search-input");
let listItems = document.querySelectorAll(".dropdown-list-item");

//show dropddown list on click on dropdown btn
dropdownBtn.onclick = function() {
    //rotate arrow icon
    if(list.classList.contains('show')) {
        icon.style.rotate = "0deg";
    }else{
        icon.style.rotate = "-180deg";
    }
    list.classList.toggle("show");
    
};

//hide dropdown list when clicked outside dropdown btn
window.onclick = function(e) {
    if(
        e.target.id !== "drop-text" &&
        e.target.id !== "span" &&
        e.target.id !== "icon" 
    ) {
        list.classList.remove("show");
        icon.style.rotate = "0deg";
    }
};

for (item of listItems) {
    item.onclick = function (e) {
        //change dropdown btn text on click on selected list item
        span.innerText = e.target.innerText;

        //change input placeholder text on selected list item
        if(e.target.innerText == "สิ่งที่ต้องทำ!") {
            input.placeholder = "ค้นหา สิ่งที่ต้องทำ...";
        }else {
            input.placeholder = "ค้นหา ใน  " + e.target.innerText + "...";
        }
    };
}

document.getElementById('search-button').addEventListener('click', function() {
    const status = document.querySelector('.dropdown-list-item.selected')?.getAttribute('data-status');
    const searchTerm = document.getElementById('search-input').value;

    // ทำการส่งข้อมูลไปยัง backend
    fetch(`search.php?status=${status}&term=${encodeURIComponent(searchTerm)}`)
        .then(response => response.json())
        .then(data => {
            // ทำการแสดงผลข้อมูลที่ค้นหาได้ที่นี่
            console.log(data); // หรือทำการแสดงใน UI ตามต้องการ
        });
});

window.addEventListener('load', function() {
    // ดึงค่า status จาก URL
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const searchTerm = urlParams.get('term');

    // ถ้ามีค่าที่เลือกแล้วให้แสดงค่านั้น
    if (status) {
        const savedStatus = document.querySelector(`.dropdown-list-item[data-status='${status}']`);
        if (savedStatus) {
            document.getElementById('span').textContent = savedStatus.textContent;
            savedStatus.classList.add('selected');
        }
    }

    // กรอกคำค้นหาลงในกล่อง search-input ถ้ามี
    if (searchTerm) {
        document.getElementById('search-input').value = decodeURIComponent(searchTerm);
    }
});
