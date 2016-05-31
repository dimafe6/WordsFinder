<?php

namespace WordsFinder\WordsFinderTests;

use WordsFinder\StopWordsFinder;

class WordsFinderTests extends \PHPUnit_Framework_TestCase
{
    private $stopWords = ['aliquet', 'ipsum', 'Sharm'];

    private $searchFiles = [
        __DIR__ . '/testFiles/testFile.txt',
        __DIR__ . '/testFiles/testFile1.txt',
        __DIR__ . '/testFiles/testFile2.txt',
    ];

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateWordsFinder()
    {
        $wf = new StopWordsFinder([], []);
    }

    public function testProceedFile()
    {
        $assertResult = [
            'testFile.txt' => 3
        ];

        $swf = new StopWordsFinder($this->stopWords);
        $result = $swf->proceedFile($this->searchFiles[0]);

        $this->assertEquals($assertResult, $result);
    }

    public function testDocx()
    {
        $assertResult = [
            'test.docx' => 3
        ];

        $swf = new StopWordsFinder($this->stopWords);
        $result = $swf->proceedFile(__DIR__ . '/testFiles/test.docx');


        $this->assertEquals($assertResult, $result);
    }

    public function testDoc()
    {
        $assertResult = [
            'test.doc' => 3
        ];

        $swf = new StopWordsFinder($this->stopWords);
        $result = $swf->proceedFile(__DIR__ . '/testFiles/test.doc');


        $this->assertEquals($assertResult, $result);
    }

    public function testPdf()
    {
        $assertResult = [
            'test.pdf' => 3
        ];

        $swf = new StopWordsFinder($this->stopWords);
        $result = $swf->proceedFile(__DIR__ . '/testFiles/test.pdf');

        $this->assertEquals($assertResult, $result);
    }

    public function testXls()
    {
        $assertResult = [
            'test.xls' => 3
        ];

        $swf = new StopWordsFinder($this->stopWords);
        $result = $swf->proceedFile(__DIR__ . '/testFiles/test.xls');

        $this->assertEquals($assertResult, $result);
    }

    public function testXlsx()
    {
        $assertResult = [
            'test.xlsx' => 3
        ];

        $swf = new StopWordsFinder($this->stopWords);
        $result = $swf->proceedFile(__DIR__ . '/testFiles/test.xlsx');

        $this->assertEquals($assertResult, $result);
    }

    public function testXlt()
    {
        $assertResult = [
            'test.xlt' => 3
        ];

        $swf = new StopWordsFinder($this->stopWords);
        $result = $swf->proceedFile(__DIR__ . '/testFiles/test.xlt');

        $this->assertEquals($assertResult, $result);
    }

    public function testXlsm()
    {
        $assertResult = [
            'test.xlsm' => 3
        ];

        $swf = new StopWordsFinder($this->stopWords);
        $result = $swf->proceedFile(__DIR__ . '/testFiles/test.xlsm');

        $this->assertEquals($assertResult, $result);
    }

    public function testXltx()
    {
        $assertResult = [
            'test.xltx' => 3
        ];

        $swf = new StopWordsFinder($this->stopWords);
        $result = $swf->proceedFile(__DIR__ . '/testFiles/test.xltx');

        $this->assertEquals($assertResult, $result);
    }

    public function testXltm()
    {
        $assertResult = [
            'test.xltm' => 3
        ];

        $swf = new StopWordsFinder($this->stopWords);
        $result = $swf->proceedFile(__DIR__ . '/testFiles/test.xltm');

        $this->assertEquals($assertResult, $result);
    }

    public function testOds()
    {
        $assertResult = [
            'test.ods' => 3
        ];

        $swf = new StopWordsFinder($this->stopWords);
        $result = $swf->proceedFile(__DIR__ . '/testFiles/test.ods');

        $this->assertEquals($assertResult, $result);
    }

    public function testSlk()
    {
        $assertResult = [
            'test.slk' => 2
        ];

        $swf = new StopWordsFinder($this->stopWords);
        $result = $swf->proceedFile(__DIR__ . '/testFiles/test.slk');

        $this->assertEquals($assertResult, $result);
    }

    public function testXml()
    {
        $assertResult = [
            'test.xml' => 1
        ];

        $swf = new StopWordsFinder($this->stopWords);
        $result = $swf->proceedFile(__DIR__ . '/testFiles/test.xml');

        $this->assertEquals($assertResult, $result);
    }

    public function testPptx()
    {
        $assertResult = [
            'test.ppsx' => 2
        ];

        $swf = new StopWordsFinder($this->stopWords);
        $result = $swf->proceedFile(__DIR__ . '/testFiles/test.ppsx');

        $this->assertEquals($assertResult, $result);

    }

    public function testProceedAllFiles()
    {
        $assertResult = [
            'testFile.txt' => 3,
            'testFile1.txt' => 15,
            'testFile2.txt' => 6,
            'test.xls' => 3,
            'test.xml' => 1,
            'test.xlsm' => 3,
            'test.xlt' => 3,
            'test.docx' => 3,
            'test.rtf' => 3,
            'test.xltm' => 3,
            'test.ods' => 3,
            'test.ppsx' => 2,
            'test.pdf' => 3,
            'test.xltx' => 3,
            'test.slk' => 2,
            'test1.pptx' => 2,
            'test.xlsx' => 3,
            'test.doc' => 3
        ];

        $searchFiles = [];
        $handle = opendir(__DIR__ . '/testFiles');

        while ($entry = readdir($handle)) {
            if ($entry != "." && $entry != "..") {
                $searchFiles[] = __DIR__ . '/testFiles/' . $entry;
            };
        }
        closedir($handle);

        $swf = new StopWordsFinder($this->stopWords, $searchFiles);
        $result = $swf->proceedAllFiles();

        $this->assertEquals($assertResult, $result);
        echo "\n";
        print_r($result);
    }
}
