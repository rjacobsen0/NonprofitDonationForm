<?php

/**
 * @file
 * Contains \Drupal\nonprofit_donation_form\Form\DonationForm.php
 */

namespace Drupal\nonprofit_donation_form\Form;

use Drupal\Core\Form\drupal_set_message;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Stripe\Stripe as libraryStripe;
use Stripe\Charge;
use Drupal\stripe\Element\Stripe as elementStripe;

class DonationForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'DonationForm';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        libraryStripe::setApiKey("sk_test_WHRBOCsLkZ3LmFRONlOGjn25");

        $form['donor_first_name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('First name'),
            '#required' => TRUE,
        ];
        $form['donor_last_name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Last name'),
            '#required' => TRUE,
        ];
        $form['amount'] = [
            '#type' => 'number',
            '#title' => t('Amount:'),
            '#required' => TRUE,
        ];
        $form['stripe'] = [
            '#type' => 'stripe',
            '#title' => $this->t('Credit card'),
            // The selectors are gonna be looked within the enclosing form only
            "#stripe_selectors" => [
                'first_name' => ':input[name="first"]',
                'last_name' => ':input[name="last"]',
            ]
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Donate'),
        ];

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        parent::validateForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        // Display result.
        drupal_set_message("Thank you for donating!");
        foreach ($form_state->getValues() as $key => $value) {
            drupal_set_message($key . ': ' . $value);
        }
        libraryStripe::setApiKey("sk_test_WHRBOCsLkZ3LmFRONlOGjn25");
        $charge = Charge::create(array('amount' => 2000, 'currency' => 'usd', 'source' => 'tok_189fqt2eZvKYlo2CTGBeg6Uq' ));
        echo $charge;
        elementStripe::processStripe($form);
    }

}