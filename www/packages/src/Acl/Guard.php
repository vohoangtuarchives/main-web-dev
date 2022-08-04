<?php
namespace Packages\Acl;

interface Guard{
    public function check(): bool;
}