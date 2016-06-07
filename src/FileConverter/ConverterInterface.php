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
     * @return string
     */
    public function getText();
}