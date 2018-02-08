<?php

namespace Drupal\nonprofit_donation_form\Controller;

use Drupal\Core\Controller\ControllerBase;

class DonationFormController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   */
  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => $this->t('Hello, World!'),
    );
  }

}