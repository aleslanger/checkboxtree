# Checkbox Tree control for [Nette Framework](http://nette.org)


## Requirements

- [Nette Framework](https://github.com/nette/nette)


## Installation

```
composer require aleslanger/checkboxtree
```

You can enable the extension using your neon config:

```yml
extensions:
    	CheckBoxTree:  aleslanger\Forms\CheckBoxTree\DI\CheckBoxTreeExtension
```

or register for example to bootstrap.php:
```php
\aleslanger\Forms\CheckBoxTree\Bridges\ExtensionMethodRegistrator::register();
```




## Usage 


```php

$form = new \Nette\Forms\Form;  
  
/*             
 - First
      |___ - Third
 - Second                  
 */
 
 $items = array( 1 => array('id' => 1, 'title' => 'First',  'parent_id' => ''),
                 2 => array('id' => 2, 'title' => 'Second', 'parent_id' => ''),
                 3 => array('id' => 3, 'title' => 'Third',  'parent_id' => 1),);
  
              
$form->addCheckboxTree("list", "Label", $items);       

```

the input array must contain keys (id, title, parent_id), key title is label for checkbox.

## License

The MIT License (MIT)


