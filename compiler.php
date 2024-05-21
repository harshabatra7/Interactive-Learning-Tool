<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Compiler</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.1/codemirror.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.1/codemirror.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.63.1/mode/clike/clike.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h2 class="mb-4">Online Compiler</h2>

    <!-- Language Selector -->
    <div class="form-group">
      <label for="languageSelect">Select Language:</label>
      <select class="form-control" id="languageSelect">
        <option value="c">C</option>
        <option value="cpp">C++</option>
        <option value="java">Java</option>
        <option value="python">Python</option>
      </select>
    </div>

    <!-- Code Editor -->
    <div class="form-group">
      <label for="codeEditor">Write your code:</label>
      <textarea class="form-control" id="codeEditor"></textarea>
    </div>

    <!-- Output Display -->
    <div class="form-group">
      <label for="output">Output:</label>
      <textarea class="form-control" id="output" rows="5" readonly></textarea>
    </div>

    <!-- Buttons -->
    <button class="btn btn-primary" onclick="compileAndRun()">Compile & Run</button>
    <button class="btn btn-secondary ml-2" onclick="resetEditor()">Reset</button>
  </div>

  <!-- Bootstrap and jQuery Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Initialize CodeMirror -->
  <script>
    var editor = CodeMirror.fromTextArea(document.getElementById("codeEditor"), {
      lineNumbers: true,
      mode: "text/x-csrc", // Default to C language
      theme: "default"
    });

    function compileAndRun() {
      var language = document.getElementById('languageSelect').value;
      var code = editor.getValue();

      $.ajax({
        type: 'POST',
        url: 'save_code.php',
        contentType: 'application/json',
        data: JSON.stringify({ code: code, language: language }),
        success: function(response) {
          document.getElementById('output').value = response;
        },
        error: function(xhr, status, error) {
          console.error(error);
          document.getElementById('output').value = 'Error: ' + xhr.responseText;
        }
      });
    }

    function resetEditor() {
      editor.setValue('');
      document.getElementById('output').value = '';
    }
  </script>
</body>
</html>
