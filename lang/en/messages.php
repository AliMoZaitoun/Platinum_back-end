<?php

return [
    'common' => [
        'success' => 'Operation completed successfully.',
        'failed' => 'The operation failed.',
        'error' => 'An error occurred. Please try again later.',
        'resource' => 'Resource',
        'not_found_item' => 'Sorry, :item not found.',
        'deleted' => 'Deleted successfully.',
        'stored' => 'Stored successfully.',
        'updated' => 'Updated successfully.',
        'unauthorized' => 'You are not authorized to perform this action.',
    ],
    'auth' => [
        'login' => 'Login successful! Welcome aboard.',
        'logout' => 'Logout successful! See you later.',
        'invalid' => 'Invalid email or password.',
        'password_invalid' => 'Invalid password',

        'password_changed' => 'Password changed successfully.',
        'email_verified' => 'Email verified successfully.',
        'already_verified' => 'Email already verified!.',


        'inactive' => 'Your account is not activated yet. Please check your email or enter the OTP.',
        'otp_sent' => 'OTP has been sent to your email.',
        'otp_failed' => 'Failed to send OTP. Please try again.',
        'otp_verified' => 'OTP verified successfully.',
        'otp_invalid' => 'Invalid or expired OTP.',

        'invalid_refresh_token' => 'Session expired. Please log in again.',
    ],

    'system' => [
        'validation' => 'The given data was invalid.',
        'db_error' => 'A system error occurred. Please contact support with code: :trace_id',
        'no_results' => 'No results found.',
        'permission_not_change' => 'You cannot change permissions of admin role',
    ],

    'validation' => [
        'date_cannot_be_in_past'       => 'The selected date cannot be in the past.',
        'end_time_must_be_after_start' => 'The end time must be strictly after the start time.',
        'appointment_notes_required' => 'Please provide the reason or notes for the appointment when no order is selected.',
    ],

    'sentences' => [
        'wrong_start_date' => 'The start date must be after or equal to the project start date: :date',

        'device_mismatch' => 'Access denied. This account is linked to another device.',
        'out_of_geofence' => 'You are outside the project geographical boundary. Distance: :distance meters.',
    ],

    'favorites' => [
        'already_exists' => 'This unit is already in your favorites.',
    ],

    'orders' => [
        'already_submitted' => 'You have already submitted an order for this unit or service.',
        'unit_not_available' => 'The requested unit is currently not available for ordering.',
        'not_approved_for_appointment' => 'This order has not been approved for booking an appointment yet.'
    ],

    'appointments'  => [
        'slot_not_available' => 'The selected time slot is no longer available.',
        'cannot_cancel_late' => 'Appointments cannot be cancelled less than 24 hours in advance. Please contact customer service.',
    ],

    'project' => [
        'project_has_no_buildings' => 'The selected project does not contain any buildings. Engineer allocation cannot be completed.',
    ],

    'unit' => [
        'invalid_price' => 'Price couldn\'t be negative'
    ],

    'attendance' => [
        'outside_geofence'          => 'You are outside the permitted geographical boundaries. You are currently :distance meters away from the site.',
        'already_checked_in'        => 'You have already recorded your attendance for today at :time.',
        'different_device'          => 'This device is not registered to your account. Please contact the administration to authorize this new device.',
        'building_required'         => 'The building (building_id) must be specified to determine the exact location of attendance.',
        'not_checked_in_yet'        => 'No active check-in record found for this session to complete the check-out.',
        'not_checked_in_yet_report' => 'No active check-in record found for this session to upload the report.',
        'low_gps_accuracy'          => 'GPS signal is weak (Accuracy: :current meters). The system requires an accuracy better than :required meters. Please move to an open area.',
        'mock_location_detected'    => 'Attendance rejected! The use of fake location applications (Mock Location) is strictly prohibited.',
        'shift_timeout'             => 'You forgot to check out from your previous shift on :date. Please contact management to adjust your hours.',
        'building_project_mismatch' => 'The selected building does not belong to the specified project. Please verify your selection.',
        'before_project_start'      => 'Cannot record attendance because the project has not officially started yet (Project start date: :date).',
        'future_time_detected'      => 'Attendance rejected! Please set your phone time and date to automatic (Future time detected).',
        'offline_sync_expired'      => 'Sorry, this attendance cannot be synced because it is too old and exceeded the maximum allowed offline period of :days days.',
        'invalid_checkout_time'     => 'Invalid operation. Check-out time cannot be before check-in time.',
    ],

    'appointment' => [
        'done'      => 'The appointment has been finished sucessfully.',
        'booked'    => 'The appointment has been booked sucessfully.',
        'cancelled' => 'The appointment has been cancelled sucessfully.',

        'cannot_complete_future_appointment' => 'You cannot compoete a future appointment!',
    ],

    'chat' => [
        'room_not_found' => 'The requested chat room was not found in the system.',
        'unauthorized_access' => 'You are not authorized to access this chat room.',
    ],

    'lottery' => [
        'not_open' => 'This lottery is not open for modifications or drawing.',
        'cannot_update' => 'You cannot update this lottery as it is already closed or cancelled.',
        'cannot_cancel' => 'You cannot cancel a lottery that is not currently open.',
        'cannot_draw' => 'This lottery is not valid for drawing.',
        'no_participants' => 'There are no eligible clients in this lottery to perform the draw.',
        'not_found' => 'The requested lottery could not be found.',
    ],

    'payment' => [
        'cannot_be_updated' => 'This payment cannot be updated because it is no longer pending.',
        'custom_payment_success' => 'The amount has been successfully distributed and the payments have been settled.',
        'exceeds_remaining_balance' => 'The paid amount (:paid_amount) is greater than the total pending payments for the contract (:total_pending_amount). The operation cannot be completed.',
    ],

    'transaction' => [
        'voucher_number_required' => 'The voucher number is required.',
        'voucher_number_unique'   => 'This voucher number has already been taken.',
        'type_required'           => 'The transaction type (receipt/payment) is required.',
        'type_invalid'            => 'The selected transaction type is invalid.',
        'amount_required'         => 'The amount is required.',
        'amount_must_be_positive' => 'The amount must be greater than zero.',
        'category_required'       => 'The transaction category is required.',
        'payment_method_required' => 'The payment method is required.',
    ],

    'legal' => [
        'exception_reason_required'   => 'The exception reason is required when modifying standard terms.',
        'original_total_price_required' => 'Please provide the original price before discount.',
        'down_payment_lte_total'     => 'The down payment amount cannot exceed the total price.',
    ],
    'finance' => [
        'invalid_status'             => 'The status must be either approved or rejected.',
        'rejection_reason_required'  => 'Please provide a reason for the financial rejection.',
    ],

    'insight' => [
        'marked_as_read' => 'Insight marked as read successfully.',
        'retrieved_successfully' => 'Construction insights retrieved successfully.',
    ],

    'contract'  => [
        'non-draft_change' => 'Couldn\'t change non-draft contract',
        'missing_appointment_exception'  => 'Workflow bypassed: Contract created without a prior completed appointment.',
        'contract_approved_successfully' => 'Contract approved successfully and financial payments generated.',
        'contract_not_pending'           => 'Operation failed. The contract is not in a pending approval state.',

        'exception_approved'   => 'Financial exception approved. Contract changed to draft and payments generated successfully.',
        'exception_rejected'   => 'Financial exception rejected. Contract status updated to rejected.',
    ],

    'offer' => [
        'item_not_available' => 'Cannot add an offer! This item is currently not available (sold or reserved).',
    ],

    'faq' => [
        'not_found' => 'FAQ node not found.',
        'created'   => 'FAQ node created successfully.',
        'updated'   => 'FAQ node updated successfully.',
        'deleted'   => 'FAQ node deleted successfully.',
    ],

    'notification'  => [
        'overdue_client_title' => '⚠️ Payment Overdue Alert',
        'overdue_client_body'  => 'We would like to remind you that the payment due on :date for the amount of :amount has not been settled for contract #:contract.',

        'overdue_employee_title' => 'Client Payment Overdue',
        'overdue_employee_body'  => 'Client :name has an overdue payment for contract #:contract.',
    ]
];
