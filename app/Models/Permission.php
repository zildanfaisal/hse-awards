<?php
namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    // Custom logic jika perlu, tapi jangan override relasi bawaan Spatie
} 