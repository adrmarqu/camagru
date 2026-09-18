<?php

class ImageController
{
    private string $folder;

    public function __construct()
    {
        if (!isset($_SESSION['user']['id']))
            throw new FormException(401);
        if (!isset($_SESSION['user']['folder']))
            throw new FormException(500, Lang::t('500.no_folder'));

        $this->folder = $_SESSION['user']['folder'];
    }

    private function createFolder(string $name = "avatar"): void
    {
        $folder = $this->folder;
        $route = PUBLIC_PATH . "/uploads/$folder/$name";
        if (!is_dir($route) && !mkdir($route, 0755, true))
            throw new FormException(500, Lang::t('500.folder'));
    }

    private function getImageType(string $route): string
    {
        $info = getimagesize($route);
        if ($info === false)
            throw new FormException(400, Lang::t('400.not_image'));

        return $info['mime'];
    }

    private function convertImage(string $route): GdImage
    {
        if (!file_exists($route))
            throw new FormException(400, Lang::t('400.not_image'));

        $data = file_get_contents($route);
        // @ to remove warnings
        $image = @imagecreatefromstring($data);

        if ($image === false)
            throw new FormException(400, Lang::t('400.not_image'));

        return $image;
    }

    private function convertBase64(string $base64String): GdImage
    {
        // Remove header
        $data = explode(',', $base64String)[1] ?? $base64String;
        $binaryData = base64_decode($data);

        if ($binaryData === false)
            throw new FormException(400, Lang::t('400.not_image'));

        // Convert to GdImage
        $image = imagecreatefromstring($binaryData);

        if ($image === false)
            throw new FormException(400, Lang::t('400.not_image'));

        return $image;
    }

    private function saveImage(GdImage $image, string $path): void
    {
        if (imagewebp($image, $path, 80) === false)
            throw new FormException(500, Lang::t('500.save_image'));
        imagedestroy($image);
    }

    private function activateTransparence(GdImage $image): void
    {
        imagealphablending($image, true);
        imagesavealpha($image, true);
    }

    private function getImage(string $url): string
    {
        $filename = basename(parse_url($url, PHP_URL_PATH));
        $path = rtrim(STICKER_PATH, '/') . '/' . $filename;
        if (!file_exists($path))
            throw new FormException(400, Lang::t('400.not_image'));

        return $path;
    }

    private function scaleImage(GdImage $sticker, float $size, float $scaleRatio, float $baseWidth = 120.0): GdImage
    {
        $origW = imagesx($sticker);
        $origH = imagesy($sticker);
        $aspectRatio = $origH / $origW;

        $targetW = max(1, (int)round($baseWidth * $size * $scaleRatio));
        $targetH = max(1, (int)round($targetW * $aspectRatio));

        $scaled = imagescale($sticker, $targetW, $targetH);
        if ($scaled === false)
            throw new FormException(500, Lang::t('500.save_image'));

        $this->activateTransparence($scaled);
        imagedestroy($sticker);

        return $scaled;
    }

    private function rotateImage(GdImage $scaled, float $rotation): GdImage
    {
        if ((int)$rotation !== 0)
        {
            $trans = imagecolorallocatealpha($scaled, 0, 0, 0, 127);
            
            $rotated = imagerotate($scaled, -$rotation, $trans);
            if ($rotated === false)
                throw new FormException(500, Lang::t('500.save_image'));

            $this->activateTransparence($rotated);
            imagedestroy($scaled);

            return $rotated;
        }
        return $scaled;
    }

    /* From profile */
    public function changeAvatar(string $tmpRoute): string
    {
        $image = $this->convertImage($tmpRoute);

        // Create directory if its necesary
        $this->createFolder();

        $folder = $this->folder;
        $path = PUBLIC_PATH . "/uploads/$folder/avatar/avatar.webp";

        $this->saveImage($image, $path);

        return "/uploads/$folder/avatar/avatar.webp?v=" . time();
    }

    /* From photo-editor */
    public function upload(string $base64Image, array $stickers, ?array $stage = null): string
    {
        $image = $this->convertBase64($base64Image);
        $this->activateTransparence($image);

        $baseW = imagesx($image);
        $baseH = imagesy($image);

        $stageW = (!empty($stage['width']) && (float)$stage['width'] > 0) ? (float)$stage['width'] : (float)$baseW;
        $stageH = (!empty($stage['height']) && (float)$stage['height'] > 0) ? (float)$stage['height'] : (float)$baseH;

        $scaleRatio = $baseW / $stageW;

        foreach ($stickers as $st)
        {
            $name = $st['name'];
            $x = (float)$st['x'];
            $y = (float)$st['y'];
            $size = (float)($st['size'] ?? 1.0);
            $rotation = (float)($st['rotation'] ?? 0.0);
            $baseWidth = (float)($st['width'] ?? 120.0);

            // Get sticker path
            $stickerPath = $this->getImage($name);
            // Convert to GdImage
            $sticker = $this->convertImage($stickerPath);
            // Transparence
            $this->activateTransparence($sticker);
            // Scale image
            $scaled = $this->scaleImage($sticker, $size, $scaleRatio, $baseWidth);
            // Rotate image
            $rotated = $this->rotateImage($scaled, $rotation);

            // Calculate centered position on base image
            $posX = ($stageW / 2 + $x) * $scaleRatio - (imagesx($rotated) / 2);
            $posY = ($stageH / 2 + $y) * $scaleRatio - (imagesy($rotated) / 2);

            // Fuse images
            imagecopy(
                $image, 
                $rotated, 
                (int)round($posX), 
                (int)round($posY), 
                0, 
                0, 
                imagesx($rotated), 
                imagesy($rotated)
            );
            // Clean memory
            imagedestroy($rotated);
        }

        $this->createFolder('media');
        // Generate new unique name
        $filename = bin2hex(random_bytes(16)) . '.webp';

        $pdo = Database::getConnection();
        try
        {
            $pdo->beginTransaction();

            // Save image in server
            $folder = $this->folder;
            $path = PUBLIC_PATH . "/uploads/$folder/media/$filename";
            $this->saveImage($image, $path);
            
            // Insert image to db
            $media = new MediaModel();
            if (!$media->addImage($_SESSION['user']['id'], $filename))
                throw new FormException(500, Lang::t('500.db'));

            $pdo->commit();
        }
        catch (Throwable $e)
        {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
        
        return "/uploads/$folder/media/$filename";
    }
}