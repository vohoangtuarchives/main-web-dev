<?php
namespace Packages\Core;

interface Service{
    public function getRepository(): Repository;
}