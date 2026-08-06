<div class="error-container">
    <h1 class="error-code"><?= $code ?></h1>
    <h2 class="error-title"><?= $titleErr ?></h2>
    <p class="error-message"><?= $message ?></p>
    
    <div class="error-details">
        <p><strong><?= $file ?></strong><?= $file_path ?></p>
        <p><strong><?= $line ?></strong><?= $line_path ?></p>
    </div>
    <a class="error-link" href="<?= $link ?>"><?= $link_label ?></a>
</div>