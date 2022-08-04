<?php
namespace Packages\Flow;
use Packages\Core\Action;
use \Packages\Core\Chain as ChainInterface;

class Chain implements ChainInterface{

    protected $actions;

    protected $currentStep;

    public function __construct()
    {
        $this->actions = [];
    }

    public function addStep(string $step, string $actionClass)
    {
        if(!array_key_exists($step, $this->actions)){
            $this->actions[$step] = $actionClass;
        }
    }

    public function doStep(string $step){
        $this->currentStep = $step;
    }
}