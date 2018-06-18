<?php

namespace Tests\FFMpeg\Unit\Media;

abstract class AbstractStreamableTestCase extends AbstractMediaTestCase
{
    public function testGetStreams()
    {
        $classname = $this->getClassName();
        $ffprobe = $this->getFFProbeMock();
        $format = $this->getFormatMock();

        $ffprobe->expects($this->once())
            ->method('format')
            ->with(__FILE__)
            ->will($this->returnValue($format));

        $media = new $classname(__FILE__, $this->getFFMpegDriverMock(), $ffprobe);
        $this->assertSame($format, $media->getFormat());
    }

    public function testGetFormat()
    {
        $classname = $this->getClassName();
        $ffprobe = $this->getFFProbeMock();
        $streams = $this->getStreamCollectionMock();

        $ffprobe->expects($this->once())
            ->method('streams')
            ->with(__FILE__)
            ->will($this->returnValue($streams));

        $media = new $classname(__FILE__, $this->getFFMpegDriverMock(), $ffprobe);
        $this->assertSame($streams, $media->getStreams());
    }

    public function testGetInputOptions()
    {
        $classname = $this->getClassName();
        $ffprobe = $this->getFFProbeMock();

        $media = new $classname(__FILE__, $this->getFFMpegDriverMock(), $ffprobe);

        $inputOptions = array('-noautorotate');
        $media->setInputOptions($inputOptions);

        $this->assertEquals($inputOptions, $media->getInputOptions());
    }

    abstract protected function getClassName();
}
