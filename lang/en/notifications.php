<?php

return [
    'overdue_client_title' => '⚠️ Payment Overdue Alert',
    'overdue_client_body'  => 'We would like to remind you that the payment due on :date for the amount of :amount has not been settled for contract #:contract.',

    'overdue_employee_title' => 'Client Payment Overdue',
    'overdue_employee_body'  => 'Client :name has an overdue payment for contract #:contract.',


    # Engineer
    'engineer_allocation_title' => '🏗️ New Engineering Assignment',
    'engineer_allocation_building' => "You have been assigned to supervise ':building' within ':project'. The task starts on :date.",
    'engineer_allocation_project' => "You have been assigned to supervise the entire ':project'. The task starts on :date.",


    # Complaint
    'complaint_status_title' => '🔄 Complaint Status Updated',
    'complaint_status_body'  => "The status of your complaint ':title' has been updated to: :status.",

    'new_complaint_title'    => '🚨 New Complaint Received!',
    'new_complaint_body'     => "A new complaint titled ':title' has been received, please follow up.",

    'unknown_client'         => 'Unknown',


    # Order
    'new_order_title'      => '🆕 New Order Received!',
    'new_order_body'       => 'A new order #:order_id has been received from the client, awaiting preliminary review and approval.',

    'order_transfer_title' => 'New Order Transferred',
    'order_transfer_body'  => 'Order #:order_id has been transferred to your department.',
];
