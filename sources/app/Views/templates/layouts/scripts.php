<?php foreach ($global['scripts'] ?? [] as $file): ?>
    <script type="module" src="<?= URL_JS . $file ?>?v1"></script>
<?php endforeach; ?>

<?php foreach ($scripts_bonus ?? [] as $file): ?>
    <script type="module" src="<?= URL_JS . $file ?>?v1"></script>
<?php endforeach; ?>