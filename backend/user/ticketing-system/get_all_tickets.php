<?php
header('Content-Type: application/json');
session_start();
include('../../dbconn.php');

// Dynamic base URL for attachments
$basePath = dirname(dirname($_SERVER['PHP_SELF']));
$host = $_SERVER['HTTP_HOST'];
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$baseUrl = $protocol . "://" . $host . $basePath . "/uploads/tickets/";

// Ensure session contains user department
$user_dept = $_SESSION['user']['department'] ?? null;
$user_role = $_SESSION['user']['role'] ?? null;

$data = [];

if ($user_dept) {
    $stmt = $conn->prepare("
        SELECT 
            t.*, 
            a.full_name AS requestor_name, 
            b.full_name AS handler_name,
            a.department AS requestor_department 
        FROM ticket_records_tbl AS t 
        LEFT JOIN accounts_tbl AS a ON t.ticket_requestor_id = a.id 
        LEFT JOIN accounts_tbl AS b ON t.ticket_handler_id = b.id 
        WHERE t.requestor_department = ? 
        ORDER BY t.date_created DESC
    ");
    $stmt->bind_param("s", $user_dept);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $ticketAttachmentUrl = $row['ticket_attachment']
            ? "../../../uploads/tickets/" . basename($row['ticket_attachment'])
            : '';

        $approvalAttachmentUrl = $row['for_approval_attachment']
            ? "../../../uploads/for_approval/" . basename($row['for_approval_attachment'])
            : '';

        // Format date fields
        $dateCreated = $row['date_created'] ? date('M j Y g:i A', strtotime($row['date_created'])) : 'N/A';
        $dateAccepted = $row['date_accepted'] ? date('M j Y g:i A', strtotime($row['date_accepted'])) : 'N/A';
        $dateFinished = $row['date_finished'] ? date('M j Y g:i A', strtotime($row['date_finished'])) : 'N/A';
        $dueDate = $row['ticket_due_date'] ? date('Y-m-d H:i', strtotime($row['ticket_due_date'])) : 'N/A';
        $approvalDueDate = $row['ticket_for_approval_due_date'] ? date('Y-m-d H:i', strtotime($row['ticket_for_approval_due_date'])) : 'N/A';
        $dateApproved = $row['ticket_date_approved'] ? date('M j Y g:i A', strtotime($row['ticket_date_approved'])) : 'N/A';

        // Format button with data attributes
        $viewButton = "
            <button class='btn btn-sm btn-primary view-ticket'
                data-bs-toggle='modal'
                data-bs-target=''
                data-id='{$row['ticket_id']}'
                data-subject='" . htmlspecialchars($row['ticket_subject'], ENT_QUOTES, 'UTF-8') . "'
                data-type='" . htmlspecialchars($row['ticket_type'], ENT_QUOTES, 'UTF-8') . "'
                data-description='" . htmlspecialchars($row['ticket_description'], ENT_QUOTES, 'UTF-8') . "'
                data-priority='" . htmlspecialchars($row['ticket_priority'], ENT_QUOTES, 'UTF-8') . "'
                data-status='" . htmlspecialchars($row['ticket_status'], ENT_QUOTES, 'UTF-8') . "'
                data-requestor='" . htmlspecialchars($row['requestor_name'] ?? 'Unknown', ENT_QUOTES, 'UTF-8') . "'
                data-handler='" . htmlspecialchars($row['handler_name'] ?? 'Unassigned', ENT_QUOTES, 'UTF-8') . "'
                data-due='{$dueDate}'
                data-approval-due='{$approvalDueDate}'
                data-created='{$dateCreated}'
                data-accepted='{$dateAccepted}'
                data-finished='{$dateFinished}'
                data-requestor-department='" . htmlspecialchars($row['requestor_department'] ?? '', ENT_QUOTES, 'UTF-8') . "'
                data-conclusion='" . htmlspecialchars($row['ticket_conclusion'], ENT_QUOTES, 'UTF-8') . "'
                data-reason='" . htmlspecialchars($row['for_approval_reason'], ENT_QUOTES, 'UTF-8') . "'
                data-approved='{$dateApproved}'
                data-attachment-url='" . htmlspecialchars($ticketAttachmentUrl, ENT_QUOTES, 'UTF-8') . "'
                data-approval-attachment-url='" . htmlspecialchars($approvalAttachmentUrl, ENT_QUOTES, 'UTF-8') . "'
                data-user-role='{$user_role}'
            >
                <i class='fa fa-eye'></i>
            </button>
        ";
        $ticketAttachmentHtml = $ticketAttachmentUrl
            ? "<a href='{$ticketAttachmentUrl}' target='_blank'>View Attachment</a>"
            : 'No attachment.';

        $approvalAttachmentHtml = $approvalAttachmentUrl
            ? "<a href='{$approvalAttachmentUrl}' target='_blank'>View Attachment</a>"
            : 'No attachment.';
        // Final data array row
        $data[] = [
            $row['ticket_id'],
            $row['ticket_type'],
            $row['ticket_subject'],
            $row['ticket_priority'],
            $row['ticket_status'],
            $row['requestor_name'] ?? 'Unknown',
            $row['handler_name'] ?? 'Unassigned',
            $dueDate,
            $approvalDueDate,
            $dateCreated,
            $dateAccepted,
            $dateFinished,
            $row['for_approval_reason'],
            $dateApproved,
            $ticketAttachmentHtml,
            $approvalAttachmentHtml,
            $viewButton
        ];
    }

    $stmt->close();
}

echo json_encode(['data' => $data]);
