<?php

  require_once 'Controller.php';

  final class StudentController extends Controller {

    private $studentModel;

    public function __construct(Student $studentModel) {
      $this->studentModel = $studentModel;
    }

    public function getStudentInfo(int $idStudent): ?array {
      $student = $this->studentModel->getStudent($idStudent);
      if (is_null($student)) {
        return null;
      }
      $boardData = ($student['board'] === 'CSM') ? $this->getCsmStudent($student) : $this->getCsmbStudent($student);
      return [
        'data' => [
          'id' => $idStudent,
          'name' => $student['name'],
          'grades' => implode(',',$student['grades']),
          'average' => $boardData['average'],
          'passed' => $boardData['passed']
        ],
        'format' => $boardData['format']
      ];
    }

    private function getCsmStudent(array $student) {
      $gradeNumber = count($student['grades']);
      $sum = 0;
      foreach ($student['grades'] as $grade) {
        $sum += $grade;
      }
      $average = $sum / $gradeNumber;
      $passed = $average >= 7 ? 'Pass' : 'Fail';
      $format = 'JSON';
      return [
        'average' => $average,
        'passed' => $passed,
        'format' => $format
      ];
    }

    private function getCsmbStudent(array $student) {
      $gradeNumber = count($student['grades']);
      $format = 'XML';
      $min = 0;
      $max = 0;
      $sum = 0;
      foreach ($student['grades'] as $grade) {
        if ($grade > $max) {
          $max = $grade;
        }
        if ($grade < $min) {
          $min = $grade;
        }
        $sum += $grade;
      }
      if ($gradeNumber > 2) {
        $sum -= $min;
      }
      $average = $sum / $gradeNumber;
      $passed = ($max > 8) ? 'Pass' : 'Fail';
      return [
        'average' => $average,
        'passed' => $passed,
        'format' => $format
      ];
    }

  }
