<?php

namespace TwbBundleTest;

use PHPUnit\Framework\Constraint\IsEqual;

/**
 * Test forms rendering
 * Based on http://getbootstrap.com/css/#forms
 */
class TwbBundleFormsTest extends TestCase
{

    /**
     * @var string
     */
    protected $expectedPath;

    /**
     * @var string[]
     */
    protected array $expectedPaths;

    /**
     * @var \TwbBundle\Form\View\Helper\TwbBundleForm
     */
    protected $formHelper;

    /**
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    public function setUp(): void
    {
        $this->expectedPath = __DIR__ . DIRECTORY_SEPARATOR . '../../_files/expected-forms' . DIRECTORY_SEPARATOR;
        $oViewHelperPluginManager = \TwbBundleTest\Bootstrap::getServiceManager()->get('ViewHelperManager');
        $oRenderer = new \Laminas\View\Renderer\PhpRenderer();
        $this->formHelper = $oViewHelperPluginManager->get('form')->setView($oRenderer->setHelperPluginManager($oViewHelperPluginManager));
    }

    /**
     * Test http://getbootstrap.com/css/#forms-example
     */
    public function testBasicExample()
    {
        $oForm = new \Laminas\Form\Form();
        $oForm->add(array(
            'name' => 'input-email',
            'attributes' => array(
                'type' => 'email',
                'placeholder' => 'Enter email',
                'id' => 'exampleInputEmail1'
            ),
            'options' => array('label' => 'Email address')
        ))->add(array(
            'name' => 'input-password',
            'attributes' => array(
                'type' => 'password',
                'placeholder' => 'Password',
                'id' => 'exampleInputPassword1'
            ),
            'options' => array('label' => 'Password',)
        ))->add(array(
            'name' => 'input-file',
            'attributes' => array(
                'type' => 'file',
                'id' => 'exampleInputFile'
            ),
            'options' => array(
                'label' => 'File input',
                'help-block' => 'Example block-level help text here.'
            )
        ))->add(array(
            'name' => 'input-checkbox',
            'type' => 'checkbox',
            'options' => array('label' => 'Check me out')
        ))->add(array(
            'name' => 'button-submit',
            'type' => 'button',
            'attributes' => array('type' => 'submit'),
            'options' => array('label' => 'Submit')
        ));

        //Test content
        $this->twbAssertStringEqualsFile($this->expectedPath . 'basic-example.phtml', $this->formHelper->__invoke($oForm, null));
    }

    /**
     * Test http://getbootstrap.com/css/#forms-inline
     */
    public function testInlineForm()
    {
        $oForm = new \Laminas\Form\Form();
        $oForm->add(array(
            'name' => 'input-email',
            'attributes' => array(
                'type' => 'email',
                'placeholder' => 'Enter email',
                'id' => 'exampleInputEmail2'
            ),
            'options' => array('label' => 'Email address', 'showLabel' => false)
        ))->add(array(
            'name' => 'input-email2',
            'attributes' => array(
                'type' => 'email2',
                'placeholder' => 'Enter email2',
                'id' => 'exampleInputEmail2a'
            ),
            'options' => array('label' => 'Email address2', 'showLabel' => true)
        ))->add(array(
            'name' => 'input-password',
            'attributes' => array(
                'type' => 'password',
                'placeholder' => 'Password',
                'id' => 'exampleInputPassword2'
            ),
            'options' => array('label' => 'Password')
        ))->add(array(
            'name' => 'input-checkbox',
            'type' => 'checkbox',
            'options' => array('label' => 'Remember me')
        ))->add(array(
            'name' => 'button-submit',
            'type' => 'button',
            'attributes' => array('type' => 'submit'),
            'options' => array('label' => 'Sign in')
        ));

        //Test content
        $this->twbAssertStringEqualsFile($this->expectedPath . 'inline-form.phtml', $this->formHelper->__invoke($oForm, \TwbBundle\Form\View\Helper\TwbBundleForm::LAYOUT_INLINE));
    }

    /**
     * Test http://getbootstrap.com/css/#forms-horizontal
     */
    public function testHorizontalform()
    {
        $oForm = new \Laminas\Form\Form();
        $oForm->add(array(
            'name' => 'input-email',
            'attributes' => array(
                'type' => 'email',
                'placeholder' => 'Enter email',
                'id' => 'inputEmail1'
            ),
            'options' => array(
                'label' => 'Email',
                'column-size' => 'sm-10',
                'label_attributes' => array('class' => 'col-sm-2')
            )
        ))->add(array(
            'name' => 'input-password',
            'attributes' => array(
                'type' => 'password',
                'placeholder' => 'Password',
                'id' => 'inputPassword1'
            ),
            'options' => array('label' => 'Password', 'column-size' => 'sm-10', 'label_attributes' => array('class' => 'col-sm-2'))
        ))->add(array(
            'name' => 'input-checkbox',
            'type' => 'checkbox',
            'options' => array('label' => 'Remember me', 'column-size' => 'sm-10 col-sm-offset-2')
        ))->add(array(
            'name' => 'button-submit',
            'type' => 'button',
            'attributes' => array('type' => 'submit'),
            'options' => array('label' => 'Sign in', 'column-size' => 'sm-10 col-sm-offset-2')
        ));

        //Test content
        $this->twbAssertStringEqualsFile($this->expectedPath . 'horizontal-form.phtml', $this->formHelper->__invoke($oForm));
    }

