
//password toggling
document.addEventListener('DOMContentLoaded', function () {
    var passwordInput = document.getElementById('password');
    var togglePasswordButton = document.getElementById('togglePassword');

    togglePasswordButton.addEventListener('click', function () {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    });
});




console.log("coming")