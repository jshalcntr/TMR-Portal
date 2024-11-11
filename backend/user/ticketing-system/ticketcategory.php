<?php
// include ('../../dbconn.php');

// $query = "SELECT DISTINCT ticket_type FROM ticket_records_tbl"; 
// $result = mysqli_query($conn, $query);

// $ticketTypes = [];
// while ($row = mysqli_fetch_assoc($result)) {
//     $ticketTypes[] = $row['ticket_type'];
// }

// // Send JSON response
// header('Content-Type: application/json');
// echo json_encode($ticketTypes);



// Array of IT ticket categories
$categories = [
    "Hardware Issues" => [
        "Laptop/Desktop Issues",
        "Printer/Scanner Problems",
        "Network Equipment (Routers, Switches)",
        "Peripheral Devices (Keyboard, Mouse)",
        "Hardware Replacement or Upgrade"
    ],
    "Software Issues" => [
        "Operating System Problems",
        "Software Installation/Update",
        "Application Crashes",
        "License and Activation Issues",
        "Compatibility Issues"
    ],
    "Network and Connectivity" => [
        "Internet Connectivity",
        "VPN Access",
        "Network Configuration",
        "Wi-Fi Issues",
        "Network Security"
    ],
    "Account and Access Management" => [
        "Account Creation/Deletion",
        "Password Reset/Recovery",
        "Permission or Role Changes",
        "Single Sign-On (SSO) Issues",
        "Account Lockouts"
    ],
    "Email and Communication" => [
        "Email Setup/Configuration",
        "Spam or Phishing Emails",
        "Distribution List Management",
        "Email Quota Issues",
        "Calendar/Meeting Issues"
    ],
    "Security and Compliance" => [
        "Antivirus and Malware Protection",
        "Data Security Incidents",
        "Security Policy Violations",
        "User Awareness Training",
        "Access Control Issues"
    ],
    "IT Service Requests" => [
        "New Hardware/Software Request",
        "Equipment Loan or Purchase",
        "System Access Requests",
        "IT Consultation",
        "Workspace Setup (Desks, Monitors)"
    ],
    "System and Application Performance" => [
        "Slow System Performance",
        "Application Latency",
        "Server Downtime/Outages",
        "Database Issues",
        "Resource Utilization (CPU, Memory)"
    ],
    "Backup and Recovery" => [
        "Data Backup Issues",
        "Restore Requests",
        "Cloud Storage Issues",
        "Data Loss Incident",
        "Disaster Recovery Planning"
    ],
    "User Training and Support" => [
        "New User Orientation",
        "Software Training",
        "IT Policies and Procedures",
        "Knowledge Base Access",
        "FAQ and Documentation Updates"
    ],
    "Other/Miscellaneous" => [
        "General IT Assistance",
        "Requests Outside Defined Categories",
        "Feedback and Suggestions",
        "System Enhancement Requests",
        "Administrative Requests"
    ]
];
?>


