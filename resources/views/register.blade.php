@include('sidebar')

<style>
    .container {
        width: 500px;
        margin: 0 auto;
        text-align: center;
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 20px;
        border: 1px solid #ccc;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }
    .form-input {
        width: 100%;
        margin-bottom: 10px;
        padding: 8px;
        box-sizing: border-box;
    }
    .form-submit {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }
    label {
        display: block;
        text-align: left;
        margin-bottom: 5px;
    }
    .container-title{
        margin-top: 0px;
    }
</style>

<div class="container">
    <div class="container-title">
        <h1>Insert a Student</h1>
    </div>
    <div class="content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('students.store') }}" method="POST">

            @csrf
            <label for="f_name">First Name:</label>
            <input type="text" name="f_name" id="f_name" class="form-input" placeholder="Enter first name" required>
            <label for="l_name">Last Name:</label>
            <input type="text" name="l_name" id="l_name" class="form-input" placeholder="Enter last name" required>
            <label for="m_name">Middle Name:</label>
            <input type="text" name="m_name" id="m_name" class="form-input" placeholder="Enter middle name" required>
            <label for="course">Course:</label>
            <select name="course" id="course" class="form-input" required>
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

            <label for="contact_no">Contact No:</label>
            <input type="text" name="contact_no" id="contact_no" class="form-input" placeholder="Enter contact number" required>
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" class="form-input" placeholder="Enter address" required>
            <button type="submit" class="form-submit">Submit</button>
        </form>
    </div>
</div>
 