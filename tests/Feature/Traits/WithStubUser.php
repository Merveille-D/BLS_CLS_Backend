<?php
namespace Tests\Feature\Traits;

use App\Models\Auth\Role;
use App\Models\Auth\Subsidiary;
use App\Models\User;

trait WithStubUser
{
    public function stubUser()
    {
        $subsidiary = Subsidiary::factory()->create();

        // $role = Role::whereName('super_admin')->first();

        $user =  User::factory()->create([
            'subsidiary_id' => $subsidiary->id,
        ]);

        // $user->assignRole($role);

        return $user;
    }
}
