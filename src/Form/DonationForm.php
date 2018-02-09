<?php

namespace Drupal\nonprofit_donation_form\Form;

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
            '#type' => 'textfield',
            '#title' => t('Donation Amount:'),
            '#required' => TRUE,
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
        // drupal_set_message($this->t('@can_name ,Your application is being submitted!', array('@can_name' => $form_state->getValue('candidate_name'))));
        drupal_set_message("Thank you for donating!");
        foreach ($form_state->getValues() as $key => $value) {
            drupal_set_message($key . ': ' . $value);
            // Would like to use a non-deprecated message call. This one doesn't work:
            // $this->messenger->addMessage("Thank you for donating!" . $key . ': ' . $value);
        }
    }

    /**
     * @return string
     */
    public function getFormId() {
        return 'DonationForm';
    }
}