<?php
namespace App\Admin;

use App\Entity\Value;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class ValueAdmin extends Admin
{
    protected $baseRoutePattern = 'value';
    protected $baseRouteName = 'app_value';

    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'createdAt'
    ];

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Meta')
            ->add('date', 'datetime')
            ->add(
                'volatility',
                'choice',
                [
                    'choices' => Value::getVolatilityValues()
                ]
            )
            ->add('index')
            ->end()
            ->with('Data')
            ->add('prognosed')
            ->add('actual')
            ->end()
            ->setHelps(
                [
                    'prognosed' => 'Fixed value will be calculated automatically based on diff between actual and prognosed values ',
                ]
            );
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('index.name')
            ->add('prognosed')
            ->add('actual')
            ->add('fixed')
            ->add('createdAt')
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

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('index')
            ->add('createdAt', 'doctrine_orm_datetime_range', ['input_type' => 'timestamp'])
            ->add('prognosed', null, [], 'sonata_type_filter_number')
            ->add('actual', null, [], 'sonata_type_filter_number')
            ->add('fixed', null, [], 'sonata_type_filter_number');
    }
}
