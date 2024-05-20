@include('sidebar')

    <style>
        /* Container Styles */
        .container {
            background-color: #fff;
            width: 90%;
            margin: 20px auto;
            padding: 0px 20px 20px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            padding-top: 10px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-position: right 10px center;
            background-repeat: no-repeat;
            background-size: 20px;
            padding-right: 40px;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .addRow{
            background-color: #4CBB17;
        }
        .addRow:hover{
            background-color: #478778;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 >Generate Student CSV</h1>
        <form action="{{ route('generatecsv') }}" method="POST">
            @csrf
            <table>
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Middle Name</th>
                        <th>Course</th>
                        <th>Contact No</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="f_name[]" required></td>
                        <td><input type="text" name="l_name[]" required></td>
                        <td><input type="text" name="m_name[]" required></td>
                        <td>
                            <select name="course[]" required>
                            <option value="" disabled selected>Select a Course</option>
    <option value="BSIT - Bachelor of Science in Information Technology">BSIT - Bachelor of Science in Information Technology</option>
    <option value="BSN - Bachelor of Science in Nursing">BSN - Bachelor of Science in Nursing</option>
    <option value="BSCRIM - Bachelor of Science in Criminology">BSCRIM - Bachelor of Science in Criminology</option>
    <option value="BSED - Bachelor of Secondary Education">BSED - Bachelor of Secondary Education</option>
    <option value="BSA - Bachelor of Science in Accountancy">BSA - Bachelor of Science in Accountancy</option>
    <option value="BSAFM - Bachelor of Science in Accounting and Financial Management">BSAFM - Bachelor of Science in Accounting and Financial Management</option>
    <option value="BSMA - Bachelor of Science in Management Accounting">BSMA - Bachelor of Science in Management Accounting</option>
    <option value="BSHM - Bachelor of Science in Hotel Management">BSHM - Bachelor of Science in Hotel Management</option>
    <option value="BSTM - Bachelor of Science in Tourism Management">BSTM - Bachelor of Science in Tourism Management</option>
 </select>
                        </td>
                        <td><input type="text" name="contact_no[]"></td>
                        <td><input type="text" name="address[]"></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="addRow" onclick="addRow()">Add Row</button>
            <button type="submit">Generate CSV</button>
        </form>
    </div>

    <script>
        function addRow() {
            var table = document.querySelector('table tbody');
            var newRow = table.insertRow();
            newRow.innerHTML = `
                <td><input type="text" name="f_name[]"></td>
                <td><input type="text" name="l_name[]"></td>
                <td><input type="text" name="m_name[]"></td>
                <td>
                    <select name="course[]" required>
                        <option value="" disabled selected>Select a Course</option>
                        <option value="BSIT - Bachelor of Science in Information Technology">BSIT - Bachelor of Science in Information Technology</option>
                        <option value="BSN - Bachelor of Science in Nursing">BSN - Bachelor of Science in Nursing</option>
                        <option value="BSCRIM - Bachelor of Science in Criminology">BSCRIM - Bachelor of Science in Criminology</option>
                        <option value="BSED - Bachelor of Secondary Education">BSED - Bachelor of Secondary Education</option>
                        <option value="BSA - Bachelor of Science in Accountancy">BSA - Bachelor of Science in Accountancy</option>
                    </select>
                </td>
                <td><input type="text" name="contact_no[]"></td>
                <td><input type="text" name="address[]"></td>
            `;
        }
    </script>
</body>
</html>
