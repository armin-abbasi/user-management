<?php

return [

    'users' => [
        'created' => 'User created successfully!',
        'deleted' => 'User deleted successfully!',
        'get' => 'Users retrieved successfully!',
        'exists' => 'User {email} already exists!',
        'not_found' => 'User does not exists',
        'not_authenticated' => 'You are not authenticated.',
    ],
    'groups' => [
        'created' => 'Group created successfully!',
        'deleted' => 'Group deleted successfully!',
        'get' => 'Groups retrieved successfully!',
        'attached' => 'User successfully attached to the group!',
        'detached' => 'User successfully detached from the group!',
        'already_attached' => 'User is already a member of this group.',
        'not_found' => 'Group does not exists',
        'not_empty' => 'Group is not empty',
    ],
    'errors' => [
        'general' => 'Unexpected error happened.',
        'not_found' => 'The requested resource not found.',
        'auth' => 'Failed to authenticate, check your input.',
        'resource_exists' => 'You\'re trying to create a resource that already exists.',
        'invalid_input' => 'Invalid input given.',
    ]
];