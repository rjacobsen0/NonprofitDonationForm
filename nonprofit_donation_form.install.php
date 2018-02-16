<?php
/*
 * create a table in the database for donations
 */

function donation_schema() {
    $schema['Donation'] = array(
        'fields' => array(
            'id'=>array(
                'type'=>'serial',
                'not null' => TRUE,
            ),
            'FirstName'=>array(
                'type' => 'varchar',
                'length' => 128,
                'not null' => TRUE,
            ),
            'LastName'=>array(
                'type' => 'varchar',
                'length' => 128,
                'not null' => TRUE,
            ),
            'Amount'=>array(
                'type' => 'int',
                'not null' => TRUE,
            ),
            'StripeToken'=>array(
                'type' => 'varchar',
                'length' => 256,
                'not null' => TRUE,
            ),
        ),
        'primary key' => array('id'),
    );
    return $schema;

}