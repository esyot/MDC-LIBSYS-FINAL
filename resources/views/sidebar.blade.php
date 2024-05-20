<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: "Lato", sans-serif;
  background-image: url('{{ asset("asset/images/mdc_cover_photo.jpg") }}'); 
}

.sidebar {
  height: 100%;
  width: 0;
  position: fixed;
  top: 0;
  left: 0;
  background-color: #0c194e;
  overflow-x: hidden;
  transition: 0.5s;
  text-align: center;
  opacity: 0.9;
  box-shadow: 10px 0 10px -5px rgba(0, 0, 0, 0.3); /* Add shadow to the right side */
}

.sidebar a {
  margin-top: 25px;
  margin-left: 25px;
  text-align: left;
  text-decoration: none;
  font-size: 20px;
  color: #fff;
  display: block;
  transition: 0.3s;
}

.sidebar a:hover {
  color: #808080;
}

.openbtn {
  font-size: 30px;
  cursor: pointer;
  border: none;
  color: #fff;
  font-weight: bold;
  margin-left: 10px;
}

.title {
  color: #FDDA0D;
  font-weight: bold;
  margin-bottom: 60px;
}

.sublist {
  color: #fff;
  list-style: none;
  margin-right: 0px; /* Adjust padding to indent the sublist */
  display: none; /* Hide the sublist by default */
}

.sublist li {
  margin-bottom: 2px; /* Reduce space between sublist items */
 
}

.sublist li a {
  text-align: left;
  font-size: 16px; /* Adjust font size of sublist item links */
  color: #ccc; /* Change color of sublist item links */
  text-decoration: none; /* Remove underline from sublist item links */
}

.sublist li a:hover {
  color: #fff; /* Change color of sublist item links on hover */
}

.dropdown:hover .sublist {
  display: block; /* Display the sublist when the parent link is hovered */
}
</style>
</head>
<body>

<div id="mySidebar" class="sidebar">    
    <div class="title">
        <h2>MDC LIBRARY SYSTEM</h2>
    </div>
    <a href="{{ route('dashboard') }}" title="Dashboard">Dashboard</a>
    <a href="{{ route('timein') }}" title="Time-in">Time-in</a>
    <a href="{{ route('timeout') }}" title="Time-out">Time-out</a>
    <a href="{{ route('students') }}" title="Monitor Students">Monitor Students</a>
    <a href="{{ route('monitor') }}" title="Monitor Attendance of students">Monitor Attendance</a>
    <a href="{{ route('register') }}" title="Register a Student">Register  Student</a>
    <div class="dropdown">
        <a href="#" title="Generate and Import CSV to databasze">Import and Export</a>
        <ul class="sublist">
            <li><a href="{{ route('csv') }}" title="generate student details in csv file">Generate CSV</a></li>
            <li><a href="{{ route('importcsv') }}" title="view and import csv file to database">Open and Import DB</a></li>
            <!-- Add more sublist items as needed -->
        </ul>
    </div>
</div>

<div id="main">
  <a class="openbtn" id="toggleButton" title="click this to open and close sidebar">☰</a>  
</div>

<script>
document.getElementById('toggleButton').addEventListener('click', function() {
  var sidebar = document.getElementById("mySidebar");
  var main = document.getElementById("main");
  if (sidebar.style.width === "250px") {
    sidebar.style.width = "0";
    main.style.marginLeft = "0";
  } else {
    sidebar.style.width = "250px";
    main.style.marginLeft = "250px";
  }
});

</script>
   
</body>
</html>
