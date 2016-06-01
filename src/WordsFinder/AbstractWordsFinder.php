<?php

namespace WordsFinder;

use FileConverter\ConverterInterface;
use FileConverter\FormatFactory;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use WordsFinder\Exception\WordsFinderException;

abstract class AbstractWordsFinder
{
    /**
     * File for work
     * @var array $inputFiles
     */
    protected $inputFile = '';

    /**
     * Words for search in files
     * @var array $wordsForSearch
     */
    protected $wordsForSearch = [];

    /**
     * Regular expression for search
     * @var string $regexp
     */
    protected $regexp = '';

    /**
     * WordsFinder constructor.
     * @param string $inputFile
     * @param array $wordsForSearch
     */
    public function __construct(array $wordsForSearch, $inputFile)
    {
        $this->setInputFile($inputFile);
        $this->setWordsForSearch($wordsForSearch);

        $this->createRegexFromWords();
    }

    /**
     * Get input files
     * @return array
     */
    final public function getInputFiles()
    {
        return $this->inputFile;
    }

    /**
     * Set input file
     * @param array $inputFile
     */
    final public function setInputFile($inputFile)
    {
        if (!file_exists($inputFile)) {
            throw new FileNotFoundException(sprintf('File "%s" could not be found.', $inputFile));
        }

        $this->inputFiles = $inputFile;
    }

    /**
     * Get words for search
     * @return array
     */
    final public function getWordsForSearch()
    {
        return $this->wordsForSearch;
    }

    /**
     * Set words for search
     * @param array $wordsForSearch
     */
    final public function setWordsForSearch(array $wordsForSearch)
    {
        if (count($wordsForSearch) <= 0) {
            throw new \InvalidArgumentException("Words for search cant be empty");
        }

        $this->wordsForSearch = $wordsForSearch;

        $this->createRegexFromWords();
    }

    /**
     * Load text file to variable
     * @param string $fileName
     * @return string
     */
    private function loadText($fileName)
    {
        if (!file_exists($fileName)) {
            throw new FileNotFoundException(sprintf('File "%s" could not be found.', $fileName));
        }

        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        /**
         * @var ConverterInterface $converter ;
         */
        $converter = FormatFactory::factory($fileExt);

        $text = strtolower($converter->getText($fileName));

        return $text;
    }

    /**
     * Create regex from words for search
     */
    private function createRegexFromWords()
    {
        if (count($this->wordsForSearch) <= 0) {
            throw new WordsFinderException('Words for search is empty');
        }

        $regexWords = strtolower(implode('|', $this->wordsForSearch));

        $this->regexp = "/\b($regexWords)\b/";
    }

    /**
     * Get count occurrences words in text
     * @param string $textForSearch
     * @return integer
     */
    public function proceedText($textForSearch)
    {
        $matches = [];
        $textForSearch = str_replace("\n", ' ', $textForSearch);
        $textForSearch = strtolower($textForSearch);
        $result = preg_match_all($this->regexp, $textForSearch, $matches);

        return $result;
    }

    /**
     * Get count searched words in file
     * @param string $fileName
     * @return array
     */
    public function proceedFile($fileName)
    {
        $returnResult = [];
        $textForSearch = $this->loadText($fileName);
        $matches = [];
        $fileShortName = basename($fileName);

        $result = $this->proceedText($textForSearch);
        if ($result) {
            $returnResult[$fileShortName]['text'] = $result;
        }

        return $returnResult;
    }
}