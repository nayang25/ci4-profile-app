<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Alice Moreau',    'email' => 'alice@example.com',   'bio' => 'Passionate UX designer who loves pastel aesthetics and pixel-perfect interfaces.'],
            ['name' => 'Ben Takahashi',   'email' => 'ben@example.com',     'bio' => 'Full-stack developer, coffee enthusiast, and weekend guitarist.'],
            ['name' => 'Clara Ndiaye',    'email' => 'clara@example.com',   'bio' => 'Product manager turning messy requirements into elegant solutions.'],
            ['name' => 'Diego Vargas',    'email' => 'diego@example.com',   'bio' => 'DevOps engineer who automates everything — including his morning coffee order.'],
            ['name' => 'Elena Sørensen',  'email' => 'elena@example.com',   'bio' => 'Data scientist and avid baker. Finds patterns in datasets and sourdough alike.'],
            ['name' => 'Finn O\'Brien',   'email' => 'finn@example.com',    'bio' => 'Backend architect specialising in distributed systems and long walks on the beach.'],
            ['name' => 'Gabi Ferreira',   'email' => 'gabi@example.com',    'bio' => 'Mobile developer crafting delightful iOS experiences one swipe at a time.'],
            ['name' => 'Hana Yoshida',    'email' => 'hana@example.com',    'bio' => 'Security researcher, CTF competitor, and cat person.'],
            ['name' => 'Ivan Petrov',     'email' => 'ivan@example.com',    'bio' => 'Machine learning engineer training models by day, painting by night.'],
            ['name' => 'Jade Laurent',    'email' => 'jade@example.com',    'bio' => 'Technical writer making complex topics accessible to everyone.'],
            ['name' => 'Kofi Mensah',     'email' => 'kofi@example.com',    'bio' => 'Cloud architect helping startups scale without breaking the bank.'],
            ['name' => 'Luna Reyes',      'email' => 'luna@example.com',    'bio' => 'Accessibility advocate ensuring the web works for everyone.'],
        ];

        $now = date('Y-m-d H:i:s');
        foreach ($users as &$u) {
            $u['avatar']     = null;
            $u['created_at'] = $now;
            $u['updated_at'] = $now;
        }

        $this->db->table('users')->insertBatch($users);
    }
}
