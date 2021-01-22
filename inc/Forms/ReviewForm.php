<?php

/**
 * @package n9-reviews
 */

namespace Inc\Forms;

use Symfony\Component\Form\Forms;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Validator\Validation;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Translator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\RuntimeLoader\FactoryRuntimeLoader;
use \Inc\Interfaces\Registerable;

class ReviewForm
{
    public function __construct() {
        $this->register_form_factory();
    }

    public function register_form_factory()
    {
        $vendorDirectory = realpath(__DIR__ . '/../vendor');
        $vendorFormDirectory = $vendorDirectory . '/symfony/form';
        $vendorValidatorDirectory = $vendorDirectory . '/symfony/validator';

        // creates the validator - details will vary
        $validator = Validation::createValidator();

        return $formFactory = Forms::createFormFactoryBuilder()
            ->addExtension(new HttpFoundationExtension())
            ->addExtension(new ValidatorExtension($validator))
            ->getFormFactory();
    }

    public function register_twig()
    {
        // the Twig file that holds all the default markup for rendering forms
        // this file comes with TwigBridge
        $defaultFormTheme = 'form_div_layout.html.twig';

        $vendorDirectory = realpath(__DIR__ . '/../vendor');
        // the path to TwigBridge library so Twig can locate the
        // form_div_layout.html.twig file
        $appVariableReflection = new \ReflectionClass('\Symfony\Bridge\Twig\AppVariable');
        $vendorTwigBridgeDirectory = dirname($appVariableReflection->getFileName());
        // the path to your other templates
        $viewsDirectory = realpath(__DIR__ . '/../Views');

        $twig = new Environment(new FilesystemLoader([
            $viewsDirectory,
            $vendorTwigBridgeDirectory . '/Resources/views/Form',
        ]));
        $formEngine = new TwigRendererEngine([$defaultFormTheme], $twig);
        $twig->addRuntimeLoader(new FactoryRuntimeLoader([
            FormRenderer::class => function () use ($formEngine, $csrfManager) {
                return new FormRenderer($formEngine, $csrfManager);
            },
        ]));

        // ... (see the previous CSRF Protection section for more information)

        // adds the FormExtension to Twig
        $twig->addExtension(new FormExtension());

        // creates the Translator
        $translator = new Translator('en');
        // somehow load some translations into it
        $translator->addLoader('xlf', new XliffFileLoader());
        // $translator->addResource(
        //     'xlf',
        //     __DIR__ . '/path/to/translations/messages.en.xlf',
        //     'en'
        // );

        // adds the TranslationExtension (it gives us trans filter)
        $twig->addExtension(new TranslationExtension($translator));

        return $twig;
    }

    public function create_form()
    {
        $form = $this->register_form_factory()->createBuilder(FormType::class, $defaults)
            ->add('rating-stars', NumberType::class, [
                'attr'  => [
                    'class' => 'textfield',
                    'min'   => 1,
                    'max'   => 5,
                ],
                'label' => 'Rating',
                'html5'  => true
            ])
            ->add('comment', TextareaType::class, [
                'attr' => [
                    'class' => 'tinymce',
                    'row'  => 10
                ],
                'label' => 'Comment',
                'required'  => false
            ])
            ->add('postId', HiddenType::class, [
                'data'  => get_the_ID()
            ])
            ->getForm();

        echo ($this->register_twig()->render('new.html.twig', [
            'form' => $form->createView(),
        ]));

    }
}
