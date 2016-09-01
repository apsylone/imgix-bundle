# ApsyloneImgixBundle
ApsyloneImgixBundle is a Symfony2 Bundle for [Imgix.com](Imgix.com) library. [Documentation of Imgix API](https://docs.imgix.com/apis/url) .

## Install

Via Composer

``` bash
$ php composer.phar require apsylone/imgix-bundle
```
or in composer.json file
``` bash
"apsylone/imgix-bundle": "dev-master"
```

Register the bundle in `app/AppKernel.php`:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    return array(
        // ...
        new Apsylone\ImgixBundle\ApsyloneImgixBundle(),
        // ...
    );
}
```

## Configuration

Coming

## License

This Wrapper is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT)