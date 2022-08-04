<?php
namespace Packages\Acl;

interface Auth{
    public function guard(): Guard;
    public function account(): Account;
    public function role(): Role;
    public function hasPermission($key): bool;
}