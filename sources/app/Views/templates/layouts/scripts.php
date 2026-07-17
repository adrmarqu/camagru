<script type="module" src="<?= URL_JS . '/header.js'?>?v1"></script>

<?php foreach ($scripts ?? [] as $file): ?>
    <script type="module" src="<?= URL_JS . $file ?>?v1"></script>
<?php endforeach; ?>