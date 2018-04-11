<?php
/**
 * Created by PhpStorm.
 * User: tracy
 * Date: 4/10/2018
 * Time: 7:07 PM
 */

require '/var/www/html/vendor/autoload.php';

$client = new Aws\Ses\SesClient([
    'version' => 'latest',
    'region'=> 'us-east-1'
]);
?>