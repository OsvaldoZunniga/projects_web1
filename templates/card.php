<div class="col-md-3">
  <?php if (!empty($item['link'])): ?>
    <a href="<?= htmlspecialchars($item['link']) ?>" class="text-decoration-none">
  <?php endif; ?>
  
  <div class="card shadow border-0 h-100 <?= !empty($item['link']) ? 'card-clickable' : '' ?>" 
       style="border-radius: 0.8rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15), 0 1px 3px rgba(0, 0, 0, 0.1) !important; transition: transform 0.2s, box-shadow 0.2s;">
    <?php if (!empty($item['imagen'])): ?>
      <img src="../<?= htmlspecialchars($item['imagen']) ?>" 
           class="card-img-top" 
           alt="<?= htmlspecialchars($item['titulo']) ?>"
           style="height: 200px; object-fit: cover; border-radius: 0.8rem 0.8rem 0 0;">
    <?php endif; ?>
    <div class="card-body text-center">
      <h5 class="fw-bold mb-3" style="color: #1A281E;">
        <?= htmlspecialchars($item['titulo']) ?>
      </h5>
      <?php if (!empty($item['campos'])): ?>
        <?php foreach($item['campos'] as $label => $valor): ?>
          <p class="text-muted mb-1">
            <strong><?= htmlspecialchars($label) ?>:</strong> <?= htmlspecialchars($valor) ?>
          </p>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
  
  <?php if (!empty($item['link'])): ?>
    </a>
  <?php endif; ?>
</div>

