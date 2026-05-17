<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'email', 'bio', 'avatar'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'name'  => 'required|min_length[2]|max_length[100]',
        'email' => 'required|valid_email|max_length[150]|is_unique[users.email,id,{id}]',
        'bio'   => 'permit_empty|max_length[500]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Name is required.',
            'min_length' => 'Name must be at least 2 characters.',
        ],
        'email' => [
            'required'    => 'Email is required.',
            'valid_email' => 'Please enter a valid email address.',
            'is_unique'   => 'This email is already registered.',
        ],
    ];

    /**
     * Search users by name or email with pagination.
     */
    public function searchPaginate(string $search = '', int $perPage = 5)
    {
        if ($search !== '') {
            $this->groupStart()
                 ->like('name', $search)
                 ->orLike('email', $search)
                 ->groupEnd();
        }

        return $this->orderBy('created_at', 'DESC')
                    ->paginate($perPage, 'default');
    }
}
