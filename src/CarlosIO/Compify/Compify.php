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
            'twig/twig' => array(
                '.editorconfig',
                'AUTHORS',
                'ext'
            )
        )
    );
}