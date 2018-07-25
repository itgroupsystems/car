<?php

namespace Drupal\car\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
* Form controller for Car edit forms.
*
* @ingroup car
*/
class CarForm extends ContentEntityForm {

    /**
    * {@inheritdoc}
    */
    public function buildForm(array $form, FormStateInterface $form_state) {
        /* @var $entity \Drupal\car\Entity\Car */
        $form = parent::buildForm($form, $form_state);

        $entity = $this->entity;

        return $form;
    }

    /**
    * {@inheritdoc}
    */
    public function save(array $form, FormStateInterface $form_state) {
        $entity = $this->entity;

        $status = parent::save($form, $form_state);

        switch ($status) {
            case SAVED_NEW:
            drupal_set_message($this->t('Created the %label Car.', [
                '%label' => $entity->registration_number->value,
            ]));
            break;

            default:
            drupal_set_message($this->t('Saved the %label Car.', [
                '%label' => $entity->registration_number->value,
            ]));
        }
        $form_state->setRedirect('entity.car.canonical', ['car' => $entity->id()]);
    }

}
