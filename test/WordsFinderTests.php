<?php

namespace WordsFinder\WordsFinderTests;

use WordsFinder\DefaultWordsFinder;
use WordsFinder\WordsFinderManager;

class WordsFinderTests extends \PHPUnit_Framework_TestCase
{
    private $stopWords = ['aliquet', 'ipsum', 'Sharm', 'elementum', 'that', 'fly'];

    private $searchFiles = [
        __DIR__ . '/testFiles/testFile.txt',
        __DIR__ . '/testFiles/testFile1.txt',
        __DIR__ . '/testFiles/testFile2.txt',
    ];

    private function getSearchFiles()
    {
        $searchFiles = [];
        $handle = opendir(__DIR__ . '/testFiles');

        while ($entry = readdir($handle)) {
            if ($entry != "." && $entry != "..") {
                $searchFiles[] = __DIR__ . '/testFiles/' . $entry;
            };
        }
        closedir($handle);

        return $searchFiles;
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateWordsFinder()
    {
        $wfm = new WordsFinderManager($this->stopWords, []);
    }

    public function testProceedFile()
    {
        $swf = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/testFile.txt']);
        $result = $swf->run();

        $this->assertArrayHasKey('testFile.txt', $result);
        $this->assertArrayHasKey('text', $result['testFile.txt']);
        $this->assertEquals(4, $result['testFile.txt']['text']['count']);
    }

    public function testDocx()
    {
        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.docx']);
        $result = $wfm->run();

        $this->assertArrayHasKey('test.docx', $result);
    }

    public function testDoc()
    {
        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.doc']);
        $result = $wfm->run();

        $this->assertArrayHasKey('test.doc', $result);
    }

    public function testPdf()
    {
        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.pdf']);
        $result = $wfm->run();

        $this->assertArrayHasKey('test.pdf', $result);
    }

    public function testXls()
    {
        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.xls']);
        $result = $wfm->run();

        $this->assertArrayHasKey('test.xls', $result);
    }

    public function testXlsx()
    {
        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.xlsx']);
        $result = $wfm->run();

        $this->assertArrayHasKey('test.xlsx', $result);
    }

    public function testXlt()
    {
        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.xlt']);
        $result = $wfm->run();

        $this->assertArrayHasKey('test.xlt', $result);
    }

    public function testXlsm()
    {
        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.xlsm']);
        $result = $wfm->run();

        $this->assertArrayHasKey('test.xlsm', $result);
    }

    public function testXltx()
    {
        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.xltx']);
        $result = $wfm->run();

        $this->assertArrayHasKey('test.xltx', $result);
    }

    public function testXltm()
    {
        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.xltm']);
        $result = $wfm->run();

        $this->assertArrayHasKey('test.xltm', $result);
    }

    public function testOds()
    {
        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.ods']);
        $result = $wfm->run();

        $this->assertArrayHasKey('test.ods', $result);
    }

    public function testSlk()
    {
        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.slk']);
        $result = $wfm->run();

        $this->assertArrayHasKey('test.slk', $result);
    }

    public function testXml()
    {
        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.xml']);
        $result = $wfm->run();

        $this->assertArrayHasKey('test.xml', $result);
    }

    public function testPptx()
    {
        $wfm = new WordsFinderManager($this->stopWords, [__DIR__ . '/testFiles/test.ppsx']);
        $result = $wfm->run();

        $this->assertArrayHasKey('test.ppsx', $result);

    }

    public function testProceedAllFiles()
    {
        $assertResult = [
            'testFile1.txt',
            'test.xls' ,
            'test.xml',
            'test.xlsm',
            'test.xlt',
            'test.docx',
            'test.rtf',
            'testFile2.txt',
            'test.xltm',
            'testFile.txt',
            'test.ods',
            'test.ppsx',
            'test.pdf',
            'test.xltx',
            'test.slk',
            'test1.pptx',
            'test.xlsx',
            'test.doc'
        ];


        $wfm = new WordsFinderManager($this->stopWords, $this->getSearchFiles());
        $result = $wfm->run();
        $this->assertEquals($assertResult, array_keys($result));
        echo "\n";
        print_r($result);
    }
}
