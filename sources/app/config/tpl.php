<?php

return
[
    'login' =>
    [
        'language' => 'en',
        'title' => 'Camagru | Login',
        'name' => 'login',

        'includes' =>
        [
            [
                'type' => COMPONENTS . 'input.tpl'
                'data' =>
                [
                    'name' => 'user',
                    'label_text' => '',
                    'input_type' => 'text'
                ]
            ],

            [
                'type' => COMPONENTS . 'input.tpl'
                'data' =>
                [
                    'name' => 'user',
                    'label_text' => '',
                    'input_type' => 'text'
                ]
            ],
        ],

    ],

    'signin' =>
    [

    ]
];

<label for="{{::name::}}">{{::label_text::}}</label>
<input type="{{::input_type::}}" name="{{::name::}}">

<label for="user">{{::user::}}</label>
<input type="text" name="user">

<label for="pass">{{::pass::}}</label>
<input type="password" name="pass">

