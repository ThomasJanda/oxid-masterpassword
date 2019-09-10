<?php

$sMetadataVersion = '2.0';

$aModule = array(
    'id'               => 'rs-masterpassword',
    'title'            => '*RS Master password',
    'description'      => '',
    'thumbnail'        => '',
    'version'          => '1.0.0',
    'author'           => '',
    'url'              => '',
    'email'            => '',
    'extend'           => array(
        \OxidEsales\Eshop\Application\Model\User::class => rs\masterpassword\Application\Model\User::class,
    ),
    'settings' => array(
        array(
            'group' => 'rs-masterpassword_settings_group',
            'name' => 'rs-masterpassword_password',
            'type' => 'str',  
            'value' => ''
        ),
    )
);
