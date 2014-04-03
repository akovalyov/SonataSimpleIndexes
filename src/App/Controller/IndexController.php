<?php
namespace App\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $indexes = $this->getRepository('App:Index')->findBy(['id' => [1, 2, 3]]);
        $form = $this->createFormBuilder()
            ->add(
                'dateFrom',
                'datetime',
                [
                    'data' => new \DateTime('-1month'),
                    'widget' => 'single_text'
                ]
            )
            ->add(
                'dateTo',
                'datetime',
                [
                    'data' => new \DateTime('now'),
                    'widget' => 'single_text'
                ]
            );

        return $this->render(
            'App:layouts:default.html.twig',
            [
                'indexes' => $indexes,
                'filter' => $form->getForm()->createView()
            ]
        );
    }
}
