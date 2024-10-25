<?php

namespace App\Enums;

enum AdminFunction: string
{
    const CA_PRESIDENT = 'ca_president';
    const EXECUTIVE_ADMIN = 'ca_executive_admin';
    const NON_EXECUTIVE_ADMIN = 'ca_non_executive_admin';
    const INDEPENDANT_ADMIN = 'ca_independent_admin';

    const ADMIN_FUNCTIONS = [
        AdminFunction::CA_PRESIDENT,
        AdminFunction::EXECUTIVE_ADMIN,
        AdminFunction::NON_EXECUTIVE_ADMIN,
        AdminFunction::INDEPENDANT_ADMIN,
    ];

    const ADMIN_FUNCTIONS_VALUES = [
        AdminFunction::CA_PRESIDENT => "Président Conseil D'administration",
        AdminFunction::EXECUTIVE_ADMIN => 'Administrateur exécutif',
        AdminFunction::NON_EXECUTIVE_ADMIN => 'Administrateur non exécutif',
        AdminFunction::INDEPENDANT_ADMIN => 'Administrateur indépendant',
    ];
}
