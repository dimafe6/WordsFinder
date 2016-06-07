<?php

namespace WordsFinder;

/**
 * Default WordsFinder
 * Class WordsFinderDefault
 * @package WordsFinder
 */
final class WordsFinderDefault extends AbstractWordsFinder
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

        $result[$fname]['text'] = $resultForText;
        $result[$fname] = array_filter($result[$fname]);

        return array_filter($result);
    }
}