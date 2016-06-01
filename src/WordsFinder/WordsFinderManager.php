<?php

namespace WordsFinder;

final class WordsFinderManager
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

    public function __construct(array $wordsForSearch, array $inputFiles)
    {
        $this->setInputFiles($inputFiles);
        $this->setWordsForSearch($wordsForSearch);
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
        if (count($inputFiles) <= 0) {
            throw new \InvalidArgumentException("Input files cant be empty");
        }

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

    public function run()
    {
        $result = [];
        foreach ($this->inputFiles as $inputFile) {
            /**
             * @var AbstractWordsFinder $finder
             */
            $finder = WordsFinderFactory::factory($this->wordsForSearch,$inputFile);
            $result = array_merge($result, $finder->proceedFile($inputFile));
        }

        return $result;
    }
}