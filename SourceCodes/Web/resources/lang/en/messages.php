<?php

return[
    'loggedin'                      => 'User loggedIn successfully!',
    'invalid_login_credentials'     => 'Login credentials are invalid.',
    'logged_out'                    => 'User has been logged out',
    'logout_error'                  => 'Sorry, user cannot be logged out',
    'email_not_varify_error'        => 'You need to verify your account. We have sent you an activation code, please check your email.',
    'email_cannot_identified'       => 'Sorry your email cannot be identified.',
    'email_verified'                => 'Your email is verified. You can now login.',
    'email_already_verified'        => 'Your email is already verified. You can login.',
    'connect_with_stripe_error'     => 'Some things went wrong. Please try again!',
    'already_checked'               => "QR code already scanned!",
    'record_not_found'              => "Record not found!",
    'record_found'                  => "The record has been found successfully!",
    'record_updated'                => "The record has been updated successfully!",
    'record_created'                => "The record has been created successfully!",
    'record_deleted'                => "The record has been deleted successfully!",
    'insufficient_amount'           => 'You have insufficient amount! You need to pay $',
    'extra_amount'                  => "You are paying more than the given amount! You need to pay $",
    'payment_success'               => 'Payment successfully done!',
    'order_success'                 => 'Your order placed successfully!',
    'contect_query'                 => 'Your query send successfully',
    'unsubscribe'                   => 'You are unsubscribed this application',
    'cart_added'                    => 'Cart item added successfully!',
    'cart_updated'                  => 'Cart item updated successfully!',
    'cart_deleted'                  => 'Cart item deleted successfully!',
    'cart_not_found'                => 'Item not found!',
    'cart_error'                    => 'Something went wrong. Please try again!',
    'emailId_error'                 => 'You are not subscribed user.',
    'wrong_otp'                     => "Wrong OTP! Please enter correct OTP.",
    'wrong_token'                   => "Invalid token!",
    'otp_sent'                      => 'OTP has been sent to your email id',
    'reset_password'                => "you have successfully reset your password",

    /**
     * Admin user message
     */
    'admin_user' => [
        'success'   => [
            'save'              => "User saved successfully!",
            'update'            => "User updated successfully!",
            'delete'            => "User deleted successfully!",
            'change_status'     => "User status change successfully!",
            'saved_admin'       => "Admin saved successfully! We have send welcome mail to user with login credentials!",
            'admin_loggedIn'    => 'Welcome on dashboard',
            'user_loggedIn'     => 'User logged In successfully',
            'user_registered'   => 'The user registered successfully! We have sent a verification link to your mail please first verify the mail.',
        ],
        'error'     => [
            'save'              => "Something went wrong! Please try again.",
            'not_found'         => "User not found!",
            'not_active'        => 'You are not active user any more! Please contect to admin support.',
        ]
    ],

    /**
     * Promoter user message
     */
    'promoter_user' => [
        'success'   => [
            'save'                  => "Promoter saved successfully!",
            'update'                => "Promoter updated successfully!",
            'delete'                => "Promoter deleted successfully!",
            'change_status'         => "Promoter status change successfully!",
            'promoter_registered'   => 'Promoter registered successfully! We have sent a verification link to your mail please first verify the mail.',
        ],
        'error'     => [
            'save'                  => "Promoter not saved. Please try again!",
            'not_found'             => "Promoter not found!",
            'not_active'            => 'You are not active promoter any more! Please contect to admin support.',
        ]
    ],

    /**
     * Change Password message
     */
    'change_password' => [
        'success'   => [
            'change'                => "Password changed successfully!",
        ],
        'error'     => [
            'password_not_match'    => "Your old password doesn't matching! Please enter correct password",
            'same_password'         => "New Password cannot be same as your old password."
        ]
    ],

    /**
     * Category message
     */
    'category' => [
        'success'   => [
            'save'          => "Category saved successfully!",
            'update'        => "Category updated successfully!",
            'delete'        => "Category deleted successfully!",
            'change_status' => "Category status change successfully!"
        ],
        'error'     => [
            'save'          => "Category not saved. Please try again!",
            'not_found'     => "Category not found"
        ]
    ],

    /**
     * Event message
     */
    'event' => [
        'success'   => [
            'save'              => "Event saved successfully!",
            'update'            => "Event updated successfully!",
            'delete'            => "Event deleted successfully!",
            'change_status'     => "Event status change successfully!",
            'cancel'            => "Event was cancelled successfully!"
        ],
        'error'     => [
            'save'              => "Event not saved. Please try again!",
            'update'            => "Event not update. Please try again!",
            'not_found'         => "Event not found",
            'date_error'        => 'End date and time can not be less then current date and time.',
            'start_date_error'  => 'End date and time can not be less then start date and time.',
            'ticket_error'      => 'First you need to create tickets for this event',
        ]
    ],

    /**
     * Ticket message
     */
    'ticket' => [
        'success'   => [
            'save'              => "Ticket saved successfully!",
            'update'            => "Ticket updated successfully!",
            'delete'            => "Ticket deleted successfully!",
            'change_status'     => "Ticket status change successfully!"
            
        ],
        'error'     => [
            'save'              => "Ticket not saved. Please try again!",
            'not_found'         => "Ticket not found",
            'date_error'        => 'End date and time can not be less then current date and time.',
            'not_less_then_1'   => 'Ticket quantity can not be less then 1.',
            'end_date_error'    => 'End date can not be null',
            'delete'            => 'Ticket previously deleted!',
            'price_error'       => "Paid ticket price must be greater than 0"
        ]
    ],

    /**
     * Promoter access
     */
    'promoter_access' => [
        'request_sent'          => 'Your request send successfully to admin! Please wait for admin approval.',
        'already_requested'     => 'You already requested to admin for this events!',
        'request_pending'       => 'Request pending, Request is in pending condition',
        'request_approved'      => 'Request approved, Now promoter can promote this event.',
        'request_rejected'      => "Request rejected, Promoter can't promote the event",
    ],

    /**
     * Subscribe message
     */
    'subscribe_app' => [
        'subscribed'            => 'Now you are subscribed user',
        'already_subscribed'    => 'You are already subscribed user',
        'delete'                => 'Subscribed User has been removed from the list'
    ],

    /**
     * Referral Events
     */
     'referred_event' => [
        'able_to_use'           => 'Now you can use this referral link.',
        'already_able_to_use'   => 'Your are already able to use this referral link.',
        'already_ussed'         => 'Your are already used this referral link',
        'same_user_error'       => 'Same user not able to use this referral link',
        'invalid_referral_link' => 'Invalid referral link',
     ],

     /**
      * Forgot Password Message
      */
      'forgot_message' => [
        'reset_link'            => 'We have e-mailed your password reset link!',
        'change_success'        => 'Your password change successfully! Please login with your new password.',
      ],

    /**
     * Banner message
     */
    'banner_image' => [
        'success'   => [
            'save'              => "Banner saved successfully!",
            'update'            => "Banner updated successfully!",
            'delete'            => "Banner deleted successfully!",
            'change_status'     => "Banner status change successfully!",
        ],
        'error'     => [
            'save'              => "Banner not saved. Please try again!",
            'not_found'         => "Banner not found!",
            'image_required'    => 'Banner image is required!',
        ]
    ],

    /**
     * Error from stripe
     */

    'stripe_error'  => "Something Went Wrong",
];
