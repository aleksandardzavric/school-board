<?php

  require_once 'Model.php';

  class Student extends Model {

    public function __construct(Database $db) {
      parent::__construct($db);
    }

    public function getStudent(int $idStudent): ?array {
      $sqlBasicInfo = 'SELECT name,board FROM students WHERE id=?';
      $studentsData = $this->db->query($sqlBasicInfo,'i',$idStudent);
      if ($studentsData->num_rows === 1) {
        $student = mysqli_fetch_assoc($studentsData);
        $sqlGrades = 'SELECT id,grade FROM grades WHERE student_id=?';
        $student['grades'] = [];
        $gradesData = $this->db->query($sqlGrades,'i',$idStudent);
        while ($grade = $gradesData->fetch_assoc()) {
          $student['grades'][] = $grade;
        }
        return $student;
      }
      return null;
    }

  }
