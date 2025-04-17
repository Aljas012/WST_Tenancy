<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ApprovedTenant;
use Illuminate\Support\Facades\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

use App\Models\Tenant;

class CreateTenantAccount implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle()
    {
        tenancy()->initialize($this->tenant);
        // dd($this->tenant, $this->tenant->data);

        $name = $this->tenant->full_name;
        $email = $this->tenant->email;
        $password = Str::random(8);

        User::create([
            'name' =>  $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        Notification::route('mail', $email)
            ->notify(new ApprovedTenant($this->tenant, $password));
    }
}
