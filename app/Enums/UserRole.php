<?php


namespace App\Enums;


use MyCLabs\Enum\Enum;

/**
 * Class UserRole
 * @package App\Enums
 *
 * PHP provides an extension called SplEnum which lets you create enums. This is useful for roles.
 */
class UserRole extends Enum
{
    const Admin = 'admin';
    const Editor = 'editor';
    const Regular = 'regular';
}
