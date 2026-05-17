<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Users extends Controller
{
    protected UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
        helper(['form', 'url', 'filesystem']);
    }

    // ----------------------------------------------------------------
    // LIST  –  paginated + optional search
    // ----------------------------------------------------------------
    public function index(): string
    {
        $search = $this->request->getGet('search') ?? '';

        $data = [
            'title'   => 'User Directory',
            'search'  => $search,
            'users'   => $this->model->searchPaginate($search, 5),
            'pager'   => $this->model->pager,
        ];

        return view('layouts/main', $data + ['content' => view('users/index', $data)]);
    }

    // ----------------------------------------------------------------
    // CREATE FORM
    // ----------------------------------------------------------------
    public function create(): string
    {
        return view('layouts/main', [
            'title'   => 'Add New User',
            'content' => view('users/create'),
        ]);
    }

    // ----------------------------------------------------------------
    // STORE  –  validate + move avatar + save
    // ----------------------------------------------------------------
    public function store()
    {
        // Basic field rules
        if (! $this->validate([
            'name'  => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[150]|is_unique[users.email]',
            'bio'   => 'permit_empty|max_length[500]',
        ])) {
            return view('layouts/main', [
                'title'      => 'Add New User',
                'content'    => view('users/create'),
                'validation' => $this->validator,
            ]);
        }

        $avatar = $this->request->getFile('avatar');
        $avatarName = null;

        if ($avatar && $avatar->isValid() && ! $avatar->hasMoved()) {
            // Validate: image only, max 2 MB
            if (! $this->validateAvatar($avatar)) {
                return view('layouts/main', [
                    'title'      => 'Add New User',
                    'content'    => view('users/create'),
                    'avatarError' => session()->getFlashdata('avatarError'),
                ]);
            }

            $avatarName = $avatar->getRandomName();
            $avatar->move(ROOTPATH . 'public/uploads/', $avatarName);
        }

        $this->model->insert([
            'name'   => esc($this->request->getPost('name')),
            'email'  => esc($this->request->getPost('email')),
            'bio'    => esc($this->request->getPost('bio')),
            'avatar' => $avatarName,
        ]);

        return redirect()->to('/users')->with('success', 'User created successfully! 🎉');
    }

    // ----------------------------------------------------------------
    // SHOW  –  single profile
    // ----------------------------------------------------------------
    public function show(int $id): string
    {
        $user = $this->model->find($id);

        if (! $user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('layouts/main', [
            'title'   => $user['name'] . "'s Profile",
            'content' => view('users/show', ['user' => $user]),
        ]);
    }

    // ----------------------------------------------------------------
    // DELETE
    // ----------------------------------------------------------------
    public function delete(int $id)
    {
        $user = $this->model->find($id);

        if ($user && $user['avatar']) {
            $path = ROOTPATH . 'public/uploads/' . $user['avatar'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $this->model->delete($id);

        return redirect()->to('/users')->with('success', 'User deleted.');
    }

    // ----------------------------------------------------------------
    // PRIVATE HELPER
    // ----------------------------------------------------------------
    private function validateAvatar($file): bool
    {
        $allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize     = 2048; // KB

        if (! in_array($file->getMimeType(), $allowedMime)) {
            session()->setFlashdata('avatarError', 'Avatar must be an image (JPG, PNG, GIF, WEBP).');
            return false;
        }

        if ($file->getSizeByUnit('kb') > $maxSize) {
            session()->setFlashdata('avatarError', 'Avatar must be smaller than 2 MB.');
            return false;
        }

        return true;
    }
}
