document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form');
  if (!form) return;

  form.addEventListener('submit', (e) => {
    let valid = true;
    const errors = [];

    // Nombre
    const nombre = form.querySelector('input[name="nombre"]');
    if (!nombre.value.trim()) {
      valid = false;
      errors.push('El nombre es obligatorio.');
    }

    // Email
    const email = form.querySelector('input[name="email"]');
    const reEmail = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;
    if (!reEmail.test(email.value.trim())) {
      valid = false;
      errors.push('Email inválido.');
    }

    // Sexo
    if (![...form.querySelectorAll('input[name="sexo"]')].some(r => r.checked)) {
      valid = false;
      errors.push('Selecciona el sexo.');
    }

    // Área
    const area = form.querySelector('select[name="area_id"]');
    if (!area.value) {
      valid = false;
      errors.push('Selecciona un área.');
    }

    // Descripción
    const desc = form.querySelector('textarea[name="descripcion"]');
    if (desc.value.trim().length < 10) {
      valid = false;
      errors.push('Descripción muy breve.');
    }

    // Mostrar/Prevenir
    const prev = document.querySelector('.client-errors');
    if (prev) prev.remove();
    if (!valid) {
      e.preventDefault();
      const div = document.createElement('div');
      div.className = 'client-errors';
      div.innerHTML = '<ul>' + errors.map(msg => `<li>${msg}</li>`).join('') + '</ul>';
      form.prepend(div);
    }
  });
});