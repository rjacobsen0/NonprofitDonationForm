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
            '#prefix' => '<div id="user-first-name-result">',
            '#suffix' => '</div>',
            '#required' => TRUE,
            '#ajax' => [
                'callback' => '::checkUserFirstNameValidation',
                'effect' => 'fade',
                'event' => 'change',
                'progress' => [
                    'type' => 'throbber',
                    'message' => 'ajax message here',
                ],
             ],
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

    public function checkUserFirstNameValidation(array $form, FormStateInterface $form_state)
    {
        $ajax_response = new AjaxResponse();

        // Check if User or email exists or not
        if (strlen($form_state->getValue(first)) > 128 ) {
            $text = 'First name must not be longer than 128 characters.';
       } else {
         $text = '';
       }
       $ajax_response->addCommand(new HtmlCommand('#user-first-name-result', $text));
       return $ajax_response;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        parent::validateForm($form, $form_state);
        $amount = $form_state->getValue('amount');
        if ($amount < 1 || $amount > 10000 ) {
            $form_state->setErrorByName('amount', $this->t('Amount must be between $1 and $10,000.'));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        if ($this->checkTestStripeApiKey()) {
            drupal_set_message("Thank you for donating!");
            // Make test charge if we have test environment and api key.
            $stripe_token = $form_state->getValue('stripe');
            $amount = $form_state->getValue('amount');
            drupal_set_message("amount: " . $amount);
            $charge = $this->createCharge($stripe_token, $amount);
            drupal_set_message('Charge status: ' . $charge->status);
            if ($charge->status == 'succeeded') {
                $link_generator = \Drupal::service('link_generator');
                drupal_set_message($this->t('Please check payments in @link.', [
                    '@link' => $link_generator->generate('stripe dashboard', Url::fromUri('https://dashboard.stripe.com/test/payments')),
                ]));
            }
        }

        // Display result.
        /*drupal_set_message("Thank you for donating!");
        foreach ($form_state->getValues() as $key => $value) {
            drupal_set_message($key . ': ' . $value);
        }*/
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
        //$charge = Charge::create($params);
        $charge = "charge";
        return $charge;
    }
}