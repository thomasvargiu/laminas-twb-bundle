<?php

namespace TwbBundleTest\Form\View\Helper;

class TwbBundleFormButtonTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var \TwbBundle\Form\View\Helper\TwbBundleFormButton
     */
    protected $formButtonHelper;

    /**
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    public function setUp(): void
    {
        $oViewHelperPluginManager = \TwbBundleTest\Bootstrap::getServiceManager()->get('ViewHelperManager');
        $oRenderer = new \Laminas\View\Renderer\PhpRenderer();
        $this->formButtonHelper = $oViewHelperPluginManager->get('formButton')->setView($oRenderer->setHelperPluginManager($oViewHelperPluginManager));
    }

    public function testRenderElementWithEmptyButtonContentandLabel()
    {
        $this->expectException(\DomainException::class);

        $this->formButtonHelper->render(new \Laminas\Form\Element(null, array('dropdown' => array('test'))));
    }

    public function testRenderWithUndefinedButtonClass()
    {
        $oElement = new \Laminas\Form\Element('test', array('label' => 'test'));
        $oElement->setAttribute('class', 'test');
        $this->assertEquals('<button name="test" class="test&#x20;btn&#x20;btn-default" type="submit" value="">test</button>', $this->formButtonHelper->render($oElement));
    }

    public function testRenderWithWrongTypeGlyphiconOption()
    {
        $this->expectException(\LogicException::class);

        $this->formButtonHelper->render(new \Laminas\Form\Element('test', array('glyphicon' => new \stdClass())));
    }

    public function testRenderWithWrongTypeGlyphiconIconOption()
    {
        $this->expectException(\LogicException::class);
        $this->formButtonHelper->render(new \Laminas\Form\Element('test', array('glyphicon' => array('icon' => new \stdClass()))));
    }

    public function testRenderWithEmptyGlyphiconPositionOption()
    {
        $this->assertEquals(
                '<button name="test" class="btn&#x20;btn-default" type="submit" value=""><span class="glyphicon&#x20;glyphicon-test"></span></button>', $this->formButtonHelper->render(new \Laminas\Form\Element('test', array('glyphicon' => array('icon' => 'test'))))
        );
    }

    public function testRenderWithEmptyFontAwesomePositionOption()
    {
        $this->assertEquals(
                '<button name="test" class="btn&#x20;btn-default" type="submit" value=""><span class="fa&#x20;fa-test"></span></button>', $this->formButtonHelper->render(new \Laminas\Form\Element('test', array('fontAwesome' => array('icon' => 'test'))))
        );
    }

    public function testRenderWithWrongTypeGlyphiconPositionOption()
    {
        $this->expectException(\LogicException::class);
        $this->formButtonHelper->render(new \Laminas\Form\Element('test', array('glyphicon' => array('icon' => 'test', 'position' => new \stdClass()))));
    }

    public function testRenderWithWrongGlyphiconPositionOption()
    {
        $this->expectException(\LogicException::class);
        $this->formButtonHelper->render(new \Laminas\Form\Element('test', array('glyphicon' => array('icon' => 'test', 'position' => 'wrong'))));
    }

    public function testRenderWithAppendGlyphiconPositionOption()
    {
        $this->assertEquals(
                '<button name="test" class="btn&#x20;btn-default" type="submit" value="">test <span class="glyphicon&#x20;glyphicon-test"></span></button>', $this->formButtonHelper->render(new \Laminas\Form\Element('test', array(
                    'label' => 'test',
                    'glyphicon' => array('icon' => 'test', 'position' => \TwbBundle\Form\View\Helper\TwbBundleFormButton::ICON_APPEND,)
                )))
        );
    }

    public function testRenderWithWrongTypeDropdownOption()
    {
        $this->expectException(\LogicException::class);
        $this->formButtonHelper->render(new \Laminas\Form\Element('test', array('label' => 'test', 'dropdown' => new \stdClass())));
    }
}
