<?php

namespace FileConverter;

/**
 * Interface ConverterInterface
 * @package FileConverter
 */
interface ConverterInterface
{
    /**
     * Get text from file
     * @param string $fileName
     * @return string
     */
    public function getText($fileName);
}