function togglePassword() {
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirm-password');
    
    if (passwordField) {
        passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
    }
    
    if (confirmPasswordField) {
        confirmPasswordField.type = confirmPasswordField.type === 'password' ? 'text' : 'password';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.input-field');
    inputs.forEach((input, index) => {
        input.style.animationDelay = `${index * 0.1}s`;
        input.classList.add('fadeIn');
    });
});
