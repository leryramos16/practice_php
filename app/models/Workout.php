<?php 

class Workout
{
       private $db;
    
       public function __construct()
       {
            $this->db = (new Database())->connect();
       }

       public function getAllByUser($user_id)
       {
            $sql = "SELECT * FROM workouts WHERE user_id = ? ORDER BY date DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

          // Format the 'date' column for each row
          foreach ($results as &$row) {
               $row['formatted_date'] = date("F j, Y", strtotime($row['date']));
          }
          
          return $results;
       }

       public function add($user_id, $exercise, $reps, $sets)
       {
            $sql = "INSERT INTO workouts (user_id, exercise, reps, sets, date)
                    VALUES (?, ?, ?, ?, NOW())";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$user_id, $exercise, $reps, $sets]);
       }

       public function delete($id)
       {
            $sql = "DELETE FROM workouts WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
       }

       public function countThisWeek($user_id)
       {
          $sql = "SELECT COUNT(*) AS total_workouts
                  FROM workouts
                  WHERE user_id = ?
                  AND YEARWEEK(date, 1) = YEARWEEK(CURDATE(), 1)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ? $result['total_workouts'] : 0;
           
       }

       public function getFavoriteExercise($user_id)
       {
          $sql = "SELECT exercise, COUNT(*) AS count
                  FROM workouts
                  WHERE user_id = ?
                  GROUP BY exercise
                  ORDER by count DESC
                  LIMIT 1";
          $stmt = $this->db->prepare($sql);
          $stmt->execute([$user_id]);
          return $stmt->fetch(PDO::FETCH_ASSOC);
       }

       public function getByUserPaginated($user_id, $limit, $offset)
       {
          $sql = "SELECT * FROM workouts WHERE user_id = ? ORDER BY date DESC LIMIT $limit OFFSET $offset";
          $stmt = $this->db->prepare($sql);
          $stmt->execute([$user_id]);
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

          foreach ($results as &$row) {
               $row['formatted_date'] = date("F j, Y", strtotime($row['date']));
          }

          return $results;

       }

       public function countAllByUser($user_id)
       {
          $sql = "SELECT COUNT(*) as total FROM workouts WHERE user_id = ?";
          $stmt = $this->db->prepare($sql);
          $stmt->execute([$user_id]);
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          return $result ? $result['total'] : 0;
       }
}