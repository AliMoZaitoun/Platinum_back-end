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
    ],
];
