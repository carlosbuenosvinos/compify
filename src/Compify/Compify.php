<?php

/*
 * This file is part of Compify.
 *
 * (c) Carlos Buenosvinos <carlos.buenosvinos@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CarlosBuenosvinos\Compify;

/**
 * @author Carlos Buenosvinos <carlos.buenosvinos@gmail.com>
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
            '.editorconfig',
            '.gitattributes',
            '.gitmodules',
            '.gitignore',
            '.travis.yml',
            'CHANGELOG*',
            'CREDITS*',
            'README*',
            'readme.md',
            'phpunit.xml.*',
            'LICENSE*',
            'CONTRIBUT*',
            'UPGRADE*',
            'TODO',
            'VERSION'
        ),
        'packages-rules' => array(
            'symfony/assetic-bundle' => array(
                'src/Symfony/Bundle/AsseticBundle/Tests',
            ),
            'symfony/monolog-bundle' => array(
                'src/Symfony/Bundle/MonologBundle/Tests',
            ),
            'symfony/swiftmailer-bundle' => array(
                'src/Symfony/Bundle/SwiftmailerBundle/Tests',
            ),
            'symfony/symfony' => array(
                'src/Symfony/Bridge/Doctrine/Tests',
                'src/Symfony/Bridge/Monolog/Tests',
                'src/Symfony/Bridge/Propel1/Tests',
                'src/Symfony/Bridge/Swiftmailer/Tests',
                'src/Symfony/Bridge/Twig/Tests',

                'src/Symfony/Bundle/FrameworkBundle/Tests',
                'src/Symfony/Bundle/SecurityBundle/Tests',
                'src/Symfony/Bundle/TwigBundle/Tests',
                'src/Symfony/Bundle/WebProfilerBundle/Tests',

                'src/Symfony/Component/BrowserKit/Tests',
                'src/Symfony/Component/ClassLoader/Tests',
                'src/Symfony/Component/Config/Tests',
                'src/Symfony/Component/Console/Tests',
                'src/Symfony/Component/CssSelector/Tests',
                'src/Symfony/Component/DependencyInjection/Tests',
                'src/Symfony/Component/DomCrawler/Tests',
                'src/Symfony/Component/EventDispatcher/Tests',
                'src/Symfony/Component/Filesystem/Tests',
                'src/Symfony/Component/Finder/Tests',
                'src/Symfony/Component/Form/Tests',
                'src/Symfony/Component/HttpFoundation/Tests',
                'src/Symfony/Component/HttpKernel/Tests',
                'src/Symfony/Component/Locale/Tests',
                'src/Symfony/Component/OptionsResolver/Tests',
                'src/Symfony/Component/Process/Tests',
                'src/Symfony/Component/Routing/Tests',
                'src/Symfony/Component/Security/Tests',
                'src/Symfony/Component/Serializer/Tests',
                'src/Symfony/Component/Templating/Tests',
                'src/Symfony/Component/Translation/Tests',
                'src/Symfony/Component/Validator/Tests',
                'src/Symfony/Component/Yaml/Tests'
            ),
            'mockery/mockery' => array(
                'examples',
                'package.xml'
            ),
            'predis/predis' => array(
                'bin',
                'examples',
                'package.ini',
                'FAQ*'
            ),
            'silex/silex' => array(
                'bin'
            ),
            'swiftmailer/swiftmailer' => array(
                'notes',
                'test-suite',
                'build.xml',
                'CHANGES',
                'create_pear_package.php',
                'package.xml.tpl'
            ),
            'twig/twig' => array(
                'bin',
                'ext',
                '.editorconfig',
                'AUTHORS',
                'package.xml.tpl'
            ),
            'videlalvaro/php-amqplib' => array(
                'benchmark',
                'bin',
                'demo'
            )
        )
    );
}
