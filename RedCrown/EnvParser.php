<?php

namespace RedCrown;

use RedCrown\Exception\ConfigureApplicationException;
use RedCrown\Reader\FileReaderFactory;

/**
 * Class EnvParser
 * @package RedCrown
 */
class EnvParser
{
    /**
     * @var string
     */
    private $envFile;

    /**
     * EnvParser constructor.
     * @param $filePath
     * @param string $envFile
     */
    public function __construct($filePath, $envFile = '.env')
    {
        $this->envFile = $filePath . DIRECTORY_SEPARATOR . $envFile;
    }

    public function parse()
    {
        $envContentToArray = FileReaderFactory::getFile($this->envFile);
        if (empty($envContentToArray)) {
            throw new ConfigureApplicationException(sprintf("No config lines in %s file", $this->envFile));
        }

        foreach ($envContentToArray as $envLine) {
            if (strrpos($envLine, '#', -strlen($envLine)) !== false) {
                continue;
            }

            putenv($envLine);
        }

    }
}
