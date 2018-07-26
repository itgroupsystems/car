<?php

namespace Drupal\car\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
* Provides a Car Resource
*
* @RestResource(
*   id = "car_resource_id",
*   label = @Translation("Car Resource Id"),
*   uri_paths = {
*     "canonical" = "/car/{id}"
*   }
* )
*/
class CarResourceId extends ResourceBase {
    /**
    * Responds to entity GET requests.
    * @return \Drupal\rest\ResourceResponse
    */
    public function get($id) {
        $query = \Drupal::database()->select('car_field_data', 'car');

        $query->join('file_managed', 'image', 'image.fid = car.image__target_id');
        $query->fields('car', ['id', 'registration_number', 'color', 'km', 'owner', 'image__alt', 'image__title', 'image__width', 'image__height']);
        $query->fields('image', ['filename']);
        $query->condition('id', $id);

        $response = [];
        $result = $query->execute();

        $response = $result->fetchAssoc();
        $response['image'] = [
            'url' => $GLOBALS['base_url'] . '/sites/default/files/IMAGE_FOLDER/' . $response['filename'],
            'alt' => $response['image__alt'],
            'title' => $response['image__title'],
            'width' => $response['image__width'],
            'height' => $response['image__height']
        ];
        unset($response['filename']);
        unset($response['image__alt']);
        unset($response['image__title']);
        unset($response['image__width']);
        unset($response['image__height']);

        $build = array(
            '#cache' => array(
                'max-age' => 0,
            ),
        );

        return (new ResourceResponse($response))->addCacheableDependency($build);
    }
}
