<?php

class ImageController
{
    private string $folder;

    public function __construct()
    {
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
        $type = $this->getImageType($route);

        switch ($type)
        {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($route);
                break;
            case 'image/png':
                $image = imagecreatefrompng($route);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($route);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($route);
                break;
            case 'image/avif':
                $image = imagecreatefromavif($route);
                break;
            case 'image/bmp':
                $image = imagecreatefrombmp($route);
                break;
            default:
                throw new FormException(400, Lang::t('500.format'));
        }

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

    public function upload(): void
    {

    }
}