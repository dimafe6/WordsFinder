<?php

namespace WordsFinder;

use FileConverter\ConverterInterface;
use FileConverter\FormatFactory;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use WordsFinder\Exception\WordsFinderException;

abstract class WordsFinder
{
    /**
     * Files for work
     * @var array $inputFiles
     */
    protected $inputFiles = [];

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
     * @param array $inputFiles
     * @param array $wordsForSearch
     */
    public function __construct(array $wordsForSearch, array $inputFiles = [])
    {
        $this->setInputFiles($inputFiles);
        $this->setWordsForSearch($wordsForSearch);

        $this->createRegexFromWords();
    }

    /**
     * Get input files
     * @return array
     */
    public function getInputFiles()
    {
        return $this->inputFiles;
    }

    /**
     * Set input files
     * @param array $inputFiles
     */
    public function setInputFiles(array $inputFiles)
    {
        $this->inputFiles = $inputFiles;
    }

    /**
     * Get words for search
     * @return array
     */
    public function getWordsForSearch()
    {
        return $this->wordsForSearch;
    }

    /**
     * Set words for search
     * @param array $wordsForSearch
     */
    public function setWordsForSearch(array $wordsForSearch)
    {
        if (count($wordsForSearch) <= 0) {
            throw new \InvalidArgumentException("Words for search cant be empty");
        }

        $this->wordsForSearch = $wordsForSearch;
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

        $result = preg_match_all($this->regexp, $textForSearch, $matches);

        if ($result) {
            $returnResult = isset($matches[0]) ? [$fileShortName => $result] : [];
        }

        return $returnResult;
    }

    public function proceedAllFiles()
    {
        if (count($this->inputFiles) <= 0) {
            throw new \InvalidArgumentException("Input files cant be empty. Use the setInputFiles");
        }

        $result = [];
        foreach ($this->inputFiles as $inputFile) {
            $result = array_merge($result, $this->proceedFile($inputFile));
        }

        return $result;
    }
}