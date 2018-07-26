<?php

namespace Drupal\car\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
* Provides a Car Resource
*
* @RestResource(
*   id = "car_resource",
*   label = @Translation("Car Resource"),
*   uri_paths = {
*     "canonical" = "/car"
*   }
* )
*/
class CarResource extends ResourceBase {
    /**
    * Responds to entity GET requests.
    * @return \Drupal\rest\ResourceResponse
    */
    public function get() {
        $query = \Drupal::database()->select('car_field_data', 'car');

        $query->join('file_managed', 'image', 'image.fid = car.image__target_id');
        $query->fields('car', ['id', 'registration_number', 'color', 'km', 'owner', 'image__alt', 'image__title', 'image__width', 'image__height']);
        $query->fields('image', ['filename']);

        $response = [];
        $result = $query->execute();

        while ($record = $result->fetchAssoc()) {
            $record['image'] = [
                'url' => $GLOBALS['base_url'] . '/sites/default/files/IMAGE_FOLDER/' . $record['filename'],
                'alt' => $record['image__alt'],
                'title' => $record['image__title'],
                'width' => $record['image__width'],
                'height' => $record['image__height']
            ];
            unset($record['filename']);
            unset($record['image__alt']);
            unset($record['image__title']);
            unset($record['image__width']);
            unset($record['image__height']);

            $response[] = $record;
        }


        $build = array(
            '#cache' => array(
                'max-age' => 0,
            ),
        );

        return (new ResourceResponse($response))->addCacheableDependency($build);
    }
}
