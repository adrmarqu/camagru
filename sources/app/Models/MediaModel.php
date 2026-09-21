<?php

class MediaModel extends BaseModel
{
    public function addImage(int $id, string $filename): bool
    {
        $sql = "INSERT INTO photos (filename, user_id) VALUES (:name, :userid)";
        $params = ['name' => $filename, 'userid' => $id];
        return $this->query($sql, $params) === 1;
    }

    public function removeImage(int $userId, string $filename): bool
    {
        $sql = "DELETE FROM photos WHERE user_id = :userid AND filename = :name";
        $params = ['userid' => $userId, 'name' => $filename];
        return $this->query($sql, $params) > 0;
    }
}