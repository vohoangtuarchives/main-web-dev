<?php
namespace Packages\Acl;

interface Account{
    public function role(): Role;
}