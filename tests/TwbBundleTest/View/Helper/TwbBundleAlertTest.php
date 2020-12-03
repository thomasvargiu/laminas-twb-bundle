<?php
namespace TwbBundleTest\View\Helper;
class TwbBundleAlertTest extends \PHPUnit\Framework\TestCase{
    /**
     * @var \TwbBundle\View\Helper\TwbBundleAlert
     */
    protected $alertHelper;

    /**
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    public function setUp(): void{
        $oViewHelperPluginManager = \TwbBundleTest\Bootstrap::getServiceManager()->get('ViewHelperManager');
        $oRenderer = new \Laminas\View\Renderer\PhpRenderer();
        $this->alertHelper = $oViewHelperPluginManager->get('alert')->setView($oRenderer->setHelperPluginManager($oViewHelperPluginManager));
    }

    public function testRenderWithWrongTypeAttributes()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->alertHelper->render('test',new \stdClass());
    }

    public function testRenderWithEmptyClassAttributes()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->alertHelper->render('test',array('class' => ''));
    }

    public function testRenderWithWrongTypeClassAttributes()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->alertHelper->render('test',array('class' => new \stdClass()));
    }
}