function validateRegisterForm() {
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirm_password = document.getElementById('confirm-password').value;

    // ตรวจสอบว่าฟิลด์ทั้งหมดกรอกข้อมูลหรือไม่
    if (username === '' || email === '' || password === '' || confirm_password === '') {
        Swal.fire({
            title: 'Error!',
            text: 'กรุณากรอกข้อมูลให้ครบทุกช่อง',
            icon: 'error',
            confirmButtonText: 'ตกลง'
        });
        return false;
    }

    // ตรวจสอบว่ารหัสผ่านตรงกันหรือไม่
    if (password !== confirm_password) {
        Swal.fire({
            title: 'Error!',
            text: 'รหัสผ่านไม่ตรงกัน กรุณาลองใหม่อีกครั้ง',
            icon: 'error',
            confirmButtonText: 'ตกลง'
        });
        return false;
    }

    // ถ้าทุกอย่างถูกต้อง
    return true;
}


function validateLoginForm() {
    const username = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;

    // ตรวจสอบว่าฟิลด์ทั้งหมดกรอกข้อมูลหรือไม่
    if (username === '' || password === '') {
        Swal.fire({
            title: 'Error!',
            text: 'กรุณากรอกข้อมูลให้ครบทุกช่อง',
            icon: 'error',
            confirmButtonText: 'ตกลง'
        });
        return false;
    }

    // ถ้าทุกอย่างถูกต้อง
    return true;
}





