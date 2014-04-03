<?php
namespace App\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class IndexAdmin extends Admin
{
    protected $baseRoutePattern = 'index';
    protected $baseRouteName = 'app_index';

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add(
                'country',
                'sonata_type_model',
                [
                    'property' => 'name',
                    'required' => true
                ]
            )
            ->add('enabled', null, ['required' => false]);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('name')
            ->add('enabled', null, ['editable' => true])
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'show' => [],
                        'edit' => [],
                        'delete' => [],
                    ]
                ]
            );
    }

    protected function configureDatagridFilters(DatagridMapper $mapper)
    {
        $mapper->add('name', null, ['expanded'=>true]);
    }
}
