<?php

require_once __DIR__ . "/../libs/form.php";

global $price_full;
global $price_full_concession;

$errors = [];
$inputs = [];

// All the form fields for ArmadaCon registration
$form_fields = [
    'email' => [
        'type' => 'email',
        'label' => "Email:",
        'placeholder' => 'Your email address',
        'rule' => 'email | required | email | unique: users, email'
    ],
    'first-name' => [
        'type' => 'text',
        'label' => 'First Name:',
        'placeholder' => 'Your given name',
        'rule' => 'string | required',
    ],
    'last-name' => [
        'type' => 'text',
        'label' => 'Last Name:',
        'placeholder' => 'Your surname',
        'rule' => 'string | required',
    ],
    'badge-name' => [
        'type' => 'text',
        'label' => 'Badge Name (if different):',
        'placeholder' => 'Badge name',
        'rule' => 'string',
    ],
    'address-first-line' => [
        'type' => 'text',
        'label' => 'First Line of Address:',
        'placeholder' => 'First line of address',
        'rule' => 'string | required',
    ],
    'address-second-line' => [
        'type' => 'text',
        'label' => 'Second Line of Address:',
        'rule' => 'string',
    ],
    'address-post-code' => [
        'type' => 'text',
        'label' => 'Post code:',
        'placeholder' => 'Post code',
        'rule' => 'string | required',
    ],
    'membership-type' => [
        'type' => 'select',
        'label' => 'Membership Type:',
        'options' => [
            "full-weekend" => "Full weekend membership £$price_full",
            "full-weekend-concession" => "Full weekend concession membership £$price_full_concession",
            "deposit" => "Membership deposit £10 - Balance paid upon arrival",
            "previous-guest" => "Previous guest"
        ],
        'rule' => 'string | required',
    ],
    'code-of-conduct-agreement' => [
        'type' => 'checkbox',
        'label' => 'I have read and agree to abide by <a href="/policies.php" target="_new">the convention code of conduct and policies</a>',
        'rule' => 'string | required'
    ],
    'detail-understanding' => [
        'type' => 'checkbox',
        'label' => 'I understand my details will be kept in a computerised database. My information will not be shared with outside organisations.',
        'rule' => 'string | required'
    ],
];

function create_registration_form(): string {
    global $form_fields;

    $form = '';
    foreach ($form_fields as $name => $specs) {
        $form .= create_form_field($name, $specs);
    }
    return $form;
}

if (is_post_request()) {
    $fields = [];
    foreach ($form_fields as $name => $specs) {
        $fields += [$name => $specs['rule']];
    }

    // custom messages
    $messages = [
        'password2' => [
            'required' => 'Please enter the password again',
            'same' => 'The password does not match'
        ],
        'code-of-conduct-agreement' => [
            'required' => 'You need to agree to the term of services to register'
        ]
    ];

    [$inputs, $errors] = filter($_POST, $fields, $messages);

    if ($errors) {
        redirect_with('/register', [
            'inputs' => $inputs,
            'errors' => $errors
        ]);
    }

    if (register_user($inputs)) {
        // TODO Set a session value stating the registration was successful.
        redirect_with_message(
            '/register',
            'Your membership has been registered successfully.'
        );
    }

} else if (is_get_request()) {
    [$inputs, $errors] = session_flash('inputs', 'errors');
}