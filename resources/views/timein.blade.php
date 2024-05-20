@include('sidebar')
<style>
    /* Style for container */
    .container {
        width: 500px; /* Adjust the width as needed */
        margin: 0 auto; /* Center the container horizontally */
        text-align: center; /* Align contents center horizontally */
        padding-bottom: 20px;
        padding-right: 20px;
        padding-left: 20px; /* Add some padding for spacing */
        border: 1px solid #ccc; /* Add a border for visual separation */
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add a subtle shadow */
    }

    /* Style for video element */
    #video {
        width: 100%; /* Make the video element fill the container */
        height: auto; /* Maintain aspect ratio */
        margin-bottom: 20px; /* Add some spacing below the video */
        transform: scaleX(-1);
        border-radius: 10px; /* Rounded corners for video */
    }

    /* Style for output div */
    #output {
        margin-bottom: 20px; /* Add some spacing below the output */
    }

    /* Style for student details card */
    .student-card {
        background-color: #f8f9fa; /* Light background color */
        padding: 20px; /* Add padding */
        border-radius: 10px; /* Rounded corners */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
        text-align: left; /* Align text to the left */
    }

    .student-card p {
        margin: 10px 0; /* Add some spacing between paragraphs */
    }

    .student-card p strong {
        display: inline-block; /* Inline-block for better alignment */
        width: 120px; /* Fixed width for labels */
    }
    .container-title{
        margin-top: 5px;
    }
</style>
</head>
<body>
    <div class="container">
        <h1 class="container-title">Time In</h1>
        <video id="video" autoplay></video>
        <canvas id="canvas" style="display: none;"></canvas>
        <div id="output"></div>
    </div>

    <script src="{{ asset('jsqr.js') }}"></script>

    <script>
        // Call startScanning function when the page loads
        document.addEventListener('DOMContentLoaded', startScanning);

        // Function to start scanning for QR codes
        function startScanning() {
            // Access user's webcam
            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
                .then(function (stream) {
                    var video = document.querySelector('#video');
                    video.srcObject = stream;
                    video.play();
                    video.onloadedmetadata = function() {
                        scanQRCode();
                    };
                })
                .catch(function (error) {
                    console.error('Error accessing user media:', error);
                    document.querySelector('#output').innerText = "Error accessing camera.";
                });
        }

        // Function to scan for QR codes
        function scanQRCode() {
            var video = document.querySelector('#video');
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');

            // Ensure that video dimensions are available
            if (video.videoWidth === 0 || video.videoHeight === 0) {
                requestAnimationFrame(scanQRCode); // Wait for the next frame
                return;
            }

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            // Draw video frame on the canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            var imageData = context.getImageData(0, 0, canvas.width, canvas.height);

            // Decode QR code from the video frame
            var code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: "dontInvert",
            });

            // If QR code is detected, stop the video and display the code
            if (code) {
                console.log('QR Code detected:', code.data);
                document.querySelector('#output').innerText = "Processing QR Code...";
                video.srcObject.getTracks().forEach(track => track.stop());

                // Send the QR code value to the server for verification and insertion
                fetch('/process-qr-code', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ qr_code: code.data })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        document.querySelector('#output').innerHTML = `
                            <div class="student-card">
                                <p><strong>Student ID:</strong> ${data.student.id}</p>
                                <p><strong>Name:</strong>${data.student.f_name} ${data.student.l_name}</p>
                                <p><strong>Course:</strong> ${data.student.course}</p>
                                <p><strong>Time-in:</strong> ${data.student.timein}</p>
                            </div>
                        `;
                    } else {
                        document.querySelector('#output').innerText = "Error: " + data.message;
                    }
                    // Resume scanning for the next QR code
                    startScanning();
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.querySelector('#output').innerText = "Error processing QR code.";
                    // Resume scanning for the next QR code
                    startScanning();
                });
            } else {
                // If QR code is not detected, continue scanning
                requestAnimationFrame(scanQRCode);
            }
        }
    </script>
</body>
</html>