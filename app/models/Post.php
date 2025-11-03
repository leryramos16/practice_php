<?php 

class Post
{
    private $db;

      public function __construct()
    {
        $this->db =(new Database())->connect();
    }

     // create post
    public function create($user_id, $caption, $image)
    {
        $sql = "INSERT INTO post (user_id, caption, image) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$user_id, $caption, $image]);
    }

}