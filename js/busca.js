document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form');
  if (form) {
    form.addEventListener('submit', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }
});
