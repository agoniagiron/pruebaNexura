<?php
// views/form.php
$title = isset($item) ? 'Editar empleado' : 'Crear empleado';
include __DIR__ . '/plantillas/header.php';
?>

<div class="card shadow-sm">
  <div class="card-body">
    <h1 class="card-title mb-4"><?= $title ?></h1>

    <?php if ($success): ?>
      <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="alert alert-info">
      Los campos con <span class="text-danger">*</span> son obligatorios
    </div>

    <form method="post" action="?action=<?= isset($item) ? 'update' : 'store' ?>">
      <?php if (isset($item)): ?>
        <input type="hidden" name="id" value="<?= $item['id'] ?>">
      <?php endif; ?>

      <!-- Nombre completo -->
      <div class="mb-3">
        <label class="form-label">Nombre completo <span class="text-danger">*</span></label>
        <input
          type="text"
          name="nombre"
          class="form-control"
          placeholder="Nombre completo del empleado"
          value="<?= htmlspecialchars($item['nombre'] ?? '') ?>"
          required
        >
      </div>

      <!-- Correo electrónico -->
      <div class="mb-3">
        <label class="form-label">Correo electrónico <span class="text-danger">*</span></label>
        <input
          type="email"
          name="email"
          class="form-control"
          placeholder="Correo electrónico"
          value="<?= htmlspecialchars($item['email'] ?? '') ?>"
          required
        >
      </div>

      <!-- Sexo -->
      <div class="mb-3">
        <label class="form-label d-block">Sexo <span class="text-danger">*</span></label>
        <div class="form-check form-check-inline">
          <input
            class="form-check-input"
            type="radio"
            name="sexo"
            id="sexoM"
            value="M"
            <?= (isset($item) && $item['sexo']==='M') ? 'checked' : '' ?>
            required
          >
          <label class="form-check-label" for="sexoM">Masculino</label>
        </div>
        <div class="form-check form-check-inline">
          <input
            class="form-check-input"
            type="radio"
            name="sexo"
            id="sexoF"
            value="F"
            <?= (isset($item) && $item['sexo']==='F') ? 'checked' : '' ?>
            required
          >
          <label class="form-check-label" for="sexoF">Femenino</label>
        </div>
      </div>

      <!-- Área con botón modal -->
      <div class="mb-3">
        <label class="form-label">Área <span class="text-danger">*</span></label>
        <div class="input-group">
          <select name="area_id" class="form-select" required>
            <option value="">Selecciona...</option>
            <?php foreach ($areas as $area): ?>
              <option
                value="<?= $area['id'] ?>"
                <?= (isset($item) && $item['area_id']===$area['id']) ? 'selected' : '' ?>
              ><?= htmlspecialchars($area['nombre']) ?></option>
            <?php endforeach; ?>
          </select>
          <button
            type="button"
            class="btn btn-outline-secondary"
            data-bs-toggle="modal"
            data-bs-target="#areaModal"
            title="Crear nueva área"
          >
            <i class="bi bi-plus-lg"></i>
          </button>
        </div>
      </div>

      <!-- Descripción -->
      <div class="mb-3">
        <label class="form-label">Descripción <span class="text-danger">*</span></label>
        <textarea
          name="descripcion"
          class="form-control"
          rows="4"
          placeholder="Descripción de la experiencia del empleado"
          required
        ><?= htmlspecialchars($item['descripcion'] ?? '') ?></textarea>
      </div>

      <!-- Boletín -->
      <div class="form-check mb-4">
        <input
          class="form-check-input"
          type="checkbox"
          name="boletin"
          id="boletin"
          value="1"
          <?= !empty($item['boletin']) ? 'checked' : '' ?>
        >
        <label class="form-check-label" for="boletin">
          Deseo recibir boletín informativo
        </label>
      </div>

      <!-- Roles -->
      <div class="mb-4">
        <label class="form-label d-block">Roles <span class="text-danger">*</span></label>
        <?php foreach ($roles as $rol): ?>
          <div class="form-check">
            <input
              class="form-check-input"
              type="checkbox"
              name="roles[]"
              id="rol<?= $rol['id'] ?>"
              value="<?= $rol['id'] ?>"
              <?= !empty($item_roles) && in_array($rol['id'], $item_roles) ? 'checked' : '' ?>
            >
            <label class="form-check-label" for="rol<?= $rol['id'] ?>">
              <?= htmlspecialchars($rol['nombre']) ?>
            </label>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Botones -->
      <button type="submit" class="btn btn-primary me-2">
        <?= isset($item) ? 'Actualizar' : 'Guardar' ?>
      </button>
      <a href="index.php" class="btn btn-link">Cancelar</a>
    </form>
  </div>
</div>

<!-- Modal para crear nueva Área -->
<div class="modal fade" id="areaModal" tabindex="-1" aria-labelledby="areaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="?action=store_area" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="areaModalLabel">Crear nueva Área</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="nueva_area" class="form-label">Nombre del área</label>
          <input
            type="text"
            id="nueva_area"
            name="nombre_area"
            class="form-control"
            placeholder="Ej. Calidad"
            required
          >
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar Área</button>
      </div>
    </form>
  </div>
</div>

<?php include __DIR__ . '/plantillas/footer.php';
