<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csvFile'])) {
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($_FILES['csvFile']['name']);
    
    // Create upload directory if not exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    if (move_uploaded_file($_FILES['csvFile']['tmp_name'], $uploadFile)) {
        echo "File successfully uploaded.\n";
        
        // Function to convert CSV to JSON
        function csvToJson($inputFile) {
            if (!file_exists($inputFile) || !is_readable($inputFile)) {
                return false;
            }

            $data = array();
            if (($handle = fopen($inputFile, 'r')) !== false) {
                $header = fgetcsv($handle);
                while (($row = fgetcsv($handle)) !== false) {
                    $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }

            return json_encode($data, JSON_PRETTY_PRINT);
        }

        $json = csvToJson($uploadFile);
        if ($json !== false) {
            // Output JSON to the browser
            header('Content-Type: application/json');
            echo $json;

            // Optionally, save the JSON to a file
            $jsonFile = $uploadDir . pathinfo($uploadFile, PATHINFO_FILENAME) . '.json';
            file_put_contents($jsonFile, $json);
            echo "\nJSON file created: <a href='$jsonFile'>$jsonFile</a>";
        } else {
            echo "An error occurred during the conversion.";
        }
    } else {
        echo "File upload failed.";
    }
} else {
    echo "Invalid request.";
}
?>
