<?php

namespace Acts\CamdramBundle\Form;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

/**
 * Class CamdramFormTypeExtension
 *
 * A custom form extension which modifies the default formatting of forms to match Foundation's styling.
 */
class CamdramFormTypeExtension extends AbstractTypeExtension
{
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return 'form';
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['label_attr']['class'] = 'right inline';

        if (count($view->vars['errors']) > 0) {
            $view->vars['attr']['class'] = 'error';
            $view->vars['label_attr']['class'] .= ' error';
        }
    }
}
