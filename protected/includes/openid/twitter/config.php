<?php

/**
 * @file
 * A single location to store configuration.
 */
$openid_twitter = array(
    'CONSUMER_KEY' => 'M8MDalq63m7X3GxSHPe0eg',
    'CONSUMER_SECRET' => 'KANPnoOfUt6VPFudheZkFxQ0ARQrcuSWXrn7j5BicI',
    'OAUTH_CALLBACK' => 'http://resumebuilder.com/account/twittercallback',
);
define('CONSUMER_KEY', $openid_twitter['CONSUMER_KEY']);
define('CONSUMER_SECRET', $openid_twitter['CONSUMER_SECRET']);
define('OAUTH_CALLBACK', $openid_twitter['OAUTH_CALLBACK']);
