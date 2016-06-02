<?php

namespace WordsFinder;

use FileConverter\ConverterPpt;
use FileConverter\FormatFactory;

/**
 * Class WordsFinderMsPowerPoint
 * @package WordsFinder
 */
final class WordsFinderMsPowerPoint extends AbstractWordsFinder
{
    /**
     * Process file
     * @param string $fileName
     * @return array
     */
    public function proceedFile($fileName)
    {
        $fname = basename($fileName);

        $resultForText = parent::proceedFile($fileName);
        $resultForPptInfo = $this->getResultForPptInfo($fileName);

        $result[$fname]['text'] = $resultForText[$fname]['text'];
        $result[$fname]['DocInfo'] = $resultForPptInfo;

        $result[$fname] = array_filter($result[$fname]);

        return $result;
    }

    /**
     * Get result for document info
     * @param string $fileName
     * @return array
     */
    private function getResultForPptInfo($fileName)
    {
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        /**
         * @var ConverterPpt $converter
         */
        $converter = FormatFactory::factory($fileExt);
        $pptInfo = $converter->getPptInfo($fileName);
        foreach ($pptInfo as &$item) {
            $item = parent::proceedText($item);
        }
        
        $pptInfo = array_filter($pptInfo);

        return $pptInfo;
    }
}