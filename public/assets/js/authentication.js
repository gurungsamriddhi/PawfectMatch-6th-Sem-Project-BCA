document.addEventListener('DOMContentLoaded', () => {

  // 🔁 Reusable function for clearing invalid input feedback
  function setupInputValidationCleanup(form) {
    if (!form) return;
    const inputs = form.querySelectorAll('input');
    inputs.forEach(input => {
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

  // 🔁 Reusable function for password visibility toggle
  function setupPasswordToggle(checkboxId, inputIds = []) {
    const checkbox = document.getElementById(checkboxId);
    if (!checkbox) return;

    checkbox.addEventListener('change', function () {
      inputIds.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
          input.type = this.checked ? 'text' : 'password';
        }
      });
    });
  }

  // 👉 Register form setup
  const registerForm = document.getElementById('registerForm');
  setupInputValidationCleanup(registerForm);
  setupPasswordToggle('showPasswordCheck', ['passwordReg', 'confirmPasswordReg']);

  if (registerForm) {
    registerForm.addEventListener('submit', function (e) {
      const password = document.getElementById('passwordReg')?.value.trim();
      const confirmPassword = document.getElementById('confirmPasswordReg')?.value.trim();
      const mismatchMessage = document.getElementById('passwordMismatch');

      if (mismatchMessage) mismatchMessage.style.display = 'none';

      if (password !== confirmPassword) {
        e.preventDefault();
        if (mismatchMessage) mismatchMessage.style.display = 'block';
      }
    });
  }

  //Login form setup
  setupInputValidationCleanup(document.getElementById('loginForm'));
  setupPasswordToggle('ShowLoginPasswordCheck', ['loginPassword']);

  //Admin login form setup
  setupInputValidationCleanup(document.getElementById('adminLoginForm'));
  setupPasswordToggle('showAdminPasswordCheck', ['adminPassword']);

  // Adoption center login form setup
  setupInputValidationCleanup(document.getElementById('centerLoginForm'));
  setupPasswordToggle('showCenterPasswordCheck', ['centerPassword']);
});
