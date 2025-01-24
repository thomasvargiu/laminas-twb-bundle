<?php

namespace TwbBundleTest\Form\View\Helper;

use TwbBundleTest\TestCase;

class TwbBundleFormRadioTest extends TestCase {

    /**
     * @var \TwbBundle\Form\View\Helper\TwbBundleFormRadio
     */
    protected $formRadioHelper;

    /**
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    public function setUp(): void {
        $oViewHelperPluginManager = \TwbBundleTest\Bootstrap::getServiceManager()->get('ViewHelperManager');
        $oRenderer = new \Laminas\View\Renderer\PhpRenderer();
        $this->formRadioHelper = $oViewHelperPluginManager->get('formRadio')->setView($oRenderer->setHelperPluginManager($oViewHelperPluginManager));
    }

    public function testRenderOptionsWithPrependingLabel() {
        $oReflectionClass = new \ReflectionClass('\TwbBundle\Form\View\Helper\TwbBundleFormRadio');
        $oReflectionMethod = $oReflectionClass->getMethod('renderOptions');
        $oReflectionMethod->setAccessible(true);

        $this->formRadioHelper->setLabelPosition(\TwbBundle\Form\View\Helper\TwbBundleFormRadio::LABEL_PREPEND);
        $this->twbAssertStringEquals(
                '<label>test<input value="0" checked="checked"></label>', $oReflectionMethod->invoke($this->formRadioHelper, new \Laminas\Form\Element\Radio(), array(0 => 'test'), array(0), array())
        );
    }

    public function testRenderOptionsWithDefineAttributesId() {
        $oReflectionClass = new \ReflectionClass('\TwbBundle\Form\View\Helper\TwbBundleFormRadio');
        $oReflectionMethod = $oReflectionClass->getMethod('renderOptions');
        $oReflectionMethod->setAccessible(true);

        $this->formRadioHelper->setLabelPosition(\TwbBundle\Form\View\Helper\TwbBundleFormRadio::LABEL_PREPEND);
        $this->twbAssertStringEquals(
                '<label>test1<input id="test_id" value="0" checked="checked"></label></div><div class="radio"><label>test2<input value="1"></label>', $oReflectionMethod->invoke($this->formRadioHelper, new \Laminas\Form\Element\Radio(), array(0 => 'test1', 1 => 'test2'), array(0), array('id' => 'test_id'))
        );
    }

    public function testRenderOptionsWithOptionsSpecs() {
        $oReflectionClass = new \ReflectionClass('\TwbBundle\Form\View\Helper\TwbBundleFormRadio');
        $oReflectionMethod = $oReflectionClass->getMethod('renderOptions');
        $oReflectionMethod->setAccessible(true);

        $this->formRadioHelper->setLabelPosition(\TwbBundle\Form\View\Helper\TwbBundleFormRadio::LABEL_PREPEND);
        $this->twbAssertStringEquals(
                '<label>test1<input id="test_id" type="radio" value="0" checked></label></div><div class="radio"><label class="test-label-class">test2<input type="radio" class="test-class" value="" checked="checked" disabled="disabled"></label>', $oReflectionMethod->invoke($this->formRadioHelper, new \Laminas\Form\Element\Radio(), array(0 => 'test1', 1 => array('label' => 'test2', 'selected' => true, 'disabled' => true, 'label_attributes' => array('class' => 'test-label-class'), 'attributes' => array('class' => 'test-class'))), array(0), array('id' => 'test_id', 'type' => 'radio'))
        );
    }

}
