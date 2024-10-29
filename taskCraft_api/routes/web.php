<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-email', function () {
    $details = [
        'subject' => 'Test Email',
        'message' => 'This is a test email sent from Laravel.'
    ];

    Mail::raw($details['message'], function($message) use ($details) {
        $message->subject($details['subject'])
            ->from('hello@example.com', config('app.name'))
            ->to('test@example.com');
    });

    return 'Test email sent!';
});
