<?php

  if (!isset($_GET['student'])) {
    exit(1);
  }

  $student = $_GET['student'];
  if ((int)$student > 0) {
    require_once 'database.php';
    require_once 'config/database.php';
    require_once 'Controllers/StudentController.php';
    require_once 'Models/Student.php';

    $db = new Database($config['db']);
    $studentModel = new Student($db);
    $studentController = new StudentController($studentModel);
    $studentData = $studentController->getStudentInfo($student);
    if (is_null($studentData)) {
      return;
    }
    if ($studentData['format'] === 'XML') {
      header("Content-type: text/xml; charset=utf-8");
      print arrayToXml($studentData['data']);
    } else {
      header('Content-Type: application/json');
      echo json_encode($studentData['data']);
    }
  }
