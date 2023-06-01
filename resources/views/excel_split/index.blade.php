<!DOCTYPE html>
<html>
<head>
    <title>Excel Splitter</title>
</head>
<body>
    <h1>Excel Splitter</h1>

    <form action="{{ route('excel.split') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="excel_file">Select Excel File:</label>
        <input type="file" name="excel_file" id="excel_file" required><br>

        <label for="split_column">Split Column:</label>
        <input type="text" name="split_column" id="split_column" required><br>

        <button type="submit">Split File</button>
    </form>
</body>
</html>