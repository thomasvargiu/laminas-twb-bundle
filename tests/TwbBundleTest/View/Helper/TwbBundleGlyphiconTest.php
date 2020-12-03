<?php

namespace TwbBundleTest\View\Helper;

class TwbBundleGlyphiconTest extends \PHPUnit\Framework\TestCase {

    /**
     * @var \TwbBundle\View\Helper\TwbBundleGlyphicon
     */
    protected $glyphiconHelper;

    /**
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    public function setUp(): void {
        $oViewHelperPluginManager = \TwbBundleTest\Bootstrap::getServiceManager()->get('ViewHelperManager');
        $oRenderer = new \Laminas\View\Renderer\PhpRenderer();
        $this->glyphiconHelper = $oViewHelperPluginManager->get('glyphicon')->setView($oRenderer->setHelperPluginManager($oViewHelperPluginManager));
    }

    public function testInvoke() {
        $this->assertSame($this->glyphiconHelper, $this->glyphiconHelper->__invoke());
    }

    public function testRenderWithWrongTypeGlyphicon()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->glyphiconHelper->render(new \stdClass());
    }

    public function testRenderWithEmptyClassAttributes() {
        $this->assertEquals('<span class="glyphicon&#x20;glyphicon-test"></span>', $this->glyphiconHelper->render('test', array('class' => '')));
    }

    public function testRenderWithDefinedClassAttributes() {
        $this->assertEquals('<span class="test&#x20;glyphicon&#x20;glyphicon-test"></span>', $this->glyphiconHelper->render('test', array('class' => 'test')));
    }

}
