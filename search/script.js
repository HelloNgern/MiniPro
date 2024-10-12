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