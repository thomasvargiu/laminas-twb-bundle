<?php

namespace TwbBundle\Form\View\Helper;

use Laminas\Form\View\Helper\AbstractHelper;
use Laminas\Form\FormInterface;

class TwbBundleFormErrors extends AbstractHelper
{

    protected $defaultErrorText = 'There were errors in the form submission';
    protected $messageOpenFormat = '<h4>%s</h4><ul><li>';
    protected $messageCloseString = '</li></ul>';
    protected $messageSeparatorString = '</li><li>';

    /**
     * Invoke as function
     * @param \Laminas\Form\FormInterface $form
     * @param string $message
     * @param string $dismissable
     * @return string|self|null
     */
    public function __invoke(FormInterface $form = null, $message = null, $dismissable = false)
    {
        if (!$form) {
            return $this;
        }

        if (!$message) {
            $message = $this->defaultErrorText;
        }

        if ($form->hasValidated() && !$form->isValid()) {

            return $this->render($form, $message, $dismissable);
        }

        return null;
    }

    /**
     * Renders the error messages.
     * @param \Laminas\Form\FormInterface $oForm
     * @return string
     */
    public function render(FormInterface $oForm, $sMessage, $bDismissable = false)
    {
        $errorHtml = sprintf($this->messageOpenFormat, $sMessage);

        $sMessagesArray = array();

        foreach ($oForm->getMessages() as $fieldName => $sMessages) {
            foreach ($sMessages as $sMessage) {
                if ($oForm->get($fieldName)->getAttribute('id')) {
                    $sMessagesArray[] = sprintf(
                        '<a href="#%s">%s</a>',
                        $oForm->get($fieldName)->getAttribute('id'),
                        $oForm->get($fieldName)->getLabel() . ': ' . $sMessage
                    );
                } else {
                    $sMessagesArray[] = $oForm->get($fieldName)->getLabel() . ': ' . $sMessage;
                }
            }
        }

        return $this->dangerAlert(
            $errorHtml .
            implode($this->messageSeparatorString, $sMessagesArray) .
            $this->messageCloseString,
            $bDismissable
        );
    }

    /**
     * Creates and returns a "danger" alert.
     * @param string  $content
     * @param boolean $bDismissable
     * @return string
     */
    public function dangerAlert($content, $bDismissable = false)
    {
        return $this->getView()->alert($content, array('class' => 'alert-danger'), $bDismissable);
    }
}
