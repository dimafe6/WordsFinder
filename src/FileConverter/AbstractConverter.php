<?php

namespace FileConverter;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Get text from file
 * 
 * Class AbstractConverter
 * @package FileConverter
 */
abstract class AbstractConverter implements ConverterInterface
{
    protected $fileName = null;

    abstract public function __construct($fileName);

    /**
     * Check if file exist
     * @param string $fileName
     */
    public static function checkFileExist($fileName) {
        if(!file_exists($fileName)) {
            throw new FileNotFoundException(sprintf('File "%s" could not be found.', $fileName));
        }
    }
}