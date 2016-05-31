<?php

namespace FileConverter;

use FileConverter\Utils\DocumentParser;
use Symfony\Component\Filesystem\Exception\IOException;

final class ConverterRtf extends AbstractConverter
{
    public function getText($fileName)
    {
        parent::checkFileExist($fileName);

        try {
            $converter = new DocumentParser();

            $text = $converter->parseFromFile($fileName, 'application/rtf');

            if ($text) {
                return $text;
            } else {
                throw new IOException("Error loading file $fileName");
            }
        } catch (\Exception $ex) {
            return '';
        }
    }
}