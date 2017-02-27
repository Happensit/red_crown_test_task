<?php

namespace RedCrown\Http;


/**
 * Class JsonResponse
 * @package RedCrown\Http
 */
class JsonResponse extends Response
{
    /**
     * @var
     */
    protected $data;

    public function __construct($data = null, $status = 200, $headers = [])
    {
        parent::__construct('', $status, $headers);

        if (null === $data) {
            $data = [];
        }

        $this->setJson($data);
        $this->setHeaders(['Content-Type', 'application/json']);
        $this->setContent($this->data);
    }

    public function setJson($data)
    {
        $this->data = json_encode(['status' => $this->getStatusCode()] + $data);

        return $this;
    }

}