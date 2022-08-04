<?php
namespace Packages\Acl;

interface Role{
    public function permission(): bool;
}