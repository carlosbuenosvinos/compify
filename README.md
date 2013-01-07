Compify, a PHP tool to save composer disk usage and bandwith
============================================================

Compify is a tool to save disk usage and bandwith in your composer vendor folder.

Maybe you haven't noticed, but if you take a look to your vendor folder after doing
a ```php composer.phar install``` there are so much useless information like tests,
```.travis.yml``` like fails that you just don't need in production.

Consider also packages installed from source (using ```git clone``` or ```svn checkout```, not
downloading a zip or methods base), they include folders like ```.git``` or ```.svn``` and, believe me,
you don't want those folders in production.

You could think, compify it's not necessary because disk is cheap, blah, blah, blah.
However, in my case, installing my application in 30 servers, each one

## Installation

Download phar distribution and use it as a Symfony Console Component application.

```php
cd <your application>
wget https://github.com/carlosbuenosvinos/compify/raw/master/compify.phar
```

## Usage

```
php compify.phar crush
Usage:
 crush [vendor-path]

Arguments:
 vendor-path  Composer vendor path (default: "./vendor")

Help:
 The crush command removes all the
 unnecessary files for each composer
 package in order to save disk usage
 and bandwidth.
```

## Example

```
ShivanDragon:trunk charlie$ php compify.phar crush
Crushing vendors (by Carlos Buenosvinos)
Vendor size before crushing: 150M
Vendor size after crushing: 96M
```

## More Information

For any issue use PR github system, for other info, send me an email to hi@carlos.io

## License

Compify is licensed under the MIT license.