<?php

namespace RedCrown\Reader;


/**
 * Interface FileReaderInterface
 * @package RedCrown\Reader
 */
interface FileReaderInterface
{

    /**
     * Read from a file and create an array
     *
     * @param  string $filepath
     * @return array
     */
    public function asArray($filepath);

    /**
     * @param string $filepath
     * @return string
     */
    public function asString($filepath);

}