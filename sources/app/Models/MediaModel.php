<?php

class MediaModel extends BaseModel
{
    private int $limit = 6;

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

    public function getImages(int $offset = 0, ?int $currentUserId = null): array | false
    {
        $sql = "SELECT 
                    p.id,
                    p.filename,
                    p.created_at,
                    p.user_id,
                    u.username,
                    u.folder,
                    CONCAT('/uploads/', u.folder, '/media/', p.filename) AS src,
                    (SELECT COUNT(*) FROM likes l WHERE l.photo_id = p.id) AS n_likes,
                    (SELECT COUNT(*) FROM comments c WHERE c.photo_id = p.id) AS n_comments,
                    EXISTS(SELECT 1 FROM likes l WHERE l.photo_id = p.id AND l.user_id = :current_user_id) AS user_liked
                FROM photos p
                JOIN users u ON p.user_id = u.id
                ORDER BY p.created_at DESC, p.id DESC
                LIMIT :limit OFFSET :offset";

        $params = [
            'limit'           => $this->limit,
            'offset'          => $offset,
            'current_user_id' => $currentUserId ?? 0
        ];

        return $this->selectAll($sql, $params);
    }

    public function getComments(int $photoid): array | false
    {
        $sql = "SELECT 
                    c.id,
                    c.comment,
                    c.comment AS text,
                    c.user_id,
                    c.photo_id,
                    c.created_at,
                    u.username,
                    u.username AS user
                FROM comments c
                JOIN users u ON c.user_id = u.id
                WHERE c.photo_id = :photoid
                ORDER BY c.created_at ASC, c.id ASC";

        $params = ['photoid' => $photoid];
        return $this->selectAll($sql, $params);
    }

    public function getUserPhotos(int $userId): array | false
    {
        $sql = "SELECT 
                    p.id,
                    p.filename,
                    p.created_at,
                    CONCAT('/uploads/', u.folder, '/media/', p.filename) AS src
                FROM photos p
                JOIN users u ON p.user_id = u.id
                WHERE p.user_id = :userid
                ORDER BY p.created_at DESC, p.id DESC";

        return $this->selectAll($sql, ['userid' => $userId]);
    }

    public function getPrivateImages(int $userId, int $offset = 0): array | false
    {
        $sql = "SELECT 
                    p.id,
                    p.filename,
                    p.created_at,
                    p.user_id,
                    u.username,
                    u.folder,
                    CONCAT('/uploads/', u.folder, '/media/', p.filename) AS src,
                    (SELECT COUNT(*) FROM likes l WHERE l.photo_id = p.id) AS n_likes,
                    (SELECT COUNT(*) FROM comments c WHERE c.photo_id = p.id) AS n_comments,
                    EXISTS(SELECT 1 FROM likes l WHERE l.photo_id = p.id AND l.user_id = :user_id) AS user_liked
                FROM photos p
                JOIN users u ON p.user_id = u.id
                WHERE p.user_id = :user_id
                ORDER BY p.created_at DESC, p.id DESC
                LIMIT :limit OFFSET :offset";

        $params = [
            'limit'   => $this->limit,
            'offset'  => $offset,
            'user_id' => $userId
        ];

        return $this->selectAll($sql, $params);
    }

    public function getFavoriteImages(int $userId, int $offset = 0): array | false
    {
        $sql = "SELECT 
                    p.id,
                    p.filename,
                    p.created_at,
                    p.user_id,
                    u.username,
                    u.folder,
                    CONCAT('/uploads/', u.folder, '/media/', p.filename) AS src,
                    (SELECT COUNT(*) FROM likes l WHERE l.photo_id = p.id) AS n_likes,
                    (SELECT COUNT(*) FROM comments c WHERE c.photo_id = p.id) AS n_comments,
                    1 AS user_liked
                FROM photos p
                JOIN users u ON p.user_id = u.id
                JOIN likes my_like ON my_like.photo_id = p.id AND my_like.user_id = :user_id
                ORDER BY p.created_at DESC, p.id DESC
                LIMIT :limit OFFSET :offset";

        $params = [
            'limit'   => $this->limit,
            'offset'  => $offset,
            'user_id' => $userId
        ];

        return $this->selectAll($sql, $params);
    }

    public function writeComment(int $userid, int $photoid, string $text): int | false
    {
        $sql = "INSERT INTO comments (comment, user_id, photo_id) VALUES (:text, :uid, :pid)";
        $params = ['text' => $text, 'uid' => $userid, 'pid' => $photoid];
        if ($this->query($sql, $params) === 1)
        {
            return (int)$this->lastId();
        }
        return false;
    }

    public function getComment(int $commentid): array | false
    {
        $sql = "SELECT c.*, p.user_id AS photo_author_id 
                FROM comments c 
                JOIN photos p ON c.photo_id = p.id 
                WHERE c.id = :id LIMIT 1";
        return $this->select($sql, ['id' => $commentid]);
    }

    public function deleteComment(int $commentid, ?int $userId = null): bool
    {
        if ($userId === null)
        {
            $sql = "DELETE FROM comments WHERE id = :id LIMIT 1";
            $params = ['id' => $commentid];
            return $this->query($sql, $params) === 1;
        }

        // Allow deletion if user is either comment author OR photo owner
        $sql = "DELETE c FROM comments c
                JOIN photos p ON c.photo_id = p.id
                WHERE c.id = :id AND (c.user_id = :uid OR p.user_id = :uid)";
        $params = ['id' => $commentid, 'uid' => $userId];
        return $this->query($sql, $params) > 0;
    }

    public function hasLiked(int $uid, int $pid): bool
    {
        $sql = "SELECT 1 FROM likes WHERE user_id = :uid AND photo_id = :pid LIMIT 1";
        $res = $this->select($sql, ['uid' => $uid, 'pid' => $pid]);
        return !empty($res);
    }

    public function countLikes(int $pid): int
    {
        $sql = "SELECT COUNT(*) AS total FROM likes WHERE photo_id = :pid";
        $res = $this->select($sql, ['pid' => $pid]);
        return (int)($res['total'] ?? 0);
    }

    public function countComments(int $pid): int
    {
        $sql = "SELECT COUNT(*) AS total FROM comments WHERE photo_id = :pid";
        $res = $this->select($sql, ['pid' => $pid]);
        return (int)($res['total'] ?? 0);
    }

    public function getPhotoOwner(int $pid): array | false
    {
        $sql = "SELECT u.id, u.email, u.username, u.notification_active 
                FROM photos p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.id = :pid LIMIT 1";
        return $this->select($sql, ['pid' => $pid]);
    }

    public function like(int $uid, int $pid): bool
    {
        $sql = "INSERT INTO likes (user_id, photo_id) VALUES (:uid, :pid)";
        $params = ['uid' => $uid, 'pid' => $pid];
        return $this->query($sql, $params) === 1;
    }

    public function deleteLike(int $uid, int $pid): bool
    {
        $sql = "DELETE FROM likes WHERE user_id = :uid AND photo_id = :pid";
        $params = ['uid' => $uid, 'pid' => $pid];
        return $this->query($sql, $params) === 1;
    }
}