<?php
namespace Core;

class Request 
{
    private $queryParams;

    public function __construct(array $POST, array $GET)
    {
        $this->setQueryParams(array_merge($POST, $GET));
    }

    public function setQueryParams(array $params)
    {
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $params[$key] = trim(stripslashes(htmlspecialchars($value)));
            }
        }
        $this->queryParams = $params;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }
}