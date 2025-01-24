<?php

namespace TwbBundleTest\Form\View\Helper;

use TwbBundleTest\TestCase;

class TwbBundleFormCheckboxTest extends TestCase {

    /**
     * @var \TwbBundle\Form\View\Helper\TwbBundleFormCheckbox
     */
    protected $formCheckboxHelper;

    /**
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    public function setUp(): void {
        $oViewHelperPluginManager = \TwbBundleTest\Bootstrap::getServiceManager()->get('ViewHelperManager');
        $oRenderer = new \Laminas\View\Renderer\PhpRenderer();
        $this->formCheckboxHelper = $oViewHelperPluginManager->get('formCheckbox')->setView($oRenderer->setHelperPluginManager($oViewHelperPluginManager));
    }

    public function testRenderElementWithWrongElement()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->formCheckboxHelper->render(new \Laminas\Form\Element());
    }

    public function testRenderElementWithEmptyName()
    {
        $this->expectException(\LogicException::class);
        $this->formCheckboxHelper->render(new \Laminas\Form\Element\Checkbox(''));
    }

    public function testRenderWithLabelPrepend() {
        $this->twbAssertStringEquals('<input type="hidden" name="prepend" value="0"><label>Prepend label <input type="checkbox" name="prepend" value="1"></label>', $this->formCheckboxHelper->render(new \Laminas\Form\Element\Checkbox('prepend', array(
                    'label' => 'Prepend label',
                    'label_options' => array('position' => \Laminas\Form\View\Helper\FormRow::LABEL_PREPEND)
        ))));
    }

    public function testRenderWithCheckedElement() {
        $oCheckbox = new \Laminas\Form\Element\Checkbox('checked');
        $oCheckbox->setChecked(true);
        $this->twbAssertStringEquals('<input type="hidden" name="checked" value="0"><input type="checkbox" name="checked" value="1" checked="checked">', $this->formCheckboxHelper->render($oCheckbox));
    }

}
