<?php

namespace Drupal\car\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
* Defines the Car entity.
*
* @ingroup car
*
* @ContentEntityType(
*   id = "car",
*   label = @Translation("Car"),
*   handlers = {
*     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
*     "list_builder" = "Drupal\car\CarListBuilder",
*     "views_data" = "Drupal\car\Entity\CarViewsData",
*     "translation" = "Drupal\car\CarTranslationHandler",
*
*     "form" = {
*       "default" = "Drupal\car\Form\CarForm",
*       "add" = "Drupal\car\Form\CarForm",
*       "edit" = "Drupal\car\Form\CarForm",
*       "delete" = "Drupal\car\Form\CarDeleteForm",
*     },
*     "access" = "Drupal\car\CarAccessControlHandler",
*     "route_provider" = {
*       "html" = "Drupal\car\CarHtmlRouteProvider",
*     },
*   },
*   base_table = "car",
*   data_table = "car_field_data",
*   translatable = TRUE,
*   admin_permission = "administer car entities",
*   entity_keys = {
*     "id" = "id",
*     "label" = "registration_number",
*     "uuid" = "uuid",
*     "langcode" = "langcode",
*     "status" = "status",
*   },
*   links = {
*     "canonical" = "/admin/car/{car}",
*     "add-form" = "/admin/car/add",
*     "edit-form" = "/admin/car/{car}/edit",
*     "delete-form" = "/admin/car/{car}/delete",
*     "collection" = "/admin/car",
*   }
* )
*/
class Car extends ContentEntityBase implements CarInterface {

    use EntityChangedTrait;

    /**
    * {@inheritdoc}
    */
    public function getName() {
        return $this->get('registration_number')->value;
    }

    /**
    * {@inheritdoc}
    */
    public function setName($name) {
        $this->set('registration_number', $name);
        return $this;
    }

    /**
    * {@inheritdoc}
    */
    public function getCreatedTime() {
        return $this->get('created')->value;
    }

    /**
    * {@inheritdoc}
    */
    public function setCreatedTime($timestamp) {
        $this->set('created', $timestamp);
        return $this;
    }

    /**
    * {@inheritdoc}
    */
    public function isPublished() {
        return (bool) $this->getEntityKey('status');
    }

    /**
    * {@inheritdoc}
    */
    public function setPublished($published) {
        $this->set('status', $published ? TRUE : FALSE);
        return $this;
    }

    /**
    * {@inheritdoc}
    */
    public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
        $fields = parent::baseFieldDefinitions($entity_type);

        $fields['registration_number'] = BaseFieldDefinition::create('string')
        ->setLabel(t('Registration number'))
        ->setDescription(t('The registration number of the Car.'))
        ->setSettings([
            'max_length' => 15,
            'text_processing' => 0,
        ])
        ->setDefaultValue('')
        ->setDisplayOptions('view', [
            'label' => 'above',
            'type' => 'string',
            'weight' => -4,
        ])
        ->setDisplayOptions('form', [
            'type' => 'string_textfield',
            'weight' => -4,
        ])
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE)
        ->setRequired(TRUE);

        $fields['color'] = BaseFieldDefinition::create('list_string')
        ->setLabel(t('Color'))
        ->setDescription(t('The color of the Car.'))
        ->setSettings([
            'allowed_values' => [
                'White' => t('White'),
                'Grey' => t('Grey'),
                'Red' => t('Red')
            ],
        ])
        ->setDisplayOptions('view', [
            'label' => 'above',
            'type' => 'string',
            'weight' => -4,
        ])
        ->setDisplayOptions('form', [
            'type' => 'options_select',
            'weight' => -4,
        ])
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE)
        ->setRequired(TRUE);

        $fields['km'] = BaseFieldDefinition::create('decimal')
        ->setLabel(t('Kilometers'))
        ->setDescription(t('The kilometers of the Car.'))
        ->setSettings([
            'precision' => 10,
            'scale' => 2
        ])
        ->setDefaultValue('0')
        ->setDisplayOptions('view', [
            'label' => 'above',
            'type' => 'number_decimal',
            'weight' => -4,
        ])
        ->setDisplayOptions('form', [
            'type' => 'number',
            'weight' => -4,
        ])
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE)
        ->setRequired(TRUE);

        $fields['owner'] = BaseFieldDefinition::create('string')
        ->setLabel(t('Owner'))
        ->setDescription(t('The Owner of the Car.'))
        ->setSettings([
            'max_length' => 60,
            'text_processing' => 0,
        ])
        ->setDefaultValue('')
        ->setDisplayOptions('view', [
            'label' => 'above',
            'type' => 'string',
            'weight' => -4,
        ])
        ->setDisplayOptions('form', [
            'type' => 'string_textfield',
            'weight' => -4,
        ])
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE)
        ->setRequired(TRUE);

        $fields['image'] = BaseFieldDefinition::create('image')
        ->setLabel(t('Image'))
        ->setDescription(t('Image'))
        ->setSettings([
            'file_directory' => 'IMAGE_FOLDER',
            'alt_field_required' => FALSE,
            'file_extensions' => 'png jpg jpeg',
        ])
        ->setDisplayOptions('view', array(
            'label' => 'hidden',
            'type' => 'default',
            'weight' => 0,
        ))
        ->setDisplayOptions('form', array(
            'label' => 'hidden',
            'type' => 'image_image',
            'weight' => -4,
        ))
        ->setDisplayConfigurable('form', TRUE)
        ->setDisplayConfigurable('view', TRUE);

        $fields['status'] = BaseFieldDefinition::create('boolean')
        ->setLabel(t('Publishing status'))
        ->setDescription(t('A boolean indicating whether the Car is published.'))
        ->setDefaultValue(TRUE)
        ->setDisplayOptions('form', [
            'type' => 'boolean_checkbox',
            'weight' => -3,
        ]);

        $fields['created'] = BaseFieldDefinition::create('created')
        ->setLabel(t('Created'))
        ->setDescription(t('The time that the entity was created.'));

        $fields['changed'] = BaseFieldDefinition::create('changed')
        ->setLabel(t('Changed'))
        ->setDescription(t('The time that the entity was last edited.'));

        return $fields;
    }

}
