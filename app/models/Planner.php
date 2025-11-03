<?php 

class Planner
{
    private $db;

    public function __construct()
    {
        $this->db =(new Database())->connect();

    }

    public function getAllByUser($user_id)
    {
        $sql = "SELECT * FROM tasks WHERE user_id = ? ORDER by task_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($user_id, $task_name, $time_to_prepare, $task_date, $note)
    {
        $sql = "INSERT INTO tasks (user_id, task_name, time_to_prepare, task_date, note)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$user_id, $task_name, $time_to_prepare, $task_date, $note]);

    }

    public function delete($id)
    {
        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    //pang mark as done function
    public function markAsDone($id)
    {
        $sql = "UPDATE tasks SET status = 'done' WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}