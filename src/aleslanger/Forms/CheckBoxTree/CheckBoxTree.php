<?php
/**
 * CheckBox Tree Control for NETTE
 * 
 * @author    Ales Langer <ales.langer@yahoo.com>
 * @copyright 2018 Ales Langer
 * @license   MIT License
 * @version   GIT: https://github.com/aleslanger/checkboxtree
 */


declare(strict_types=1);

namespace aleslanger\Forms\CheckBoxTree;

use Nette;
use Nette\Utils\Html;


class CheckBoxTree extends Nette\Forms\Controls\MultiChoiceControl
{

    private $_key;
    protected $cLabel;

    /**
     * CheckBoxTree constructor.
     * 
     * @param null       $label Label
     * @param array|null $items Items
     */
    public function __construct($label = null, array $items = null)
    {
        parent::__construct($label, $items);
        $this->control->type = 'checkbox';
        $this->cLabel = Nette\Utils\Strings::webalize($label);

    }

    /** 
     * Returning array tree structure
     * 
     * @return array
     */
    private function _getTree()
    {
        $items = $this->setArray($this->getItems());
        $tree = $this->_buildTree($items);
        return $tree;
    }

    /**
     * Creates an array tree structure
     * 
     * @param  array    $items    Items
     * @param  int|null $parentId Parent ID
     * @return array
     */
    private function _buildTree(array $items, $parentId = null)
    {

        $branch = array();

        foreach ($items as $key => $item) {
            if ($item['parent_id'] == $parentId) {
                $child = $this->_buildTree($items, $item['id']);
                if ($child) {
                    $item['child'] = $child;
                }
                $branch[$key] = $item;
            }
        }

        return $branch;
    }

    /**
     * Generates control's HTML element
     * 
     * @return Html|string
     */
    public function getControl()
    {
        return $this->_checkBoxTreeRender($this->_getTree());
    }

    /** 
     * Checkbox tree render
     * 
     * @param  array $items Items
     * @return Html
     */
    private function _checkBoxTreeRender(array $items)
    {
        $html = Html::el("ul class=chbt_" . $this->cLabel);

        foreach ($items as $key => $item) {

            $this->_key = $key;

            if (isset($item['child']) AND is_array($item['child'])) {

                $html->addHtml(Html::el('li')
                    ->addHtml($this->getControlPart())
                    ->addHtml(Html::el("label", array("for" => $this->getHtmlId() . '-' . $key))->addText($item['title']))
                    ->addHtml($this->_checkBoxTreeRender($item['child']))
                        );
            } else {

                $html->addHtml(Html::el('li')
                    ->addHtml($this->getControlPart())
                    ->addHtml(Html::el("label", array("for" => $this->getHtmlId() . '-' . $key))->addText($item['title']))
                        );
            }
        }

        return $html;
    }

    /**
     * @return Html|null|string
     */
    public function getControlPart()
    {
        return parent::getControl()->addAttributes(array(
            'id' => $this->getHtmlId() . '-' . $this->_key,
            'required' =>null,
            'checked' => in_array($this->_key, (array)$this->value),
            'disabled' => is_array($this->disabled) ? isset($this->disabled[$this->_key]) : $this->disabled,
            'value' => $this->_key,));
    }

    /**
     * Assemble a field with a keys (id, title, parent_id) only
     * 
     * @param  array $items Items
     * @return array
     */
    public function setArray(array $items)
    {
        $keys = array('id', 'title', 'parent_id');
        $items_new = array();
        if (is_array($items)) {
            foreach ($items as $itemKey => $item) {
                foreach ($keys as $key) {
                    if (isset($item[$key]) OR $item[$key] === null) {
                        $items_new[$itemKey][$key] = $item[$key];
                    } else {
                        throw new Nette\InvalidArgumentException("Missing item '$key'.");
                    }
                }
            }
        }

        return $items_new;
    }

}
