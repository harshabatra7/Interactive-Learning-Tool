<?php
// Ensure that the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON input data
    $inputJSON = file_get_contents('php://input');
    // Decode the JSON data
    $input = json_decode($inputJSON);

    // Check if code and language are present in the JSON data
    if (isset($input->code) && isset($input->language)) {
        // Get the code and language
        $code = $input->code;
        $language = $input->language;

        // Determine the filename based on the selected language
        $filename = 'code';
        switch ($language) {
            case 'c':
                $filename = 'main.c';
                
                // Save the code to a file in the same directory
                file_put_contents($filename, $code);
                // Respond with a success message
                http_response_code(200);

                // Compile the C source code
                $compileCommand = "gcc main.c -o main ";
                exec($compileCommand, $compileOutput, $compileStatus);

                // Check if compilation was successful
                if ($compileStatus === 0) {
                    // Compilation successful, now execute the compiled program
                    $runCommand = ".\main.exe 2>&1";
                    exec($runCommand, $runOutput, $runStatus);
                    
                    // Output the result of running the program
                    echo implode("\n", $runOutput);
                } else {
                    // Compilation failed, output compilation errors
                    echo implode("\n", $compileOutput);
                }

                break;
            case 'cpp':
                $filename = 'main.cpp';
                
                // Save the code to a file in the same directory
                file_put_contents($filename, $code);
                // Respond with a success message
                http_response_code(200);

                // Compile the C source code
                $compileCommand = "g++ main.cpp -o main ";
                exec($compileCommand, $compileOutput, $compileStatus);

                // Check if compilation was successful
                if ($compileStatus === 0) {
                    // Compilation successful, now execute the compiled program
                    $runCommand = ".\main.exe ";
                    exec($runCommand, $runOutput, $runStatus);
                    
                    // Output the result of running the program
                    echo implode("\n", $runOutput);
                } else {
                    // Compilation failed, output compilation errors
                    echo implode("\n", $compileOutput);
                }

                break;
            case 'java':
                $filename = 'Main';
                $filename .= '.java';
                // Save the code to a file in the same directory
                file_put_contents($filename, $code);
                // Respond with a success message
                http_response_code(200);

                $compileCommand = "javac Main.java 2>&1";
                exec($compileCommand, $compileOutput, $compileStatus);

                // Check if compilation was successful
                if ($compileStatus === 0) {
                    // Compilation successful, now execute the compiled program
                    $runCommand = "java Main 2>&1";
                    exec($runCommand, $runOutput, $runStatus);
                    
                    // Output the result of running the program
                    echo implode("\n", $runOutput);
                } else {
                    // Compilation failed, output compilation errors
                    echo implode("\n", $compileOutput);
                }
                break;
            case 'python':
                $filename = 'code';
                $filename .= '.py';
                // Save the code to a file in the same directory
                file_put_contents($filename, $code);

                // Respond with a success message
                http_response_code(200);
                

                $output = exec("python code.py");
                echo $output;
                break;
            default:
                http_response_code(400);
                echo 'Unsupported language';
                exit;
        }

        

        





    } else {
        http_response_code(400);
        echo 'Invalid request data';
    }
} else {
    http_response_code(405);
    echo 'Method Not Allowed';
}
?>
