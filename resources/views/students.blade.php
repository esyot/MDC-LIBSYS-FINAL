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
        margin-left: 90vh;
        border-radius: 5px;
        background-color: #4CBB17;
        color: #fff;
        font-weight: bold;
        transition: background-color 0.3s;
        cursor: pointer;
        text-decoration: none;
    }

    .generate-csv-btn {
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
        transition: background-color 0.3s;
        cursor: pointer;
        text-decoration: none;
    }

    .generate-csv-btn:hover {
        background-color: #0056b3;
    }
    .generate-pdf-btn:hover {
        background-color: #478778;
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

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fff;
        margin: 3% auto;
        padding-top: 5px;
        padding-bottom: 20px;
        padding-left: 10px;
        padding-right: 10px;
        border-radius: 5px;
        width: 40%;
        height: 82vh;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        padding: 10px;
        background-color: #007bff; /* Blue */
        color: #fff;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .modal-footer {
        padding: 10px 20px;
        border-top: 1px solid #ddd;
        text-align: right;
    }

    .modal-body {
        padding: 20px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        line-height: 20px;
        
    }

    .close:hover,
    .close:focus {
        color: #333;
        text-decoration: none;
        cursor: pointer;
    }

    /* Button Styles */
    .editbtn, .deletebtn {
        text-decoration: none;
        cursor: pointer;
        padding: 10px 20px;
        border-radius: 5px;
        color: #fff;
        font-weight: bold;
        transition: background-color 0.3s;
        border: none;
        margin-right: 10px;
    }

    .editbtn {
        background-color: #007bff;
        width: 100%; /* Blue */
    }

    .deletebtn {
        background-color: #dc3545; /* Red */
        margin-top: 3px;
        width: 100%;
    }

    /* Additional Button Styles */
    .editbtn:hover, .deletebtn:hover {
        opacity: 0.8;
    }

    /* Modal Input Styles */
    input[type="text"],
    select {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
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

    /* Modal Button Styles */
    .modal-footer button {
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .modal-footer button:first-child {
        background-color: #dc3545; /* Gray */
        color: #fff;
        border: none;
    }

    .modal-footer button:last-child {
        background-color: #007bff; /* Blue */
        color: #fff;
        border: none;
    }

    .modal-footer button:hover {
        opacity: 0.8;
    }
    #qrcode {
        margin: auto; /* Center the QR code */
        display: flex; /* Use flexbox */
        justify-content: center; /* Center horizontally */
        align-items: center; /* Center vertically */
    }
</style>

<div class="container">
<div class="container-title">
    <h1>Registered Students</h1>
    <a href="{{ url('/students/pdf') }}" class="generate-pdf-btn">Generate PDF</a>
    <a href="{{ url('/students/generatecsv') }}" class="generate-csv-btn">Generate CSV</a>
</div>
    <div class="content">
        <table>
            <thead>
                <tr>
                   
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Middle Name</th>
                    <th>Course</th>
                    <th>Contact no</th>
                    <th>Address</th>                    
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                  
                    <td>{{ $student->f_name }}</td>
                    <td>{{ $student->l_name }}</td>
                    <td>{{ $student->m_name }}</td>
                    <td>{{ $student->course }}</td>
                    <td>{{ $student->contact_no }}</td>
                    <td>{{ $student->address }}</td>
                    
                    <td>
                        <button onclick="openEditModal({{ $student->id }})" class="editbtn">View & Edit</button>
                        <form action="/delete/{{ $student->id }}" method="post" onsubmit="return confirm('Are you sure you want to delete this student?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="deletebtn">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        
            <span class="close" onclick="closeEditModal()">&times;</span>
            
        
        <div class="modal-body">
            <div id="qrcode" class="qrcode"></div> <!-- Place the QR code div here -->

            <input type="hidden" id="editId">
            <label for="editFName">First Name:</label>
            <input type="text" id="editFName"><br>
            <label for="editLName">Last Name:</label>
            <input type="text" id="editLName"><br>
            <label for="editMName">Middle Name:</label>
            <input type="text" id="editMName"><br>
            <label for="editCourse">Course:</label>
            <select name="editCourse" id="editCourse" class="form-input" required>
                <option value="" disabled selected>Select a Course</option>
            </select><br>
            <label for="editAddress">Address:</label>
            <input type="text" id="editAddress"><br>
            <label for="editContactNo">Contact No:</label>
            <input type="text" id="editContactNo"><br>
        </div>
        <div class="modal-footer">
            <button class="btn btn-danger" onclick="closeEditModal()">Cancel</button>
            <button class="btn btn-primary" onclick="saveChanges()">Save changes</button>
        </div>
    </div>
</div>

<script src="{{ asset('qrcode.min.js') }}" defer></script>


<script>
    // Function to display QR code
   // Function to display QR code
function displayQRCode(studentId) {
    console.log("Student ID:", studentId); // Debugging message
    
    // Check if studentId is null or empty
    if (!studentId) {
        console.error('Student ID is null or empty');
        return;
    }

    var qrCodeDiv = document.getElementById('qrcode');
    qrCodeDiv.innerHTML = ''; // Clear previous QR code

    try {
        // Generate QR code using QRCode.js
        var qr = new QRCode(qrCodeDiv, {
            text: studentId,
            width: 150,
            height: 150,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    } catch (error) {
        console.error('Error generating QR code:', error);
    }
}


    // Function to open edit modal
    function openEditModal(studentId) {
        console.log("Opening edit modal for Student ID:", studentId); // Debugging message
        
        // Fetch student details
        fetch('/student/' + studentId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch student details');
                }
                return response.json();
            })
            .then(student => {
                // Check if the response contains the expected student data
                if (!student || !student.id) {
                    throw new Error('Invalid student data');
                }

                // Populate the form fields with student data
                document.getElementById('editId').value = student.id;
                document.getElementById('editFName').value = student.f_name;
                document.getElementById('editLName').value = student.l_name;
                document.getElementById('editMName').value = student.m_name;
                document.getElementById('editAddress').value = student.address;
                document.getElementById('editContactNo').value = student.contact_no;

                // Populate the course dropdown
                var courseDropdown = document.getElementById('editCourse');
                courseDropdown.innerHTML = ''; // Clear previous options
                var courses = [student.course,
               "BSIT - Bachelor of Science in Information Technology",
               "BSN - Bachelor of Science in Nursing",
               "BSCRIM - Bachelor of Science in Criminology",
               "BSED - Bachelor of Secondary Education",
               "BSA - Bachelor of Science in Accountancy",
               "BSAFM - Bachelor of Science in Accounting and Financial Management",
               "BSMA - Bachelor of Science in Management Accounting",
               "BSHM - Bachelor of Science in Hotel Management",
               "BSTM - Bachelor of Science in Tourism Management"];

                courses.forEach(course => {
                    var option = document.createElement('option');
                    option.value = course;
                    option.text = course;
                    courseDropdown.appendChild(option);
                });

                // Display QR code
                let qrcode = student.id+"";
                displayQRCode(qrcode);

                // Show the edit modal
                document.getElementById('editModal').style.display = 'block';
            })
            .catch(error => {
                console.error('Error fetching student details:', error);
            });
    }

    // Function to close edit modal
    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Function to save changes
    function saveChanges() {
        var editedStudent = {
            id: document.getElementById('editId').value,
            f_name: document.getElementById('editFName').value,
            l_name: document.getElementById('editLName').value,
            m_name: document.getElementById('editMName').value,
            course: document.getElementById('editCourse').value,
            address: document.getElementById('editAddress').value,
            contact_no: document.getElementById('editContactNo').value
        };

        fetch('/students/' + editedStudent.id, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(editedStudent)
        })
            .then(response => {
                if (response.ok) {
                    closeEditModal();
                    window.location.reload();
                } else {
                    // Handle errors
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>

