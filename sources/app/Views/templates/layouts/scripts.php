<!-- Common scripts -->
<!-- 
    <script type="module" src="/js/script.js"></script>
    <script type="module" src="/js/header.js"></script>
    ...
-->

<?php foreach ($glob['scripts'] ?? [] as $file): ?>
    <script type="module" src="<?= URL_JS . $file ?>"></script>
<?php endforeach; ?>