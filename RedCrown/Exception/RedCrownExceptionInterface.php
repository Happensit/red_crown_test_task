<?php

namespace RedCrown\Exception;

/**
 * Interface RedCrownExceptionInterface
 * @package RedCrown\Exception
 */
interface RedCrownExceptionInterface
{
    /**
     * @return integer
     */
    public function getStatusCode();
}
