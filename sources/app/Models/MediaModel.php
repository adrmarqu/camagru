<?php

class MediaModel extends BaseModel
{
    public function addImage(int $id, string $filename): bool
    {
        $sql = "INSERT INTO photos (filename, user_id) VALUES (:name, :userid)";
        $params = ['name' => $filename, 'userid' => $id];
        return $this->query($sql, $params) === 1;
    }

    public function removeImage(int $id): bool
    {

    }


}