<?php

namespace FileConverter;

use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\Shape\RichText;

/**
 * Class ConverterPpt
 * @package FileConverter
 */
final class ConverterPpt extends AbstractConverter
{
    /**
     * @var PhpPresentation
     */
    private $document;

    public function __construct($fileName)
    {
        parent::checkFileExist($fileName);

        if ($this->document == null || $this->fileName == null || $this->fileName !== $fileName) {
            $this->document = IOFactory::load($fileName);
        }

        $this->fileName = $fileName;
    }

    /**
     * Get plain text from file
     * @return string
     */
    public function getText()
    {
        $text = '';

        try {
            foreach ($this->document->getAllSlides() as $slide) {
                foreach ($slide->getShapeCollection() as $shape) {
                    if ($shape instanceof RichText) {
                        /**
                         * @var RichText $shape
                         */
                        $text .= $shape->getPlainText() . "\n";
                    }
                }
            }
        } catch (\Exception $ex) {
            return '';
        }

        return $text;
    }


    /**
     * Get document info
     * @param string $fileName
     * @return array
     */
    public function getPptInfo($fileName)
    {
        $pptInfo = (array)$this->document->getDocumentProperties();

        $pptInfoKeys = array_keys($pptInfo);
        foreach ($pptInfoKeys as &$pptInfoKey) {
            $pptInfoKey = str_replace("PhpOffice\\PhpPresentation\\DocumentProperties", '', $pptInfoKey);
            $pptInfoKey = trim($pptInfoKey);
        }
        $pptInfo = array_filter(array_combine($pptInfoKeys, array_values($pptInfo)));

        return $pptInfo;
    }
}