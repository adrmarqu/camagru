<script type="module" src="<?= URL_JS . '/header.js'?>?v=<?= filemtime(PUBLIC_PATH . '/js/header.js') ?>"></script>

<?php foreach ($scripts ?? [] as $file): ?>
    <script type="module" src="<?= URL_JS . $file ?>?v=<?= filemtime(PUBLIC_PATH . '/js' . $file) ?>"></script>
<?php endforeach; ?>