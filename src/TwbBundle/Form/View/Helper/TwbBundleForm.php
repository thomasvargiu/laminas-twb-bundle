<?php

namespace TwbBundle\Form\View\Helper;

use Laminas\Form\View\Helper\Form;
use Laminas\Form\FormInterface;
use Laminas\Form\FieldsetInterface;

class TwbBundleForm extends Form
{

    /**
     * @var string
     */
    const LAYOUT_HORIZONTAL = 'horizontal';

    /**
     * @var string
     */
    const LAYOUT_INLINE = 'inline';

    /**
     * @var string
     */
    protected static string $formRowFormat = '<div class="row">%s</div>';

    /**
     * Form layout (see LAYOUT_* consts)
     *
     * @var null|string
     */
    protected ?string $formLayout = null;

    /**
     * @param FormInterface $form
     * @return TwbBundleForm|string
     *@see Form::__invoke()
     */
    public function __invoke(FormInterface $form = null, ?string $formLayout = self::LAYOUT_HORIZONTAL)
    {
        if ($form) {
            return $this->render($form, $formLayout);
        }
        $this->formLayout = $formLayout;
        return $this;
    }

    /**
     * Render a form from the provided $oForm,
     * @param FormInterface $form
     * @return string
     * @see Form::render()
     */
    public function render(FormInterface $form, ?string $formLayout = self::LAYOUT_HORIZONTAL): string
    {
        //Prepare form if needed
        if (method_exists($form, 'prepare')) {
            $form->prepare();
        }

        $this->setFormClass($form, $formLayout);

        //Set form role
        if (!$form->getAttribute('role')) {
            $form->setAttribute('role', 'form');
        }

        return $this->openTag($form) . "\n" . $this->renderElements($form, $formLayout) . $this->closeTag();
    }

    /**
     * @param FormInterface $oForm
     * @return string
     */
    protected function renderElements(FormInterface $oForm, ?string $formLayout = self::LAYOUT_HORIZONTAL): string
    {
        // Store button groups
        $aButtonGroups = array();

        // Store button groups column-size from buttons
        $aButtonGroupsColumnSize = array();

        // Store elements rendering
        $aElementsRendering = array();

        // Retrieve view helper plugin manager
        $oHelperPluginManager = $this->getView()->getHelperPluginManager();

        // Retrieve form row helper
        $oFormRowHelper = $oHelperPluginManager->get('formRow');

        // Retrieve form collection helper
        $oFormCollectionHelper = $oHelperPluginManager->get('formCollection');

        // Retrieve button group helper
        $oButtonGroupHelper = $oHelperPluginManager->get('buttonGroup');

        // Store column size option
        $bHasColumnSize = false;

        // Prepare options
        foreach ($oForm as $iKey => $oElement) {
            $aOptions = $oElement->getOptions();
            if (!$bHasColumnSize && !empty($aOptions['column-size'])) {
                $bHasColumnSize = true;
            }
            // Define layout option to form elements if not already defined
            if ($formLayout && empty($aOptions['twb-layout'])) {
                $oElement->setOption('twb-layout', $formLayout);
            }

            // Manage button group option
            if (array_key_exists('button-group', $aOptions)) {
                $sButtonGroupKey = $aOptions['button-group'];
                if (isset($aButtonGroups[$sButtonGroupKey])) {
                    $aButtonGroups[$sButtonGroupKey][] = $oElement;
                } else {
                    $aButtonGroups[$sButtonGroupKey] = array($oElement);
                    $aElementsRendering[$iKey] = $sButtonGroupKey;
                }
                if (!empty($aOptions['column-size']) && !isset($aButtonGroupsColumnSize[$sButtonGroupKey])) {
                    // Only the first occured column-size will be set, other are ignored.
                    $aButtonGroupsColumnSize[$sButtonGroupKey] = $aOptions['column-size'];
                }
            } elseif ($oElement instanceof FieldsetInterface) {
                $aElementsRendering[$iKey] = $oFormCollectionHelper->__invoke($oElement);
            } else {
                $aElementsRendering[$iKey] = $oFormRowHelper->__invoke($oElement);
            }
        }

        // Assemble elements rendering
        $sFormContent = '';
        foreach ($aElementsRendering as $sElementRendering) {
            // Check if element rendering is a button group key
            if (isset($aButtonGroups[$sElementRendering])) {
                $aButtons = $aButtonGroups[$sElementRendering];

                // Render button group content
                $options = (isset($aButtonGroupsColumnSize[$sElementRendering])) ? array('attributes' => array('class' => 'col-' . $aButtonGroupsColumnSize[$sElementRendering])) : null;
                $sFormContent .= $oFormRowHelper->renderElementFormGroup($oButtonGroupHelper($aButtons, $options), $oFormRowHelper->getRowClassFromElement(current($aButtons)));
            } else {
                $sFormContent .= $sElementRendering;
            }
        }

        if ($bHasColumnSize && $formLayout !== self::LAYOUT_HORIZONTAL) {
            $sFormContent = sprintf(static::$formRowFormat, $sFormContent);
        }
        return $sFormContent;
    }

    /**
     * Sets form layout class
     * @param FormInterface $form
     * @return \TwbBundle\Form\View\Helper\TwbBundleForm
     */
    protected function setFormClass(FormInterface $form, ?string $formLayout = self::LAYOUT_HORIZONTAL): self
    {
        if ($formLayout) {
            $layoutClass = 'form-' . $formLayout;
            if ($sFormClass = $form->getAttribute('class')) {
                if (!preg_match('/(\s|^)' . preg_quote($layoutClass, '/') . '(\s|$)/', $sFormClass)) {
                    $form->setAttribute('class', trim($sFormClass . ' ' . $layoutClass));
                }
            } else {
                $form->setAttribute('class', $layoutClass);
            }
        }

        return $this;
    }

    /**
     * Generate an opening form tag
     * @param null|FormInterface $form
     * @return string
     */
    public function openTag(FormInterface $form = null): string
    {
        $this->setFormClass($form, $this->formLayout);
        return parent::openTag($form);
    }
}
