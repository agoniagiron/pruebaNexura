<?php 
  $title = 'Lista de empleados';
  include __DIR__ . '/plantillas/header.php';
?>
<div class="d-flex align-items-center mb-4">
  <h1 class="me-auto">Lista de empleados</h1>
  <!-- Botón para crear Área -->
  <button 
    class="btn btn-outline-secondary me-2" 
    type="button" 
    data-bs-toggle="modal" 
    data-bs-target="#areaModalList">
    <i class="bi bi-building me-1"></i> Crear Área
  </button>
  <!-- Botón para crear Empleado -->
  <a href="?action=create" class="btn btn-primary">
    <i class="bi bi-plus-circle me-1"></i> Crear Empleado
  </a>
</div>

<?php if ($success): ?>
  <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>
<?php if ($error): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<table class="table table-striped table-hover align-middle">
  <thead class="table-light">
    <tr>
      <th><i class="bi bi-person"></i> Nombre</th>
      <th><i class="bi bi-envelope"></i> Email</th>
      <th><i class="bi bi-gender-ambiguous"></i> Sexo</th>
      <th><i class="bi bi-building"></i> Área</th>
      <th><i class="bi bi-newspaper"></i> Boletín</th>
      <th class="text-center"><i class="bi bi-pencil"></i></th>
      <th class="text-center"><i class="bi bi-trash"></i></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $emp): ?>
      <tr>
        <td><?= htmlspecialchars($emp['nombre']) ?></td>
        <td><?= htmlspecialchars($emp['email']) ?></td>
        <td><?= $emp['sexo']==='M' ? 'Masculino' : 'Femenino' ?></td>
        <td><?= htmlspecialchars($emp['area']) ?></td>
        <td><?= $emp['boletin'] ? 'Sí' : 'No' ?></td>
        <td class="text-center">
          <a href="?action=edit&id=<?= $emp['id'] ?>" class="text-decoration-none">
            <i class="bi bi-pencil-square"></i>
          </a>
        </td>
        <td class="text-center">
          <a href="?action=delete&id=<?= $emp['id'] ?>"
             onclick="return confirm('¿Eliminar este empleado?')"
             class="text-danger text-decoration-none">
            <i class="bi bi-trash-fill"></i>
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<div class="modal fade" id="areaModalList" tabindex="-1" aria-labelledby="areaModalListLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="?action=store_area" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="areaModalListLabel">Crear nueva Área</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="nueva_area" class="form-label">Nombre del área</label>
          <input 
            type="text" 
            class="form-control" 
            id="nueva_area" 
            name="nombre_area" 
            placeholder="Ej. Calidad" 
            required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar Área</button>
      </div>
    </form>
  </div>
</div>

<?php include __DIR__ . '/plantillas/footer.php'; ?>