    /**
     * Test http://getbootstrap.com/css/#forms-horizontal
     */
    public function testHorizontalformButtonGroup()
    {
        $oForm = new \Laminas\Form\Form();
        $oForm->add(array(
            'name' => 'input-email',
            'attributes' => array(
                'type' => 'email',
                'placeholder' => 'Enter email',
                'id' => 'inputEmail1'
            ),
            'options' => array(
                'label' => 'Email',
                'column-size' => 'sm-10',
                'label_attributes' => array('class' => 'col-sm-2')
            )
        ))->add(array(
            'name' => 'input-password',
            'attributes' => array(
                'type' => 'password',
                'placeholder' => 'Password',
                'id' => 'inputPassword1'
            ),
            'options' => array('label' => 'Password', 'column-size' => 'sm-10', 'label_attributes' => array('class' => 'col-sm-2'))
        ))->add(array(
            'name' => 'input-checkbox',
            'type' => 'checkbox',
            'options' => array('label' => 'Remember me', 'column-size' => 'sm-10 col-sm-offset-2')
        ))->add(array(
            'name' => 'button-submit',
            'type' => 'button',
            'attributes' => array('type' => 'submit'),
            'options' => array('label' => 'Sign in', 'column-size' => 'sm-10 col-sm-offset-2', 'button-group' => 'group-1')
        ))->add(array(
            'name' => 'button-reset',
            'type' => 'button',
            'attributes' => array('type' => 'reset'),
            'options' => array('label' => 'Reset form', 'column-size' => 'sm-8 col-sm-offset-4', 'button-group' => 'group-1')
        ));

        //Test content
        $this->twbAssertStringEqualsFile($this->expectedPath . 'horizontal-form-button-group.phtml', $this->formHelper->__invoke($oForm));
    }

    /**
     * Test http://getbootstrap.com/css/#forms-controls
     */
    public function testSupportedControlsform()
    {
        $oForm = new \Laminas\Form\Form();
        $oForm->add(array(
            'name' => 'input-text',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Text input',
            )
        ))->add(array(
            'name' => 'input-text-area',
            'type' => 'textarea',
            'attributes' => array(
                'row' => 3
            )
        ))->add(array(
            'name' => 'input-checkbox',
            'type' => 'checkbox',
            'options' => array('label' => 'Option one is this and that-be sure to include why it\'s great')
        ))->add(array(
            'name' => 'optionsRadios',
            'type' => 'radio',
            'options' => array(
                'value_options' => array(
                    'option1' => 'Option one is this and that-be sure to include why it\'s great',
                    'optionsRadios2' => 'Option two can be something else and selecting it will deselect option one'
                )
            )
        ))->add(array(
            'name' => 'optionsRadiosNoInline',
            'type' => 'MultiCheckbox',
            'options' => array(
                'value_options' => array(
                    array('label' => '1', 'value' => 'option1', 'attributes' => array('id' => 'noInlineCheckbox1')),
                    array('label' => '2', 'value' => 'option2', 'attributes' => array('id' => 'noInlineCheckbox2')),
                    array('label' => '3', 'value' => 'option3', 'attributes' => array('id' => 'noInlineCheckbox3'))
                )
            )
        ))->add(array(
            'name' => 'optionsRadios',
            'type' => 'MultiCheckbox',
            'options' => array(
                'value_options' => array(
                    array('label' => '1', 'value' => 'option1', 'attributes' => array('id' => 'inlineCheckbox1')),
                    array('label' => '2', 'value' => 'option2', 'attributes' => array('id' => 'inlineCheckbox2')),
                    array('label' => '3', 'value' => 'option3', 'attributes' => array('id' => 'inlineCheckbox3'))
                ),
                'inline' => true
            )
        ))->add(array(
            'name' => 'select',
            'type' => 'select',
            'options' => array('value_options' => array(1, 2, 3, 4, 5))
        ))->add(array(
            'name' => 'multiple-select',
            'type' => 'select',
            'options' => array('value_options' => array(1, 2, 3, 4, 5)),
            'attributes' => array('multiple' => true)
        ));

