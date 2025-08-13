document.addEventListener('DOMContentLoaded', () => {
  const toastEl = document.getElementById('toast');
  const toast = new bootstrap.Toast(toastEl, { autohide: true, delay: 3000 });
  
  fetch('csrf.php')
    .then(response => {
      if (!response.ok) throw new Error('CSRF fetch failed');
      return response.json();
    })
    .then(data => {
      document.getElementById('csrf').value = data.token;
    })
    .catch(error => {
      console.error('CSRF error:', error);
      showToast('Security error. Please refresh the page.', false);
    });

  const form = document.getElementById('registrationForm');
  const submitBtn = document.getElementById('submitBtn');
  const submitText = document.getElementById('submitText');
  const spinner = document.getElementById('spinner');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    submitBtn.disabled = true;
    submitText.textContent = 'Processing...';
    spinner.classList.remove('d-none');
    
    try {
      const formData = new FormData(form);
      const response = await fetch('register.php', {
        method: 'POST',
        body: formData
      });
      
      const result = await response.json();
      
      if (result.success) {
        showToast('Student registered successfully!', true);
        form.reset();
      } else {
        showToast(result.error || 'Registration failed', false);
      }
    } catch (error) {
      console.error('Submission error:', error);
      showToast('Network error. Please try again.', false);
    } finally {

      submitBtn.disabled = false;
      submitText.textContent = 'Register Student';
      spinner.classList.add('d-none');
    }
  });

  function showToast(message, isSuccess) {
    const toastBody = toastEl.querySelector('.toast-body');
    toastBody.textContent = message;
    
    toastEl.classList.toggle('bg-success', isSuccess);
    toastEl.classList.toggle('bg-danger', !isSuccess);
    
    toast.show();
  }
});