<?php
namespace App\Enums;

enum Quality {
    const SHAREHOLDER= 'shareholder';
    const NONSHAREHOLDER = 'non_shareholder';


    const QUALITIES = [
        Quality::SHAREHOLDER,
        Quality::NONSHAREHOLDER,
    ];

    const QUALITIES_VALUES = [
        Quality::SHAREHOLDER => 'Actionnaire',
        Quality::NONSHAREHOLDER => 'Non Actionnaire',
    ];
}
