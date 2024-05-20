@include('sidebar')
<style>
    /* Container Styles */
    .container {
        background-color: #f9f9f9;
        width: 90%;
        margin: 20px auto;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
        color: #666;
    }

    input[type="file"] {
        display: none;
    }

    .fileInputContainer {
        text-align: center;
        margin-top: 20px;
    }

    .fileInputLabel {
        display: inline-block;
        padding: 12px 24px;
        border: 2px solid #007bff;
        border-radius: 6px;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .fileInputLabel:hover {
        background-color: #0056b3;
    }

    .submitBtn {
        display: block;
        margin: 20px auto;
        padding: 14px 28px;
        border: none;
        border-radius: 6px;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .submitBtn:hover {
        background-color: #0056b3;
    }
</style>

<div class="container">
    <h1>Import CSV to Database</h1>
    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="fileInputContainer">
            <label for="csvFile" class="fileInputLabel">Choose CSV File</label>
            <input type="file" id="csvFile" name="file" accept=".csv" required>
        </div>
        <div id="csvDataContainer" style="display: none;">
            <table id="csvDataTable">
                <!-- Table headers and rows will be dynamically generated here -->
            </table>
            <button type="submit" class="submitBtn">Import CSV to Database</button>
        </div>
    </form>
</div>
<script>
    document.getElementById('csvFile').addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.readAsText(file);
            reader.onload = function(event) {
                var csvData = event.target.result;
                var lines = csvData.split('\n').filter(line => line.trim() !== '');

                if (lines.length > 0) {
                    var headers = parseCSVLine(lines[0]);
                    var tableHeaders = '<thead><tr>';
                    headers.forEach(function(header) {
                        tableHeaders += '<th>' + header + '</th>';
                    });
                    tableHeaders += '</tr></thead>';

                    var tableBody = '<tbody>';
                    for (var i = 1; i < lines.length; i++) {
                        var row = parseCSVLine(lines[i]);
                        if (row.length === headers.length) {
                            tableBody += '<tr>';
                            for (var j = 0; j < headers.length; j++) {
                                tableBody += '<td>' + row[j] + '</td>';
                            }
                            tableBody += '</tr>';
                        } else {
                            console.error('Row', i, 'has incorrect number of values:', row);
                        }
                    }
                    tableBody += '</tbody>';

                    document.getElementById('csvDataTable').innerHTML = tableHeaders + tableBody;
                    document.getElementById('csvDataContainer').style.display = 'block';
                }
            };
        }
    });

    function parseCSVLine(line) {
        var values = [];
        var insideQuote = false;
        var value = '';

        for (var i = 0; i < line.length; i++) {
            var char = line[i];

            if (char === '"' && (i === 0 || line[i - 1] !== '\\')) {
                insideQuote = !insideQuote;
            } else if (char === ',' && !insideQuote) {
                values.push(value.trim());
                value = '';
            } else {
                value += char;
            }
        }
        values.push(value.trim());

        return values;
    }
</script>