        //Test content
        $this->twbAssertStringEqualsFile($this->expectedPath . 'supported-controls-form.phtml', $this->formHelper->__invoke($oForm, null));
    }

    public function testRenderMultiCheckboxInlineWithLabel()
    {
        $oForm = new \Laminas\Form\Form();
        $oForm->add(array(
            'name' => 'optionsRadios',
            'type' => 'MultiCheckbox',
            'options' => array(
                'label' => 'Test label',
                'column-size' => 'sm-10',
                'label_attributes' => array('class' => 'col-sm-2'),
                'value_options' => array(
                    array('label' => '1', 'value' => 'option1', 'attributes' => array('id' => 'inlineCheckbox1')),
                    array('label' => '2', 'value' => 'option2', 'attributes' => array('id' => 'inlineCheckbox2')),
                    array('label' => '3', 'value' => 'option3', 'attributes' => array('id' => 'inlineCheckbox3'))
                ),
                'inline' => true
            )
        ));
        //Test content
        $this->twbAssertStringEqualsFile($this->expectedPath . 'multi-checkbox-inline.phtml', $this->formHelper->__invoke($oForm));
    }

    /**
     * Test http://getbootstrap.com/css/#forms-controls-static
     */
    public function testStaticControlform()
    {
        $oForm = new \Laminas\Form\Form();
        $oForm->add(array(
            'name' => 'static-element',
            'type' => '\TwbBundle\Form\Element\StaticElement',
            'attributes' => array('value' => 'email@example.com'),
            'options' => array('label' => 'Email', 'column-size' => 'lg-10', 'label_attributes' => array('class' => 'col-lg-2'))
        ))->add(array(
            'name' => 'input-password',
            'attributes' => array(
                'type' => 'password',
                'placeholder' => 'Password',
                'id' => 'inputPassword'
            ),
            'options' => array('label' => 'Password', 'column-size' => 'lg-10', 'label_attributes' => array('class' => 'col-lg-2'))
        ));

        //Test content
        $this->twbAssertStringEqualsFile($this->expectedPath . 'static-control-form.phtml', $this->formHelper->__invoke($oForm));
    }

    /**
     * Test http://getbootstrap.com/css/#forms-control-states
     */
    public function testControlStatesform()
    {
        $oForm = new \Laminas\Form\Form();
        $oForm->add(array(
            'name' => 'input-text-disabled',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Disabled input here...',
                'id' => 'disabledInput'
            )
        ));

        $oFieldset = new \Laminas\Form\Fieldset('fieldset-disabled');
        $oForm->add($oFieldset->setAttributes(array('disabled' => true))->add(array(
                    'name' => 'input-text-disabled',
                    'attributes' => array(
                        'type' => 'text',
                        'placeholder' => 'Disabled input',
                        'id' => 'disabledTextInput'
                    ),
                    'options' => array('label' => 'Disabled input')
                ))->add(array(
                    'name' => 'disabled-select',
                    'type' => 'select',
                    'options' => array(
                        'label' => 'Disabled select menu',
                        'value_options' => array('' => 'Disabled select')
                    ),
                    'attributes' => array('id' => 'disabled-select')
                ))->add(array(
                    'name' => 'input-checkbox',
                    'type' => 'checkbox',
                    'options' => array('label' => 'Can\'t check this')
                ))->add(array(
                    'name' => 'button-submit',
                    'type' => 'button',
                    'attributes' => array('type' => 'submit', 'class' => 'btn-primary'),
                    'options' => array('label' => 'Submit')
        )));

        //Test content
        $this->twbAssertStringEqualsFile($this->expectedPath . 'control-states-form.phtml', $this->formHelper->__invoke($oForm, null));

        //Test content
        $this->twbAssertStringEqualsFile($this->expectedPath . 'control-states-form-horizontal.phtml', $this->formHelper->__invoke($oForm));
    }

    /**
     * Test http://getbootstrap.com/css/#forms-validation
     */
    public function testFormsValidation()
    {
        $oForm = new \Laminas\Form\Form();
        $oForm->add(array(
            'name' => 'input-text-success',
            'attributes' => array(
                'type' => 'text',
                'id' => 'inputSuccess'
            ),
            'options' => array(
                'label' => 'Input with success',
                'validation-state' => 'success'
            )
        ))->add(array(
            'name' => 'input-text-warning',
            'attributes' => array(
                'type' => 'text',
                'id' => 'inputWarning'
            ),
            'options' => array(
                'label' => 'Input with warning',
                'validation-state' => 'warning'
            )
        ))->add(array(
            'name' => 'input-text-error',
            'attributes' => array(
                'type' => 'text',
                'id' => 'inputError'
            ),
            'options' => array(
                'label' => 'Input with error',
                'validation-state' => 'error'
            )
        ));

        //Test content
        $this->twbAssertStringEqualsFile($this->expectedPath . 'forms-validation.phtml', $this->formHelper->__invoke($oForm, null));
    }

    /**
     * Test http://getbootstrap.com/css/#forms-control-sizes
     */
    public function testFormsControlSizes()
    {

        //Height sizing
        $oForm = new \Laminas\Form\Form();
        $oForm->add(array(
            'name' => 'input-text-lg',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '.input-lg',
                'class' => 'input-lg'
            )
        ))->add(array(
            'name' => 'input-text-default',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Default input'
            )
        ))->add(array(
            'name' => 'input-text-sm',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '.input-sm',
                'class' => 'input-sm'
            )
        ))->add(array(
            'name' => 'lg-select',
            'type' => 'select',
            'options' => array('value_options' => array('' => '.input-lg')),
            'attributes' => array('class' => 'input-lg')
        ))->add(array(
            'name' => 'default-select',
            'type' => 'select',
            'options' => array('value_options' => array('' => 'Default select'))
        ))->add(array(
            'name' => 'sm-select',
            'type' => 'select',
            'options' => array('value_options' => array('' => '.input-sm')),
            'attributes' => array('class' => 'input-sm')
        ));

        //Test content
        $this->twbAssertStringEqualsFile($this->expectedPath . 'forms-control-sizes-height.phtml', $this->formHelper->__invoke($oForm, null));

        //Column sizing
        $oForm = new \Laminas\Form\Form();
        $oForm->add(array(
            'name' => 'input-text-col-lg-2',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '.col-lg-2'
            ),
            'options' => array('column-size' => 'lg-2')
        ))->add(array(
            'name' => 'input-text-col-lg-3',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '.col-lg-3'
            ),
            'options' => array('column-size' => 'lg-3')
        ))->add(array(
            'name' => 'input-text-col-lg-4',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => '.col-lg-4'
            ),
            'options' => array('column-size' => 'lg-4')
        ));

        //Test content
        $this->twbAssertStringEqualsFile($this->expectedPath . 'forms-control-sizes-column.phtml', $this->formHelper->__invoke($oForm, \TwbBundle\Form\View\Helper\TwbBundleForm::LAYOUT_INLINE));
    }

    /**
     * Test http://getbootstrap.com/css/#forms-help-text
     */
    public function testFormsHelpText()
    {
        $oForm = new \Laminas\Form\Form();
        $oForm->add(array(
            'name' => 'input-text',
            'attributes' => array('type' => 'text'),
            'options' => array(
                'help-block' => 'A block of help text that breaks onto a new line and may extend beyond one line.'
            )
        ));

        //Test content
        $this->twbAssertStringEqualsFile($this->expectedPath . 'forms-help-text.phtml', $this->formHelper->__invoke($oForm, null));
    }

    /**
     * Test errored input rendering
     */
    public function testFormsErroredInput()
    {
        $oForm = new \Laminas\Form\Form();
        $oElement = new \Laminas\Form\Element\Text('input-text');
        $oForm->add($oElement
                        ->setMessages(array(
                            'This is an error message',
                            'This is an another one error message'
        )));

        //No form layout
        $this->twbAssertStringEqualsFile($this->expectedPath . 'forms-no-layout-errored-input.phtml', $this->formHelper->__invoke($oForm, null));

        //Horizontal form
        $this->twbAssertStringEqualsFile($this->expectedPath . 'forms-horizontal-errored-input.phtml', $this->formHelper->__invoke($oForm));

        //Horizontal form / input with label
        $oElement
                ->setOptions(array('column-size' => 'lg-10'))
                ->setLabel('Input label')
                ->setLabelAttributes(array('class' => 'col-lg-2'));
        $this->twbAssertStringEqualsFile($this->expectedPath . 'forms-horizontal-errored-input-with-label.phtml', $this->formHelper->__invoke($oForm));
    }

    public function testFormWithButtonGroups()
    {
        $oForm = new \Laminas\Form\Form();
        $oForm
                ->add(new \Laminas\Form\Element\Text('input-text-1'))
                ->add(new \Laminas\Form\Element\Button('input-button-1', array('label' => 'Left', 'button-group' => 'group-1')))
                ->add(new \Laminas\Form\Element\Button('input-button-2', array('label' => 'Right', 'button-group' => 'group-1')))
                ->add(new \Laminas\Form\Element\Button('input-button-3', array('label' => 'Left', 'button-group' => 'group-2')))
                ->add(new \Laminas\Form\Element\Button('input-button-4', array('label' => 'Right', 'button-group' => 'group-2')))
                ->add(new \Laminas\Form\Element\Text('input-text-3'));

        // Test content
        $this->twbAssertStringEqualsFile($this->expectedPath . 'forms-button-groups.phtml', $this->formHelper->__invoke($oForm));
    }
}
