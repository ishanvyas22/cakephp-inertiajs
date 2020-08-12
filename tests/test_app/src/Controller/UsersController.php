<?php

namespace TestApp\Controller;

class UsersController extends AppController
{
    public function index()
    {
        $users = [
            [
                'id' => 1,
                'name' => 'John Doe',
            ],
            [
                'id' => 2,
                'name' => 'Alie Doe',
            ],
        ];

        $this->set(compact('users'));
    }

    public function customComponent()
    {
        $component = 'Custom/Component';
        $users = [
            [
                'id' => 1,
                'name' => 'John Doe',
            ],
            [
                'id' => 2,
                'name' => 'Alie Doe',
            ],
        ];

        $this->set(compact('users', 'component'));
    }
}
