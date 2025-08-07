<?php
include 'manager_header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escalation Procedures</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-2">
        <h3 class="text-center mb-4">🚦 Escalation Procedures for Incident Managers</h3>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title">🧐 Initial Assessment & Classification</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">🔍 Review each reported incident for completeness and clarity.</li>
                    <li class="list-group-item">📊 Assign a <strong>severity level</strong> (Low, Moderate, High, or Critical) based on impact, urgency, and scope.</li>
                    <li class="list-group-item">🚦 Determine if escalation is required and select the appropriate pathway.</li>
                </ul>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title">📶 Tiered Escalation Path</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">🟢 <strong>Low Severity:</strong> Logged for monitoring → No immediate action required</li>
                    <li class="list-group-item">🟡 <strong>Moderate Severity:</strong> Escalate within 4 hours → Assigned Analyst / Developer</li>
                    <li class="list-group-item">🟠 <strong>High Severity:</strong> Escalate within 1 hour → Functional Team Lead</li>
                    <li class="list-group-item">🔴 <strong>Critical Severity:</strong> Immediate escalation → Senior Engineer / Director</li>
                </ul>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title">📚 Escalation Types</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"> <strong>Functional Escalation:</strong> Routed to teams with domain expertise.</li>
                    <li class="list-group-item"> <strong>Hierarchical Escalation:</strong> Raised up the chain of command if blocked or delayed.</li>
                </ul>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title">⏰ Common Escalation Triggers</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">📉 SLA breach or prolonged inaction</li>
                    <li class="list-group-item">🌐 Multi-user or system-wide impact</li>
                    <li class="list-group-item">🔐 Compliance or security breach</li>
                    <li class="list-group-item">🔁 Repeated similar incidents</li>
                </ul>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title">📣 Communication & Documentation</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">✉️ Notify stakeholders via alerts</li>
                    <li class="list-group-item">📁 Log escalation actions in the IRS system</li>
                    <li class="list-group-item">🗂 Use predefined escalation templates</li>
                </ul>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3 class="card-title">🔍 Post-Escalation Follow-Up</h3>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">✅ Verify resolution and close report</li>
                    <li class="list-group-item">📝 Conduct post-mortem (SEV 1 & 2)</li>
                    <li class="list-group-item">🔧 Refine escalation logic based on findings</li>
                </ul>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
