<?php
declare(strict_types=1);

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

        $posts = [
            [
                'title' => 'Title 1',
                'body' => 'Body of title 1',
            ],
            [
                'title' => 'Title 2',
                'body' => 'Body of title 2',
            ],
        ];

        $postsCount = count($posts);

        $this->set(compact('users', 'posts', 'postsCount'));
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

    public function store()
    {
        return $this->redirect('/users/index');
    }

    public function internalServerError()
    {
        throw new \Exception();
    }

    public function setSuccessFlash()
    {
        $this->Flash->success('User saved successfully.');
    }

    public function setErrorFlash()
    {
        $this->Flash->error('Something went wrong!');
    }
}
