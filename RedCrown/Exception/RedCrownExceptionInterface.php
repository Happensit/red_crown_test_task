<?php

namespace RedCrown\Exception;

/**
 * Interface RedCrownExceptionInterface
 * @package RedCrown\Exception
 */
interface RedCrownExceptionInterface
{

    /**
     * @return mixed
     */
    public function getStatusCode();

}