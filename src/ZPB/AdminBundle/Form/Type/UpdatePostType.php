<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 19/10/2014
 * Time: 19:27
 */
 /*
           ____________________
  __      /     ______         \
 {  \ ___/___ /       }         \
  {  /       / #      }          |
   {/ ô ô  ;       __}           |
   /          \__}    /  \       /\
<=(_    __<==/  |    /\___\     |  \
   (_ _(    |   |   |  |   |   /    #
    (_ (_   |   |   |  |   |   |
      (__<  |mm_|mm_|  |mm_|mm_|
*/

namespace ZPB\AdminBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UpdatePostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('body')
            ->add('excerpt')
            ->add('category','hidden',['mapped'=>false])
            ->add('tags','hidden',['mapped'=>false])
            ->add('targets', 'hidden', ['mapped'=>false])
            ->add('submit', 'submit', ['label'=>'modifier'])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'=>'ZPB\AdminBundle\Entity\Post',
                'csrf_protection'=>true,
                'csrf_field_name'=>'_token',
                'intention'=>'update_post'

            ]
        );
    }


    public function getName()
    {
        return "update_post_form";
    }
}
