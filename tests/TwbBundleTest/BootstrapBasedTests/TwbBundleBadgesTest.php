<?php
namespace TwbBundleTest;
/**
 * Test badges rendering
 * Based on http://getbootstrap.com/components/#badges
 */
class TwbBundleBadgesTest extends \PHPUnit\Framework\TestCase{
    /**
     * @var string
     */
    protected $expectedPath;

    /**
     * @var \TwbBundle\Form\View\Helper\TwbBundleBadge
     */
    protected $badgeHelper;

    /**
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    public function setUp(): void{
        $this->expectedPath = __DIR__.DIRECTORY_SEPARATOR.'../../_files/expected-badges'.DIRECTORY_SEPARATOR;
        $oViewHelperPluginManager = \TwbBundleTest\Bootstrap::getServiceManager()->get('ViewHelperManager');
        $oRenderer = new \Laminas\View\Renderer\PhpRenderer();
        $this->badgeHelper = $oViewHelperPluginManager->get('badge')->setView($oRenderer->setHelperPluginManager($oViewHelperPluginManager));
    }

    public function testBadges(){
        $sContent = '';

        //Default
        $sContent .= $this->badgeHelper->__invoke('42')."\n";

        //Pull-right
        $sContent .= $this->badgeHelper->__invoke('3',array('class' => 'pull-right'))."\n";

        $this->assertStringEqualsFile($this->expectedPath.'badges.phtml',$sContent);
    }
}