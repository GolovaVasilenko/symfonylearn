<?php



namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductAdmin extends AbstractAdmin {
	protected function configureFormFields(FormMapper $formMapper)
	{
		$formMapper
			->add('category', null, ['label' => 'Категория'])
			->add('name')
			->add('slug')
			->add('price')
			->add('imageFile', VichImageType::class, ['required' => false])
			->add('description');
	}

	protected function configureDatagridFilters(DatagridMapper $datagridMapper)
	{
		$datagridMapper
			->add('category')
			->add('name')
			->add('slug')
			->add('price');
	}

	protected function configureListFields(ListMapper $listMapper)
	{
		$listMapper
			->add('ID')
			->addIdentifier('name')
			->add('slug')
			->add('price');
	}
}