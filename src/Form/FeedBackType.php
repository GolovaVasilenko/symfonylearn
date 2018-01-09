<?php


namespace App\Form;


use App\Entity\FeedBack;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedBackType extends AbstractType
{

	public function configureOptions( OptionsResolver $resolver )
	{
		$resolver->setDefaults(array(
			'data_class' => FeedBack::class,
		));
	}


	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('name')
			->add('email')
			->add('message')
		;
	}
}