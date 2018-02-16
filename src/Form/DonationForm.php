<?php

/**
 * @file
 * Contains \Drupal\nonprofit_donation_form\Form\DonationForm.php
 */

namespace Drupal\nonprofit_donation_form\Form;

use Drupal\Core\Form\drupal_set_message;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Stripe\Stripe;
use Stripe\Charge;

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
        $form['first'] = [
            '#type' => 'textfield',
            '#title' => $this->t('First name'),
            '#required' => TRUE,
        ];
        $form['last'] = [
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
            "#stripe_selectors" => [
                'first_name' => ':input[name="first"]',
                'last_name' => ':input[name="last"]',
            ]
        ];
        if ($this->checkTestStripeApiKey()) {
            $form['submit'] = [
                '#type' => 'submit',
                '#value' => $this->t('Donate'),
            ];
        }

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        parent::validateForm($form, $form_state);

        if ($this->currentUser->isAnonymous()) {
            $form_state->setError($form['submit'], $this->t('You must be logged in to make a donation.'));
        }

        $amount = $form_state->getValue('amount');
        if (!intval($amount)) {
            $form_state->setErrorByName('amount', $this->t('Amount needs to be a number'));
        }
        if ($amount < 1 || $amount > 10000 ) {
            $form_state->setErrorByName('amount', $this->t('Amount must be between $1 and $10,000.'));
        }

        $firstName = $form_state->getValue('first');
        if (strlen($firstName) < 1 || strlen($firstName) > 128 ) {
            $form_state->setErrorByName('first', $this->t('First name must have length at least 1 and less than 128 characters.'));
        }
        $lastName = $form_state->getValue('last');
        if (strlen($lastName) < 1 || strlen($lastName) > 128 ) {
            $form_state->setErrorByName('last', $this->t('Last name must have length at least 1 and less than 128 characters.'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        if ($this->checkTestStripeApiKey()) {

            $account = $this->currentUser;

            // Make a charge if we have test environment and api key.
            $stripe_token = $form_state->getValue('stripe');
            $amount = $form_state->getValue('amount');

            $charge = $this->createCharge($stripe_token, $amount);
            if ($charge->status == 'succeeded') {
                drupal_set_message("Thank you for donating!");
                drupal_set_message("amount: " . $amount);

                $firstName = $form_state->getValue('first');
                $lastName = $form_state->getValue('last');
                // $this->SaveDonorInfoDB($firstName, $lastName, $stripe_token, $amount);
            }
            else
            {
                drupal_set_message('Error: Payment not processed.', 'error');
            }
            drupal_set_message('Charge status: ' . $charge->status);
        }

    }

    /**
     * Helper function for saving a donation. Should be moved into its own class.
     */
    private function SaveDonorInfoDB($firstName, $lastName, $stripe_token, $amount) {
        $field = array(
            'FirstName' =>  $firstName,
            'LastName' => $lastName,
            'Amount' =>  $amount,
            'StripeToken' => $stripe_token,
        );

        /* This is one method. I'm also trying the uncommented method below. Will go with the one that
        gives me working code. If both are working I will go with the one below because it is more D8.
        
        $return = DonationStorage::insert($field);
        if ($return) {
            drupal_set_message($this->t('Created entry @field', ['@field' => print_r($field, TRUE)]));
        }
*/

        $query = \Drupal::database();
        try {
            $query->insert('Donation')
                ->fields($field)
                ->execute();
            drupal_set_message("Successfully saved");
            $response = new RedirectResponse("/nonprofit_donation_form/thank_you");
            $response->send();
        }
        catch (\Exception $e) {
            drupal_set_message("Error: data was not saved. " . $e->getMessage());
        }

    }
    /**
     * Helper function for checking Stripe Api Keys.
     */
    private function checkTestStripeApiKey() {
        $status = FALSE;
        $config = \Drupal::config('stripe.settings');
        if ($config->get('environment') == 'test' && $config->get('apikey.test.secret')) {
            $status = TRUE;
        }
        return $status;
    }

    /**
     * Helper function for test charge.
     *
     * @param string $stripe_token
     *   Stripe API token.
     * @param int $amount
     *   Amount for charge.
     *
     * @return /Stripe/Charge
     *   Charge object.
     */
    private function createCharge($stripe_token, $amount) {
        $config = \Drupal::config('stripe.settings');
        Stripe::setApiKey($config->get('apikey.test.secret'));
        $params = array(
            'amount' => $amount * 100,
            'currency' => 'usd',
            'description' => "Example charge",
            'source' => $stripe_token,
            );
        // This is the call I want to make, but it's not working.
        $charge = Charge::create($params);
        return $charge;
    }
}