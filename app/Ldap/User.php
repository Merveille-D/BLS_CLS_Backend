<?php

namespace App\Ldap;

use Illuminate\Contracts\Auth\Authenticatable;
use LdapRecord\Models\Concerns\CanAuthenticate;
use LdapRecord\Models\Model;

class User extends Model implements Authenticatable
{
    use CanAuthenticate;
    /**
     * The object classes of the LDAP model.
     */
    public static array $objectClasses = [];

    protected string $guidKey = 'id';

    public function getAuthIdentifier()
    {
        // TODO: Implement getAuthIdentifier() method.
    }
}
