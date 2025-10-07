<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateOrUpdateSingleAdmin extends Command
{
    protected $signature = 'user:admin {email} {--name=} {--last_name=} {--phone=} {--password=}';

    protected $description = 'Создать или обновить администратора';

    public function handle(): int
    {
        $email = (string) $this->argument('email');
        $name = (string) ($this->option('name') ?? 'Admin');
        $lastName = (string) ($this->option('last_name') ?? 'User');
        $phone = $this->option('phone');
        $passwordOption = $this->option('password');

        $password = $passwordOption ? (string) $passwordOption : bin2hex(random_bytes(8));

        $admin = User::query()->where('is_admin', true)->first();

        if ($admin) {
            $admin->fill([
                'name' => $name,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'password' => Hash::make($password),
            ])->save();
            $this->info('Admin user updated.');
        } else {
            $admin = User::query()->create([
                'external_id' => 0,
                'name' => $name,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'password' => Hash::make($password),
                'is_admin' => true,
            ]);
            $this->info('Admin user created.');
        }

        $this->line('Email: ' . $admin->email);
        $this->line('Password: ' . $password);

        return self::SUCCESS;
    }
}


