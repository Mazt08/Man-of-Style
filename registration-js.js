

function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const passwordToggle = document.querySelector('.show-password i');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordToggle.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        passwordToggle.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
