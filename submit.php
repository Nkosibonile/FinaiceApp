<?php
// require_once 'PHPExcel/ioncube/loader-wizard.php';
require 'vendor/autoload.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $dob = $_POST["dob"];

    // Validate first name
    if (empty($firstname)) {
      echo "First name is required.<br>";
    }

    // Validate last name
    if (empty($lastname)) {
      echo "Last name is required.<br>";
    }

    // Validate date of birth
    if (empty($dob)) {
      echo "Date of birth is required.<br>";
    } else {
      $dob = date("Y-m-d", strtotime($dob));
      $current_date = date("Y-m-d");
      $date1 = new DateTime($dob);
      $date2 = new DateTime($current_date);
      $interval = $date1->diff($date2);
      if ($interval->y < 18) {
        echo "You must be at least 18 years old.<br>";
      }
    }

    // handle excel file
    if (empty($_FILES["financial_statement"]["name"])) {
      echo "Financial statement is required.<br>";
    } else {
      $target_dir = "uploads/";
      $target_file = $target_dir . basename($_FILES["financial_statement"]["name"]);
      $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

      if ($file_type != "xlsx") {
        echo "Sorry, only xlsx files are allowed.<br>";
      } else {
        if (move_uploaded_file($_FILES["financial_statement"]["tmp_name"], $target_file)) {
          echo "The file ". basename( $_FILES["financial_statement"]["name"]). " has been uploaded.<br>";
          // Read the data from the excel file and draw the graph here
            $inputFileName = 'uploads/' . $_FILES["financial_statement"]["name"];

            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch(Exception $e) {
                die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
            }

            $sheet = $objPHPExcel->getSheet(0); 
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();

            $data = array();
            for ($row = 1; $row <= $highestRow; $row++){ 
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                                NULL,
                                                TRUE,
                                                FALSE);
                array_push($data, $rowData[0]);
            }

        } else {
          echo "Sorry, there was an error uploading your file.<br>";
        }
      }
    }
  }
?>
