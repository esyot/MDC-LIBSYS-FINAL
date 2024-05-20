<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students</title>
    <style>
      
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            overflow-x: auto;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
            font-weight: bold;
        }
        td {
            background-color: #fff;
            color: #555;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        @media screen and (max-width: 600px) {
            .container {
                width: 95%;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registered Students</h1>
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Middle Name</th>
                    <th>Course</th>
                    <th>Address</th>
                    <th>Contact No</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->f_name }}</td>
                    <td>{{ $student->l_name }}</td>
                    <td>{{ $student->m_name }}</td>
                    <td>{{ $student->course }}</td>
                    <td>{{ $student->address }}</td>
                    <td>{{ $student->contact_no }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
