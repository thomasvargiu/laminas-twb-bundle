<?php

namespace TwbBundle\Form\View\Helper;

use Laminas\Form\Element\Collection as CollectionElement;
use Laminas\Form\View\Helper\FormCollection;
use Laminas\Form\ElementInterface;

class TwbBundleFormCollection extends FormCollection
{
    /**
     * @var string
     */
    protected static $legendFormat = '<legend%s>%s</legend>';

    /**
     * @var string
     */
    protected static $fieldsetFormat = '<fieldset%s>%s</fieldset>';

    /**
     * Attributes valid for the tag represented by this helper
     * @var array
     */
    protected $validTagAttributes = array(
        'disabled' => true
    );

    /**
     * Render a collection by iterating through all fieldsets and elements
     * @param \Laminas\Form\ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element): string
    {
        $oRenderer = $this->getView();
        if (!method_exists($oRenderer, 'plugin')) {
            return '';
        }

        $bShouldWrap = $this->shouldWrap;

        $markup = '';
        $elementLayout = $element->getOption('twb-layout');

        $elementHelper = $this->getElementHelper();
        $fieldsetHelper = $this->getFieldsetHelper();

        if (!is_callable($elementHelper) || !is_callable($fieldsetHelper)) {
            throw new \RuntimeException('Received non callable helper');
        }

        foreach ($element->getIterator() as $oElementOrFieldset) {
            $options = $oElementOrFieldset->getOptions();
            if ($elementLayout && empty($options['twb-layout'])) {
                $options['twb-layout'] = $elementLayout;
                $oElementOrFieldset->setOptions($options);
            }

            if ($oElementOrFieldset instanceof \Laminas\Form\FieldsetInterface) {
                $markup .= $fieldsetHelper($oElementOrFieldset);
            } elseif ($oElementOrFieldset instanceof \Laminas\Form\ElementInterface) {
                if ($oElementOrFieldset->getOption('twb-row-open')) {
                    $markup .= '<div class="row">' . "\n";
                }

                $markup .= $elementHelper($oElementOrFieldset);

                if ($oElementOrFieldset->getOption('twb-row-close')) {
                    $markup .= '</div>' . "\n";
                }
            }
        }
        if ($element instanceof \Laminas\Form\Element\Collection && $element->shouldCreateTemplate()) {
            $markup .= $this->renderTemplate($element);
        }

        if ($bShouldWrap) {
            if (false != ($sLabel = $element->getLabel())) {
                if (null !== ($oTranslator = $this->getTranslator())) {
                    $sLabel = $oTranslator->translate($sLabel, $this->getTranslatorTextDomain());
                }

                $markup = sprintf(
                        static::$legendFormat, ($sAttributes = $this->createAttributesString($element->getLabelAttributes()? : array())) ? ' ' . $sAttributes : '', $this->getEscapeHtmlHelper()->__invoke($sLabel)
                ) . $markup;
            }

            //Set form layout class
            if ($elementLayout) {
                $sLayoutClass = 'form-' . $elementLayout;
                if (false != ($sElementClass = $element->getAttribute('class'))) {
                    if (!preg_match('/(\s|^)' . preg_quote($sLayoutClass, '/') . '(\s|$)/', $sElementClass)) {
                        $element->setAttribute('class', trim($sElementClass . ' ' . $sLayoutClass));
                    }
                } else {
                    $element->setAttribute('class', $sLayoutClass);
                }
            }

            $markup = sprintf(
                    static::$fieldsetFormat, ($sAttributes = $this->createAttributesString($element->getAttributes())) ? ' ' . $sAttributes : '', $markup
            );
        }
        return $markup;
    }

    /**
     * Only render a template
     *
     * @param CollectionElement $collection
     * @return string
     */
    public function renderTemplate(CollectionElement $collection): string
    {
        if (false != ($sElementLayout = $collection->getOption('twb-layout'))) {
            $elementOrFieldset = $collection->getTemplateElement();
            $elementOrFieldset->setOption('twb-layout', $sElementLayout);
        }

        return parent::renderTemplate($collection);
    }
}
