<?php
namespace TwbBundleTest\View\Helper;
class TwbBundleLabelTest extends \PHPUnit\Framework\TestCase{
    /**
     * @var \TwbBundle\View\Helper\TwbBundleLabel
     */
    protected $labelHelper;

    /**
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    public function setUp(): void{
        $oViewHelperPluginManager = \TwbBundleTest\Bootstrap::getServiceManager()->get('ViewHelperManager');
        $oRenderer = new \Laminas\View\Renderer\PhpRenderer();
        $this->labelHelper = $oViewHelperPluginManager->get('label')->setView($oRenderer->setHelperPluginManager($oViewHelperPluginManager));
    }

    public function testRenderWithWrongTypeAttributes()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->labelHelper->render('test',new \stdClass());
    }

    public function testRenderWithEmptyClassAttributes()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->labelHelper->render('test',array('class' => ''));
    }

    public function testRenderWithWrongTypeClassAttributes()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->labelHelper->render('test',array('class' => new \stdClass()));
    }
}