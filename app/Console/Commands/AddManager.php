<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class AddManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manager:add {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add manager to system by email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', '=', $email)->first();

        if ($user == null){
            $this->info('User not found!');
            return;
        }

        $user->role = 'manager';
        $user->save();
        $this->info('Manager added.');
    }
}
