<?php

/*
 * This file is part of Compify.
 *
 * (c) Carlos Buenosvinos <hi@carlos.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CarlosIO\Compify;

/**
 * @author Carlos Buenosvinos <hi@carlos.io>
 */
class Compify
{
    const VERSION = '1.0.0-dev';

    public static $rules = array(
        'generic-rules' => array(
            '.git',
            '.svn',
            'test',
            'tests',
            'docs',
            'doc',
            '.gitattributes',
            '.gitmodules',
            '.gitignore',
            '.travis.yml',
            'CHANGELOG*',
            'README*',
            'phpunit.xml.*',
            'LICENSE*'
        ),
        'packages-rules' => array(
            'composer/composer' => array(),
            'justinraibow/json-schema' => array(),
            'silex/silex' => array(),
            'symfony/symfony' => array(),
            'doctrine/orm' => array(),
            'doctrine/doctrine-bundle' => array(),
            'twig/extensions' => array(),
            'symfony/assetic-bundle' => array(),
            'symfony/swiftmailer-bundle' => array(),
            'symfony/monolog-bundle' => array(),
            'sensio/distribution-bundle' => array(),
            'sensio/framework-extra-bundle' => array(),
            'sensio/generator-bundle' => array(),
            'jms/security-extra-bundle' => array(),
            'jms/di-extra-bundle' => array(),
            'kriswallsmith/assetic' => array(),
            'liip/doctrine-cache-bundle' => array(),
            'emagister/memcached-bundle' => array(),
            'doctrine/migrations' => array(),
            'doctrine/data-fixtures' => array(),
            'facebook/php-sdk' => array(),
            'imagine/imagine' => array(),
            'emagister/options-resolver' => array(),
            'emagister/zendframework1' => array(),
            'twig/twig' => array(),
            'alb/zwig' => array(),
            'emagister/zend-form-decorators-bootstrap' => array(),
            'videlalvaro/php-amqplib' => array(),
            'spekkionu/htmlpurifier' => array(),
            'predis/predis' => array(),
            'endroid/qrcode' => array(),
            'carlosio/whatsapp' => array(),
            'carlosio/compify' => array()
        )
    );
}