<?php
/**
 * nonprofit_donation_thank_you
 */

namespace Drupal\nonprofit_donation_form\Controller;

use Drupal\Core\Controller\ControllerBase;


class ThankYouController extends ControllerBase {

    /**
     * Display the markup.
     *
     * @return array
     */
    public function content() {
        return array(
            '#type' => 'markup',
            '#markup' => $this->t('Thank you for donating!'),
        );
    }

}