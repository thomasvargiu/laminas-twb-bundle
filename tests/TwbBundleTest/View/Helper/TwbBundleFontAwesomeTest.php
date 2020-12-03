<?php
namespace TwbBundleTest\View\Helper;

use TwbBundle\View\Helper\TwbBundleFontAwesome;
use TwbBundleTest\Bootstrap;
use Laminas\View\Renderer\PhpRenderer;

class TwbBundleFontAwesomeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var TwbBundleFontAwesome
     */
    protected $fontAwesomeHelper;

    /**
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    public function setUp(): void {
        $oViewHelperPluginManager = Bootstrap::getServiceManager()
            ->get('ViewHelperManager');
        $oRenderer = new PhpRenderer();
        $this->fontAwesomeHelper = $oViewHelperPluginManager->get('fontAwesome')
            ->setView(
                $oRenderer->setHelperPluginManager($oViewHelperPluginManager)
            );
    }

    public function testInvoke() {
        $this->assertSame(
            $this->fontAwesomeHelper, $this->fontAwesomeHelper->__invoke()
        );
    }

    public function testRenderWithWrongTypeFontAwesome()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->fontAwesomeHelper->render(new \stdClass());
    }

    public function testRenderWithEmptyClassAttributes() {
        $this->assertEquals(
            '<span class="fa&#x20;fa-test"></span>',
            $this->fontAwesomeHelper->render('test', array('class' => ''))
        );
    }

    public function testRenderWithDefinedClassAttributes() {
        $this->assertEquals(
            '<span class="test&#x20;fa&#x20;fa-test"></span>',
            $this->fontAwesomeHelper->render('test', array('class' => 'test'))
        );
    }
}