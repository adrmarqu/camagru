<?php

$year = date("Y");

$lang =
[
    'title' =>
    [
        // Core
        'gallery' => 'Gallery',
        'editor' => 'Photo Editor',
        // Auth
        'login' => 'Log in',
        'signin' => 'Sign up',
        'forgot' => 'Forgot password',
        // User
        'profile' => 'Profile',
        'favorites' => 'Favorites',
        'private-gallery' => 'My Gallery',
        // Token
        'verify' => 'Verification',
        'result' => 'Result',
        'reset-password' => 'Reset password',
        'send-email' => 'Send email'
    ],

    'es' => 'Spanish',
    'ca' => 'Catalan',
    'en' => 'English',

    'header' =>
    [
        'gallery' => 'Gallery',
        'editor' => 'Photo Editor',
        'login' => 'Log in',
        'signin' => 'Sign up',
        'profile' => 'Profile',
        'favorites' => 'My Favorites',
        'private' => 'My Gallery',
        'logout' => 'Log out',
        'languages' => 'Languages'
    ],

    'link' =>
    [
        'gallery' => 'Back to Gallery'
    ],

    'db' =>
    [
        'exists' =>
        [
            'user' => 'That username is already in use',
            'email' => 'That email is already in use'
        ]
    ],

    'form' =>
    [
        'label' =>
        [
            'usermail' => 'Username or Email',
            'user' => 'Username',
            'email' => 'Email',
            'pass' => 'Password',
            'conf' => 'Confirm password',
        ],
        // Placeholder
        'ph' =>
        [
            'usermail' => 'Username or Email',
            'user' => 'Username',
            'email' => 'Email',
            'pass' => 'Password',
            'conf' => 'Repeat password',
            'new' => 'New password',
            'confi' => 'Repeat new password',
            'curr' => 'Current password',
            'comment' => 'Write a comment'
        ],
        // Errors
        'error' =>
        [
            'user' => 'Username must start with a letter and contain only letters, numbers, and hyphens',
            'email' => 'Email must be valid',
            'pass' => 'Password must have 8-72 characters, one uppercase, one lowercase, and one number',
            'conf' => 'Passwords do not match'
        ],
        // Error void
        'void' => 'This field is required'
    ],

    'login' =>
    [
        'title' => 'Log in',
        'intro' => 'Welcome back.',
        'remember' => 'Remember me',
        'no_account' => 'Don\'t have an account? ',
        'new' => 'Sign up',
        'forgot' => 'Forgot your password? ',
        'reset' => 'Recover it'
    ],

    'signin' =>
    [
        'title' => 'Sign up',
        'intro' => 'Welcome to Camagru',
        'accept' => 'I accept the ',
        'terms' => 'Terms and Conditions',
        'account' => 'Already have an account? ',
        'log' => 'Log in',
        'no_terms' => 'You must accept the terms and conditions'
    ],

    'forgot' =>
    [
        'title' => 'Forgot password',
        'intro' => 'Enter your account email',
        'message' => 'I remembered my password! ',
        'login' => 'Log in'    
    ],

    'send' =>
    [
        'title' => 'Send email',
        'intro' => 'You can resend an email',
        'message' => 'I don\'t need it anymore! ',
        'home' => 'Go to Gallery'
    ],

    'reset' =>
    [
        'title' => 'Reset password',
        'intro' => 'Enter your new password',
        'message' => 'I don\'t want to change my password! ',
        'login' => 'Log in'
    ],

    'result' =>
    [
        'account' => 'Congratulations! <br><br> Your account is now active. You can now log in to Camagru.',
        'email' => 'Congratulations! <br><br> Your new email address has been successfully updated.',
        'reset' => 'Congratulations! <br><br> Your password has been successfully reset.'
    ],

    'profile' =>
    [
        'danger' =>
        [
            'title' => 'Danger Zone',
            'delete' => 'Delete your account',
            'sure' => 'Are you sure you want to delete your account?',
            'confirm' => 'This action is irreversible. Once deleted, your account cannot be recovered. Furthermore, all your photos, comments, and likes will be permanently removed from Camagru. Click cancel to return to your profile.',
            'pass' => 'Enter your password to confirm'
        ],
        'noti' =>
        [
            'title' => 'Preferences',
            'label' => 'Receive email notifications'
        ],
        'stats' =>
        [
            'change_photo' => 'Change avatar',
            'title' => 'Statistics',
            'photos' => 'Uploaded photos',
            'likes' => 'Likes received',
            'comments' => 'Comments received'
        ],
        'security' =>
        [
            'title' => 'Security',
            'curr' => 'Current password',
            'new' => 'New password',
            'conf' => 'Confirm new password'
        ],
        'info' =>
        [
            'title' => 'Information',
            'user' => 'Username'
        ]
    ],

    'editor' =>
    [
        'size' => 'Size',
        'rotate' => 'Rotation',
        'sticker' =>
        [
            'cat' => 'Cat ears',
            'fire' => 'Fire',
            'flowers' => 'Flowers',
            'fog' => 'Fog',
            'glasses' => 'Sunglasses',
            'hat' => 'Top hat',
            'moustache' => 'Moustache'
        ]
    ],

    'gallery' =>
    [
        'empty' => 'There are currently no images on the server.',
        'load' => 'No more images on the server.',
        'error' => 'Failed to load images from the server.',
        'no_comment' => 'No comments yet. Be the first!',
        'do' => 'to comment or like',
        'sure' => 'Are you sure you want to delete this post? Its likes and comments will be permanently removed.'
    ],

    'btn' =>
    [
        'send' => 'Send',
        'cancel' => 'Cancel',
        'delete' => 'Delete account',
        'update' => 'Update',
        'edit' => 'Edit',

        'gallery' => 'Back to Gallery',
        'login' => 'Log in',
        'profile' => 'Back to Profile',

        'sticker' => 'Remove sticker',
        'download' => 'Download',
        'thumbnail' => 'Delete',
        'capture' => 'Take photo',

        'more' => 'Load more'
    ],

    'email' =>
    [
        'account' =>
        [
            'subject' => 'Welcome to Camagru! Activate your account',
            'title' => 'Account Activation',
            'link' => 'Activate my account',
            'body' => 'Thank you for signing up for Camagru. To start using your account and enjoy all features, please activate it by clicking the button below. Note that this link will expire in 30 minutes. To request a new link, go back to /send-email and send a new email. You can also log in with your account to receive a new email.'
        ],

        'email' =>
        [
            'subject' => 'Confirm your new email',
            'title' => 'Email Confirmation',
            'link' => 'Confirm new email',
            'body' => 'Camagru has received a request to change your email address. If this was you, please click the button below to confirm the change. If you did not request this change, you can safely ignore this message. Note that this link will expire in 10 minutes. To request a new link, go back to /send-email or change your email from your profile.'
        ],

        'reset' =>
        [
            'subject' => 'Reset your password',
            'title' => 'Recover password',
            'link' => 'Reset password',
            'body' => 'Don\'t worry, it happens to all of us. Click the button below to choose a new password securely. Note that for security reasons, this link will expire in 5 minutes. To generate a new link, simply go back to /forgot-password and send another email.'
        ],

        'comment' =>
        [
            'subject' => 'New comment on your photo',
            'title' => 'New comment!',
            'body' => 'commented on one of your photos:',
            'link' => 'View photo'
        ],

        'footer' => "This is an automated email, please do not reply to this message. If you have any issues or did not request this email, please contact support. © $year Camagru. All rights reserved."
    ],

    '200' =>
    [
        'user' => 'Username successfully updated.',
        'email' => 'An email has been sent to confirm the new email address.',
        'usermail' => 'Username updated successfully. A confirmation email has been sent to your new email.',
        'pass' => 'Password successfully updated.',
        'noti' => 'Preferences successfully updated.',
        'avatar' => 'Avatar successfully updated.',
        'image_uploaded' => 'Photo successfully uploaded.',
        'image_deleted' => 'Photo successfully deleted.'
    ],
    // Bad request
    '400' =>
    [
        'title' => 'Bad Request',
        'message' => 'The request could not be processed or is invalid.',
        'corrupt_url' => 'Camagru cannot read that URL (corrupt URL)',
        'not_image' => 'The file is not a valid image.',
        'data' => 'Missing image data or stickers.'
    ],
    // Not authenticated
    '401' =>
    [
        'title' => 'Unauthorized',
        'message' => 'You must log in to access this content.',
        'login' => 'Incorrect username, email, or password.'
    ],
    // Authenticated, but you need admin
    '403' =>
    [
        'title' => 'Access Denied',
        'message' => 'You do not have permission to access this page.',
        'no_token' => 'You need a token to access this page.'
    ],
    // Not found
    '404' =>
    [
        'title' => 'Page Not Found',
        'message' => 'The page you are looking for does not exist or has been moved.',
        'action' => 'That form type does not exist.',
        'no_token' => 'The token does not exist or has expired.',
        'no_file' => 'That file does not exist at that path.',
        'get' => 'The query does not exist in Camagru.'
    ],
    // When you do POST, and POST doesn't exist in that route
    '405' =>
    [
        'title' => 'Method Not Allowed',
        'message' => 'The requested action is not allowed for this page.'
    ],
    // Conflict
    '409' =>
    [
        'title' => 'Conflict',
        'message' => 'A conflict occurred while processing the request (e.g. the resource already exists in the database).',
        'pass' => 'The new password must be different from the current password.'
    ],
    // Expired
    '410' =>
    [
        'title' => 'No Longer Available',
        'message' => 'The requested resource is no longer available and has been permanently deleted (e.g. the link has expired).'
    ],
    // Unprocessable Entity
    '422' =>
    [
        'title' => 'Invalid Data',
        'message' => 'The submitted data is invalid or incomplete.',
        'pass' => 'Incorrect password.'
    ],
    // Internal error
    '500' =>
    [
        'title' => 'Internal Server Error',
        'message' => 'An unexpected error occurred. Please try again later.',
        'not_found' => 'Page file does not exist.',
        'no_class' => 'Class does not exist: ',
        'no_method' => 'Class method does not exist: ',
        'no_access' => 'Access type does not exist: ',
        'token' => 'Failed to create a token. Please try again later.',
        'send' => 'There was an issue sending the email.',
        'db' => 'Database error.',
        'delete_token' => 'Failed to delete token.',
        'activate' => 'Failed to activate account.',
        'change_email' => 'Failed to update email.',
        'type' => 'That token type does not exist.',
        'update_pass' => 'Failed to update password.',
        'delete' => 'Failed to delete account.',
        'no_folder' => 'No directory found to store images.',
        'folder' => 'Failed to create directory.',
        'format' => 'Unsupported image format.',
        'save_image' => 'Error saving image.'
    ],

    'footer' =>
    [
        'rights' => 'All rights reserved.',
        'developed' => 'Developed with ❤️ for',
        'web' => 'My Website'
    ]
];

return $lang;