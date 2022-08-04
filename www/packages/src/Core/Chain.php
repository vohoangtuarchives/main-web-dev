<?php
namespace Packages\Core;

interface Chain{
    public function addStep(string $step, string $actionClass);
}