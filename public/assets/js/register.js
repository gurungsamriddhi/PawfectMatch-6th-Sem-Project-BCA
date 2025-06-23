


document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('registerForm');
  const showPasswordCheck = document.getElementById('showPasswordCheck');

  if (form) {
    form.addEventListener('submit', function (e) {
      const password = document.getElementById('passwordReg')?.value.trim();
      const confirmPassword = document.getElementById('confirmPasswordReg')?.value.trim();
      const mismatchMessage = document.getElementById('passwordMismatch');

      // Reset previous error
      if (mismatchMessage) mismatchMessage.style.display = 'none';

      // Validate password match
      if (password !== confirmPassword) {
        e.preventDefault();
        if (mismatchMessage) mismatchMessage.style.display = 'block';
      }
    });

     const inputs = form.querySelectorAll('input');

    inputs.forEach(input => {
      input.addEventListener('input', () => {
        if (input.classList.contains('is-invalid')) {
          input.classList.remove('is-invalid');//remove red border or error style
          const feedback = input.nextElementSibling;
          if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.style.display = 'none';// hide the error message
          }
        }
      });
    });
  }

  if (showPasswordCheck) {
    showPasswordCheck.addEventListener('change', function () {
      const passwordField = document.getElementById('passwordReg');
      const confirmPasswordField = document.getElementById('confirmPasswordReg');

      if (passwordField && confirmPasswordField) {
        const type = this.checked ? 'text' : 'password'; //if checkbox checked, show password as text,else hide it
        passwordField.type = type;
        confirmPasswordField.type = type;
      }
    });
  }


   const loginForm = document.getElementById('loginForm');
  const ShowLoginPasswordCheck = document.getElementById('ShowLoginPasswordCheck');

  if (loginForm) {
    const loginInputs = loginForm.querySelectorAll('input');
    loginInputs.forEach(input => {
      input.addEventListener('input', () => {
        if (input.classList.contains('is-invalid')) {
          input.classList.remove('is-invalid');
          const feedback = input.nextElementSibling;
          if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.style.display = 'none';
          }
        }
      });
    });
  }

  if (ShowLoginPasswordCheck) {
    ShowLoginPasswordCheck.addEventListener('change', function () {
      const loginPassword = document.getElementById('loginPassword');
      if (loginPassword) {
        loginPassword.type = this.checked ? 'text' : 'password';
      }
    });
  }
});
