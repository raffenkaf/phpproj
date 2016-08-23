<?php
return [
    'login' => [
        'type' => 2,
    ],
    'logout' => [
        'type' => 2,
    ],
    'error' => [
        'type' => 2,
    ],
    'sign-up' => [
        'type' => 2,
    ],
    'index' => [
        'type' => 2,
    ],
    'updatePersonalData' => [
        'type' => 2,
    ],
    'addBook' => [
        'type' => 2,
    ],
    'updateBook' => [
        'type' => 2,
    ],
    'deleteBook' => [
        'type' => 2,
    ],
    'searchBook' => [
        'type' => 2,
    ],
    'addAuthor' => [
        'type' => 2,
    ],
    'updateAuthor' => [
        'type' => 2,
    ],
    'deleteAuthor' => [
        'type' => 2,
    ],
    'searchAuthor' => [
        'type' => 2,
    ],
    'guest' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'login',
            'error',
            'sign-up',
            'index',
            'searchAuthor',
            'searchBook',
        ],
    ],
    'user' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'logout',
            'addAuthor',
            'addBook',
            'updatePersonalData',
            'guest',
        ],
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'updateAuthor',
            'deleteAuthor',
            'updateBook',
            'deleteBook',
            'user',
        ],
    ],
];
