<?php

declare(strict_types = 1);

namespace aleslanger\Forms\CheckBoxTree\DI;

use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;

/**
 * Class CheckBoxTreeExtension
 * @package aleslanger\Forms\CheckBoxTree\DI
 */
class CheckBoxTreeExtension extends CompilerExtension {

    public function loadConfiguration() {
        $this->validateConfig([]);
    }

    public function afterCompile(ClassType $class) {
        $init = $class->getMethods()['initialize'];
        $init->addBody(\aleslanger\Forms\CheckBoxTree\Bridges\ExtensionMethodRegistrator::class . '::register();');
    }

}
