<?php

declare(strict_types = 1);

namespace aleslanger\Forms\CheckBoxTree\Bridges;

use Nette,   
    Nette\Forms\Container;

/**
 * Class ExtensionMethodRegistrator
 * @package aleslanger\Forms\CheckBoxTree\Bridges
 */
class ExtensionMethodRegistrator
{
    use Nette\StaticClass;
    
    public static function register()
    {

        Container::extensionMethod('addCheckBoxTree', 
                                    function (Container $_this, $name, $label, array $items = NULL) {
                                                return $_this[$name] = new \aleslanger\Forms\CheckBoxTree\CheckBoxTree($label, $items);
                                    });
    }

    
}

