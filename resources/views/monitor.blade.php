@include('sidebar')

<style>
    .container {
        background-color: #fff;
        width: 90%;
        margin: 20px auto;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .container-title {
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .container-title h1 {
        font-size: 2.5em;
        margin: 0;
        color: #333;
    }
    .generate-pdf-btn {
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
        transition: background-color 0.3s;
        cursor: pointer;
        text-decoration: none;
    }
    .generate-pdf-btn:hover {
        background-color: #0056b3;
    }
    .content table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 1em;
    }
    .content th, .content td {
        border: 1px solid #ddd;
        padding: 12px 15px;
        text-align: left;
    }
    .content th {
        background-color: #f4f4f4;
        color: #333;
    }
    .content tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .content tr:hover {
        background-color: #f1f1f1;
    }

</style>

<div class="container">
<div class="container-title">
    <h1>Time In Today</h1>
    <a href="{{ url('/timein/pdf') }}" class="generate-pdf-btn">Generate PDF</a>
</div>
    <div class="content">
        <table>
            <thead>
                <tr>
                   
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Middle Name</th>
                    <th>Datetime</th>
              
                </tr>
            </thead>
            <tbody>

            @foreach($timein as $t)
    <tr>
        <td>{{ $t->student->f_name }}</td>
        <td>{{ $t->student->l_name }}</td>
        <td>{{ $t->student->m_name }}</td>
        <td>{{ $t->datetime }}</td>
    </tr>
@endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="container">
<div class="container-title">
    <h1>Time Out Today</h1>
    <a href="{{ url('/timeout/pdf') }}" class="generate-pdf-btn">Generate PDF</a>
</div>
    <div class="content">
        <table>
            <thead>
                <tr>
                   
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Middle Name</th>
                    <th>Datetime</th>
              
                </tr>
            </thead>
            <tbody>

            @foreach($timeout as $t)
    <tr>
        <td>{{ $t->student->f_name }}</td>
        <td>{{ $t->student->l_name }}</td>
        <td>{{ $t->student->m_name }}</td>
        <td>{{ $t->datetime }}</td>
    </tr>
@endforeach
            </tbody>
        </table>
    </div>
</div>