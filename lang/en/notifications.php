<?php

return [
    'overdue_client_title' => '⚠️ Payment Overdue Alert',
    'overdue_client_body'  => 'We would like to remind you that the payment due on :date for the amount of :amount has not been settled for contract #:contract.',

    'overdue_employee_title' => 'Client Payment Overdue',
    'overdue_employee_body'  => 'Client :name has an overdue payment for contract #:contract.',

    'payment_uploaded_title'   => 'New Payment Receipt Pending Review',
    'payment_uploaded_body'    => 'Client :client has uploaded a payment receipt of :amount requiring your review.',
    'payment_approved_title'   => 'Payment Approved Successfully',
    'payment_approved_body'    => 'Your payment of :amount has been verified and your account has been updated.',
    'payment_rejected_title'   => 'Payment Receipt Notice',
    'payment_rejected_body'    => 'Sorry, your payment receipt of :amount was rejected. Please re-upload a clear image.',

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

    'contract_created_title' => 'New Contract Created',
    'contract_created_body'  => 'A new contract with reference number :reference has been successfully created.',

    // Finance/Payment Notifications
    'payment_success_title'  => 'Payment Successful',
    'payment_success_body'   => 'Your payment of :amount has been successfully received.',

    // Lottery Notifications
    'lottery_participation_title' => 'Added to Lottery',
    'lottery_participation_body'  => 'You have been successfully added to the draw for unit :unit. Good luck!',

    'lottery_winner_title' => 'Congratulations! You Won!',
    'lottery_winner_body'  => 'You are the lucky winner of the real estate lottery draw. We will contact you soon with further details.',

    'lottery_loser_title'  => 'Lottery Results',
    'lottery_loser_body'   => 'Unfortunately, you did not win this time. Better luck in our upcoming draws!',
];
