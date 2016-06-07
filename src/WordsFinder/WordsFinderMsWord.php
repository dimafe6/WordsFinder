<?php

namespace WordsFinder;

use FileConverter\ConverterDocx;
use FileConverter\FormatFactory;

/**
 * Class WordsFinderMsWord
 * @package WordsFinder
 */
final class WordsFinderMsWord extends AbstractWordsFinder
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
        $resultForDocInfo = $this->getResultForDocInfo($fileName);
        $resultForHeaders = $this->getResultForHeaders($fileName);
        $resultForFooters = $this->getResultForFooters($fileName);

        $result[$fname]['text'] = $resultForText;
        $result[$fname]['DocInfo'] = $resultForDocInfo;
        $result[$fname]['headers'] = $resultForHeaders;
        $result[$fname]['footers'] = $resultForFooters;

        $result[$fname] = array_filter($result[$fname]);

        return array_filter($result);
    }

    /**
     * Get result for document info
     * @param string $fileName
     * @return array
     */
    private function getResultForDocInfo($fileName)
    {
        /**
         * @var ConverterDocx $converter
         */
        $converter = FormatFactory::factory($fileName);

        $docInfo = $converter->getDocInfo($fileName);
        foreach ($docInfo as &$item) {
            $item = parent::proceedText($item);
        }
        $docInfo = array_filter($docInfo);

        return $docInfo;
    }

    /**
     * Get result for footers
     * @param string $fileName
     * @return int
     */
    private function getResultForFooters($fileName)
    {
        /**
         * @var ConverterDocx $converter
         */
        $converter = FormatFactory::factory($fileName);
        $footers = parent::proceedText($converter->getFooters($fileName));

        return $footers;

    }

    /**
     * Get result for headers
     * @param string $fileName
     * @return int
     */
    private function getResultForHeaders($fileName)
    {
        /**
         * @var ConverterDocx $converter
         */
        $converter = FormatFactory::factory($fileName);

        $headers = parent::proceedText($converter->getHeaders($fileName));

        return $headers;

    }
}