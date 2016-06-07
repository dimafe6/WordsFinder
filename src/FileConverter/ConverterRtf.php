<?php

namespace FileConverter;

use FileConverter\Utils\DocumentParser;
use Symfony\Component\Filesystem\Exception\IOException;

/**
 * Class ConverterRtf
 * @package FileConverter
 */
final class ConverterRtf extends AbstractConverter
{
    public function __construct($fileName)
    {
        parent::checkFileExist($fileName);

        $this->fileName = $fileName;
    }

    /**
     * Get plain text from file
     * @return string
     * @throws IOException
     */
    public function getText()
    {
        parent::checkFileExist($this->fileName);

        try {
            $converter = new DocumentParser();

            $text = $converter->parseFromFile($this->fileName, 'application/rtf');

            if ($text) {
                return $text;
            } else {
                throw new IOException("Error loading file $this->fileName");
            }
        } catch (\Exception $ex) {
            return '';
        }
    }
}