<?php

/**
 * Test: alanger\Forms\CheckboxTree
 */
declare(strict_types = 1);

use Nette\Forms\Form;
use Nette\Utils\Html;
use Tester\Assert;
use Tester\TestCase;
use aleslanger\Forms\CheckBoxTree\Bridges;

require __DIR__ . '/../../../bootstrap.php';


\aleslanger\Forms\CheckBoxTree\Bridges\ExtensionMethodRegistrator::register();

class CheckboxTreeRenderTest extends TestCase {

    public $items;

    public function setUp() {

        $this->items = array(
            1 => array('id' => 1, 'title' => 'First - parent', 'parent_id' => ''),
            2 => array('id' => 2, 'title' => 'Second', 'parent_id' => ''),
            3 => array('id' => 3, 'title' => 'First', 'parent_id' => 1),
        );
    }

    public function testCheckboxTree() {



        $form = new \Nette\Forms\Form;
        $input = $form->addCheckboxTree("list", "Label", $this->items);

        Assert::type(Html::class, $input->getLabel());
        Assert::same('<label for="frm-list">Label</label>', (string) $input->getLabel());
        Assert::same('<label for="frm-list">Another label</label>', (string) $input->getLabel('Another label'));

        Assert::type(Html::class, $input->getLabelPart(0));
        Assert::same('<label for="frm-list">Label</label>', (string) $input->getLabelPart(0));

        Assert::type(Html::class, $input->getControl());
        Assert::same('<ul class="chbt_label"><li><input type="checkbox" name="list[]" id="frm-list-1" value="1"><label for="frm-list-1">First - parent</label><ul class="chbt_label"><li><input type="checkbox" name="list[]" id="frm-list-3" value="3"><label for="frm-list-3">First</label></li></ul></li><li><input type="checkbox" name="list[]" id="frm-list-2" value="2"><label for="frm-list-2">Second</label></li></ul>', (string) $input->getControl());

        Assert::type(Html::class, $input->getControlPart(0));
        Assert::same('<input type="checkbox" name="list[]" id="frm-list-2" value="2">', (string) $input->getControlPart(0));
    }

    public function testChecked() {

        $form = new \Nette\Forms\Form;
        $input = $form->addCheckboxTree("list", "Label", $this->items)->setValue(2);

        Assert::same('<ul class="chbt_label"><li><input type="checkbox" name="list[]" id="frm-list-1" value="1"><label for="frm-list-1">First - parent</label><ul class="chbt_label"><li><input type="checkbox" name="list[]" id="frm-list-3" value="3"><label for="frm-list-3">First</label></li></ul></li><li><input type="checkbox" name="list[]" id="frm-list-2" checked value="2"><label for="frm-list-2">Second</label></li></ul>', (string) $input->getControl());
    }

    public function testValidationRules() {
        $form = new \Nette\Forms\Form;
        $input = $form->addCheckboxTree("list", "Label", $this->items)->setRequired('required');
        Assert::same('<ul class="chbt_label"><li><input type="checkbox" name="list[]" id="frm-list-1" data-nette-rules=\'[{"op":":filled","msg":"required"}]\' value="1"><label for="frm-list-1">First - parent</label><ul class="chbt_label"><li><input type="checkbox" name="list[]" id="frm-list-3" data-nette-rules=\'[{"op":":filled","msg":"required"}]\' value="3"><label for="frm-list-3">First</label></li></ul></li><li><input type="checkbox" name="list[]" id="frm-list-2" data-nette-rules=\'[{"op":":filled","msg":"required"}]\' value="2"><label for="frm-list-2">Second</label></li></ul>', (string) $input->getControl());
    }

    public function testContainer() {
        $form = new \Nette\Forms\Form;
        $input = $form->addCheckboxTree("list", "Label", $this->items);

        Assert::same('<ul class="chbt_label"><li><input type="checkbox" name="list[]" id="frm-list-1" value="1"><label for="frm-list-1">First - parent</label><ul class="chbt_label"><li><input type="checkbox" name="list[]" id="frm-list-3" value="3"><label for="frm-list-3">First</label></li></ul></li><li><input type="checkbox" name="list[]" id="frm-list-2" value="2"><label for="frm-list-2">Second</label></li></ul>', (string) $input->getControl());
    }

    public function testDisabledOne() {

        $form = new \Nette\Forms\Form;
        $input = $form->addCheckboxTree("list", "Label", $this->items)->setDisabled(['1']);

        Assert::same('<ul class="chbt_label"><li><input type="checkbox" name="list[]" id="frm-list-1" disabled value="1"><label for="frm-list-1">First - parent</label><ul class="chbt_label"><li><input type="checkbox" name="list[]" id="frm-list-3" value="3"><label for="frm-list-3">First</label></li></ul></li><li><input type="checkbox" name="list[]" id="frm-list-2" value="2"><label for="frm-list-2">Second</label></li></ul>', (string) $input->getControl());
        Assert::same('<input type="checkbox" name="list[]" id="frm-list-2" value="2">', (string) $input->getControlPart('a'));
    }

    public function testDisabledAll() {
        $form = new \Nette\Forms\Form;
        $input = $form->addCheckboxTree("list", "Label", $this->items)->setDisabled(true);

        Assert::same('<ul class="chbt_label"><li><input type="checkbox" name="list[]" id="frm-list-1" disabled value="1"><label for="frm-list-1">First - parent</label><ul class="chbt_label"><li><input type="checkbox" name="list[]" id="frm-list-3" disabled value="3"><label for="frm-list-3">First</label></li></ul></li><li><input type="checkbox" name="list[]" id="frm-list-2" disabled value="2"><label for="frm-list-2">Second</label></li></ul>', (string) $input->getControl());
    }

}

(new CheckboxTreeRenderTest)->run();


