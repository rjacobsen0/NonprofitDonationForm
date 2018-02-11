<?php

/**
 * @file
 * Contains \Drupal\nonprofit_donation_form\Form\DonationForm.php
 */

namespace Drupal\nonprofit_donation_form\Form;

use Drupal\Core\Form\drupal_set_message;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class DonationForm extends FormBase {

    /**
     * @param array $form
     * @param FormStateInterface $form_state
     * @return array
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['donor_name'] = array(
            '#type' => 'textfield',
            '#title' => t('Your Name:'),
            '#required' => TRUE,
        );
        /*
        $form['amount_list'] = array (
            '#type' => 'select',
            '#title' => ('Amount'),
            '#options' => array(
                '20' => t('$20'),
                '50' => t('$50'),
                '100' => t('$100'),
            ),
        );
        */
        $form['amount'] = array(
            '#type' => 'number',
            '#title' => t('Donation Amount in US dollars:'),
            '#required' => TRUE,
        );

        $form['stripe_button'] = array(
            '#type' => 'markup',
            '#markup' => $this->t('
                    <div class="form-row">
                    <label for="card-element">
                      Credit or debit card
                    </label>
                    <div id="card-element">
                      <!-- a Stripe Element will be inserted here. -->
                    </div>
                    <!-- Used to display form errors -->
                    <div id="card-errors" role="alert"></div>
  </div>
            '),
            '#attached' => array('library' => array('stripe/stripe', 'stripe/stripe.js', 'nonprofit_donation_form/nonprofit_donation_form_library'))
        );

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Donate'),
            '#button_type' => 'primary',
        );

        return $form;
    }


    /**
     * @param array $form
     * @param FormStateInterface $form_state
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        if ($form_state->getValue('amount') < 1 || $form_state->getValue('amount') > 10000 ) {
            $form_state->setErrorByName('amount', $this->t('Amount must be between $1 and $10,000.'));
        }
    }


    /**
     * @param array $form
     * @param FormStateInterface $form_state
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {

        // commerce_stripe_load_library();

        // drupal_set_message($this->t('@can_name ,Your application is being submitted!', array('@can_name' => $form_state->getValue('candidate_name'))));
        drupal_set_message("Thank you for donating!");
        foreach ($form_state->getValues() as $key => $value) {
            drupal_set_message($key . ': ' . $value);
            // Would like to use a non-deprecated message call. This one doesn't work:
            // $this->messenger->addMessage("Thank you for donating!" . $key . ': ' . $value);
        }
        /*
                // Set your secret key: remember to change this to your live secret key in production
                // See your keys here: https://dashboard.stripe.com/account/apikeys
                if (module_exists('Stripe') && function_exists('setApiKey')) {
                    Stripe::setApiKey("sk_test_WHRBOCsLkZ3LmFRONlOGjn25");
                }

                // Token is created using Checkout or Elements!
                // Get the payment token ID submitted by the form:
                $token = $_POST['stripeToken'];
                drupal_set_message($token);

                // Charge the user's card:
        //         if (module_exists('Charge') && function_exists('create')) {
        //             $charge = Charge::create(array(
        //                 "amount" => 999,
        //                 "currency" => "usd",
        //                 "description" => "Example charge",
        //                 "source" => $token,
        //             ));
        //         }
        */
    }

    /**
     * @return string
     */
    public function getFormId() {
        return 'DonationForm';
    }
}