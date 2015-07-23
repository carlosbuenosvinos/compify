Compify, save Composer disk and bandwith
========================================

Compify is a tool to save disk usage and bandwith in your composer vendor folder.

Maybe you haven't noticed, but if you take a look to your vendor folder after doing
a ```php composer.phar install``` there are so much useless information like tests,
```.travis.yml``` like files that you just don't need in production.

Consider also packages installed from source (using ```git clone``` or ```svn checkout```, not
downloading a zip or methods base), they include folders like ```.git``` or ```.svn``` and, believe me,
you don't want those folders in production.

In most of the cases, you will be deploying to production and storing different versions
of your application, installing dependencies directly from your servers or rsyncing
from a deployer machine. So, using compify you can save bandwith or time when deploying.

Installation
------------

### Locally

Download the
[`compify.phar`](https://raw.github.com/carlosbuenosvinos/compify/master/compify.phar) file and
store it somewhere on your computer.

### Globally

You can run these commands to easily acces `compify` from anywhere on your system:

    $ sudo https://github.com/carlosbuenosvinos/compify/raw/master/compify.phar -O /usr/local/bin/compify

then:

    $ sudo chmod a+x /usr/local/bin/compify

and:

    $ sudo vi /etc/php/php.ini
    # search for "basedir"
    # add ":/usr/local/bin" at the end and save

Then, just run `compify` in order to run compify

Update
------

### Locally

The `self-update` command tries to update compify itself:

    $ php compify.phar self-update

### Globally

You can update compify through this command:

    $ sudo compify self-update


## Usage

    php compify.phar crush --help
    Usage:
     crush [vendor-path]

    Arguments:
     vendor-path  Composer vendor path (default: "./vendor")

    Help:
     The crush command removes all the
     unnecessary files for each composer
     package in order to save disk usage
     and bandwidth.

## How does it work

Compify goes through every local composer dependency installed in your machine
and removes typical unnecessary files and folders (what we call generic rules)
for that package. Also, we have identified specific rules for specific packages
that will also merge with the generic rules.

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

You can contribute adding new package specific rules or any code update obsviously.

## Example

Let's assummed a small project with following composer.json

    ...
    "require": {
        "twig/twig": ">=1.8,<2.0-dev",
        "symfony/twig-bridge": "2.1.*",
        "swiftmailer/swiftmailer": "4.3.x-dev",
        "symfony/console": "2.1.*",
        "doctrine/dbal": "2.3.*",
        "silex/silex": "1.0.*",
        "guzzle/guzzle": "3.0.*"
    },
    ...

    $ php compify.phar crush
    Crushing vendors (by Carlos Buenosvinos)
    Vendor size before crushing: 73M
    Vendor size after crushing: 18M

Do you need more arguments?

## More Information

For any issue use PR github system, for other info, send me an email to carlos.buenosvinos@gmail.com

## License

Compify is licensed under the MIT license.
