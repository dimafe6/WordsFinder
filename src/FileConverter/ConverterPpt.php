<?php

namespace FileConverter;

use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Shape\RichText;

final class ConverterPpt extends AbstractConverter
{
    public function getText($fileName)
    {
        parent::checkFileExist($fileName);

        $text = '';

        try {
            $objPHPPowerPoint = IOFactory::load($fileName);
            foreach ($objPHPPowerPoint->getAllSlides() as $slide) {
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

}