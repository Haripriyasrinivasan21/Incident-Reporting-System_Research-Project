<?php
include 'user_header.php';
include 'db.php'; // Database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// ✅ Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reporter_name = $_POST['reporter_name'] ?? '';
    $reporter_email = $_POST['reporter_email'] ?? '';
    $reporter_phone = ($_POST['country_code'] ?? '') . ($_POST['reporter_phone'] ?? '');
    $incident_date_time = date("Y-m-d H:i:s", strtotime($_POST['incident_date_time']));
    $location = $_POST['location'];
    $incident_type = $_POST['incident_type'];
    $incident_type_other = $_POST['incident_type_other'] ?? '';
    $type_display = ($incident_type === "Others" && $incident_type_other) ? $incident_type_other : $incident_type;
    $description = $_POST['description'];
    $severity_level = $_POST['severity_level'];
    $action_taken = $_POST['action_taken'];
    $patient_id_name = $_POST['patient_id_name'];
    $witnesses = $_POST['witnesses'];
    $is_anonymous = $_POST['is_anonymous'] ?? 'false';
    $created_by = $_SESSION['user_id'];

    $attachments = "";
    if (!empty($_FILES["attachments"]["name"])) {
        $target_dir = "uploads/";
        $attachments = $target_dir . basename($_FILES["attachments"]["name"]);
        move_uploaded_file($_FILES["attachments"]["tmp_name"], $attachments);
    }

     $stmt = $conn->prepare("INSERT INTO reports (user_id, reporter_name, reporter_email, reporter_phone, incident_date_time, location, incident_type, description, severity_level, action_taken, patient_id_name, witnesses, attachments, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
     $stmt->bind_param("issssssssssssi", $user_id, $reporter_name, $reporter_email, $reporter_phone, $incident_date_time, $location, $type_display, $description, $severity_level, $action_taken, $patient_id_name, $witnesses, $attachments, $created_by);

    // Prepare headers
    $to = $reporter_email; // Send to the reporter
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: noreply@yourdomain.com\r\n";
    // Email subject
    $subject = "Incident Report Submitted";

    $message = "
<html>
<head><style>
  body { font-family: Arial, sans-serif; }
  .container { padding: 10px; }
  .highlight { font-weight: bold; color: #004085; }
</style></head>
<body>
<div class='container'>
  <h2>Thank You for Your Report</h2>
  <p>Dear $reporter_name,</p>
  <p>Your incident report has been successfully submitted with the following details:</p>
   <p><span class='highlight'>Incident Type:</span> $type_display</p>
   <p><span class='highlight'>Severity Level:</span> $severity_level</p>
   <p><span class='highlight'>Date & Time:</span> $incident_date_time</p>
   <p><span class='highlight'>Reporter Contact:</span> $reporter_phone</p>
   <p><span class='highlight'>Action Taken:</span> $action_taken</p>
  <hr>
  <p>
    Our team will review it shortly. You can check the status of the report in the
    <strong>“View Report Status”</strong> tab.
  </p>
</div>
</body>
</html>
";

    if ($stmt->execute()) {
        if ($is_anonymous === 'true') {
            echo "<div class='alert alert-info text-center'>Report submitted successfully. No email sent as this is an Anonymous Submission.</div>";
            exit();
        }

        require 'vendor/autoload.php'; // This loads PHPMailer classes

        $mail = new PHPMailer(true);

        try {
            // ✅ SMTP Setup
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'harisrila21@gmail.com';         // Your personal Gmail address
            $mail->Password   = 'brvg ncdk piqp sayj';            // The app password you generated
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Secure TLS encryption
            $mail->Port       = 587;

            // ✅ Email Headers & Recipients
            $mail->setFrom('noreply@yourdomain.com', 'Incident Reporting System');
            $mail->addAddress($reporter_email);                 // To: reporter

            // ✅ Email Body (HTML)
            $mail->isHTML(true);
            $mail->Subject = 'Incident Report Confirmation';
            $mail->Body    = $message; // This is your styled HTML message from earlier

            $mail->send(); // 🎉 Email sent!
            echo "<div class='alert alert-success text-center'>Report submitted successfully. An email has been sent for confirmation!</div>";
            //     echo "<script>
            //     alert('Report submitted successfully. Email sent!');
            //     window.location.href = 'view_report_status.php';
            // </script>";
            exit();
        } catch (Exception $e) {
            // Handle failure
            error_log("PHPMailer Error: " . $mail->ErrorInfo);
            echo "<div class='alert alert-warning text-center'>Report saved, but email delivery failed.</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center'>Error submitting form. Please try again.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            background: url('images/newir.png') repeat fixed;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
    </style>
</head>


<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 col-lg-5 mx-auto"> <!-- Adjusted width -->
            <div class="card shadow-lg p-4">
                <h2 class="text-center mb-4">⚠️ Report an Incident</h2>
                <form method="POST" enctype="multipart/form-data" class="needs-validation">
                    <div class="mb-3">
                        <label>
                            <input type="checkbox" id="anonymousCheck" onchange="toggleIdentityFields()"> Submit Anonymously
                        </label>
                    </div>
                    <input type="hidden" name="is_anonymous" id="is_anonymous" value="false">
                    <script>
                        function toggleIdentityFields() {
                            const isChecked = document.getElementById('anonymousCheck').checked;
                            const identityContainer = document.getElementById('identityFields');
                            const identityFields = identityContainer.querySelectorAll('input, select');
                            document.getElementById('identityFields').style.display = isChecked ? 'none' : 'block';
                            document.getElementById('is_anonymous').value = isChecked ? 'true' : 'false';
                            identityFields.forEach(field => {
                                if (isChecked) {
                                    field.removeAttribute('required');
                                } else {
                                    field.setAttribute('required', true);
                                }
                            });
                        }
                    </script>
                    <div id="identityFields">
                        <div class="mb-3">
                            <label class="form-label">Reporter's Name</label>
                            <input type="text" name="reporter_name" class="form-control" placeholder="Let us know your name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reporter's Email</label>
                            <input type="email" name="reporter_email" class="form-control" placeholder="Let us know your email address" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reporter’s Contact Number</label>
                            <div class="d-flex gap-1">
                                <!-- Country Code Dropdown -->
                                <select name="country_code" class="form-select w-25" required>
                                    <option value="">Code</option>
                                    <option value="+44">🇬🇧 +44</option>
                                    <option value="+91">🇮🇳 +91</option>
                                    <option value="+1">🇺🇸 +1</option>
                                    <option value="+61">🇦🇺 +61</option>
                                    <option value="+81">🇯🇵 +81</option>
                                    <option value="+234">🇳🇬 +234</option>
                                    <option value="+86">🇨🇳 +86</option>
                                </select>

                                <!-- 10-digit phone input -->
                                <input type="tel" name="reporter_phone" class="form-control"
                                    placeholder="Enter 10-digit number"
                                    pattern="\d{10}" maxlength="10" required
                                    title="Please enter a 10-digit number">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Patient Details</label>
                        <input type="text" name="patient_id_name" class="form-control" placeholder="Enter patient ID/Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Incident Date & Time</label>
                        <input type="datetime-local" name="incident_date_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" placeholder="Where did this incident happen?" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Incident Type</label>
                        <select name="incident_type" class="form-control" id="incidentTypeSelect" required onchange="toggleOtherField(); setSeverityLevel();">
                            <option value="">Select the Type of Incident</option>
                            <option value="Human Error">Human Error</option>
                            <option value="Medication Error">Medication Error</option>
                            <option value="Equipment Failure">Equipment Failure</option>
                            <option value="Patient Fall">Patient Fall</option>
                            <option value="Communication Issue">Communication Issue</option>
                            <option value="Policy Violation">Policy Violation</option>
                            <option value="Infection Control Breach">Infection Control Breach</option>
                            <option value="Diagnostic Error">Diagnostic Error</option>
                            <option value="Documentation Error">Documentation Error</option>
                            <option value="Facility Hazard">Facility Hazard</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="mb-3" id="otherTypeContainer" style="display: none;">
                        <label class="form-label">If others, Please specify</label>
                        <input type="text" name="incident_type_other" class="form-control" placeholder="Describe the incident type">
                    </div>

                    <script>
                        function toggleOtherField() {
                            const dropdown = document.getElementById('incidentTypeSelect');
                            const otherContainer = document.getElementById('otherTypeContainer');
                            otherContainer.style.display = dropdown.value === 'Others' ? 'block' : 'none';
                        }
                    </script>

                    <!-- Severity Level -->
                    <div class="mb-3">
                        <label class="form-label">Severity Level</label>
                        <select name="severity_level" class="form-control" id="severityLevelSelect" required>
                            <option value="">Severity Level will be Autopopulated</option>
                            <option value="Low">Low</option>
                            <option value="Moderate">Moderate</option>
                            <option value="High">High</option>
                            <option value="Critical">Critical</option>
                        </select>
                    </div>

                    <script>
                        function setSeverityLevel() {
                            const incident = document.getElementById('incidentTypeSelect').value;
                            const severity = document.getElementById('severityLevelSelect');

                            const severityMap = {
                                "Human Error": "High",
                                "Medication Error": "High",
                                "Equipment Failure": "Moderate",
                                "Patient Fall": "High",
                                "Communication Issue": "Moderate",
                                "Policy Violation": "Moderate",
                                "Infection Control Breach": "Critical",
                                "Diagnostic Error": "High",
                                "Documentation Error": "Low",
                                "Facility Hazard": "Moderate",
                                "Others": "Moderate"
                            };

                            severity.value = severityMap[incident] || ""; // Reset if not mapped
                        }
                    </script>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Breif us what happened.."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Immediate Action Taken</label>
                        <textarea name="action_taken" class="form-control" placeholder="Let us know what action did you take?"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Witnesses</label>
                        <textarea name="witnesses" class="form-control" placeholder="Add Witnesses if any"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Attachments</label>
                        <input type="file" name="attachments" class="form-control" accept="image/*">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Styling -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<?php include 'admin_footer.php'; ?>