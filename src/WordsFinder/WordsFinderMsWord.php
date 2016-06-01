<?php

namespace WordsFinder;

use FileConverter\ConverterDocx;
use FileConverter\FormatFactory;

final class WordsFinderMsWord extends AbstractWordsFinder
{
    public function proceedFile($fileName)
    {
        $fname = basename($fileName);

        $resultForText = parent::proceedFile($fileName);
        $resultForDocInfo = $this->getResultForDocInfo($fileName);
        $resultForHeaders = $this->getResultForHeaders($fileName);
        $resultForFooters = $this->getResultForFooters($fileName);

        $result[$fname]['text'] = $resultForText[$fname]['text'];
        $result[$fname]['DocInfo'] = $resultForDocInfo;
        $result[$fname]['headers'] = $resultForHeaders;
        $result[$fname]['footers'] = $resultForFooters;

        $result[$fname] = array_filter($result[$fname]);

        return $result;
    }

    private function getResultForDocInfo($fileName)
    {
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        /**
         * @var ConverterDocx $converter
         */
        $converter = FormatFactory::factory($fileExt);
        $docInfo = $converter->getDocInfo($fileName);
        foreach ($docInfo as &$item) {
            $item = parent::proceedText($item);
        }
        $docInfo = array_filter($docInfo);

        return $docInfo;
    }

    private function getResultForFooters($fileName)
    {
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        /**
         * @var ConverterDocx $converter
         */
        $converter = FormatFactory::factory($fileExt);
        $footers = parent::proceedText($converter->getFooters($fileName));

        return $footers;

    }

    private function getResultForHeaders($fileName)
    {
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        /**
         * @var ConverterDocx $converter
         */
        $converter = FormatFactory::factory($fileExt);

        $headers = parent::proceedText($converter->getHeaders($fileName));

        return $headers;

    }
}