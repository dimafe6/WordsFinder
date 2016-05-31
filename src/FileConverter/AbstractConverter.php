<?php

namespace FileConverter;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

abstract class AbstractConverter implements ConverterInterface
{
    public static function checkFileExist($fileName) {
        if(!file_exists($fileName)) {
            throw new FileNotFoundException(sprintf('File "%s" could not be found.', $fileName));
        }
    }
}