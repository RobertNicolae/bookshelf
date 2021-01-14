<?php


namespace LightFramework\Http;


use LightFramework\DataStructure\ArrayCollection;

class Request
{
    public const METHOD_GET = "GET", METHOD_POST = "POST";

    /**
     * Request body parameters ($_POST)
     *
     * @var ArrayCollection
     */
    protected ArrayCollection $requestParams;

    /**
     * Query string parameters ($_GET)
     *
     * @var ArrayCollection
     */
    protected ArrayCollection $queryParams;

    /**
     * Custom parameters
     *
     * @var ArrayCollection
     */
    protected ArrayCollection $attributes;

    /**
     * Server and execution environment parameters ($_SERVER)
     *
     * @var ArrayCollection
     */
    protected ArrayCollection $serverParams;

    /**
     * Uploaded files ($_FILES).
     *
     * @var ArrayCollection
     */
    protected ArrayCollection $filesParams;

    /**
     * Cookies ($_COOKIE).
     *
     * @var ArrayCollection
     */
    protected ArrayCollection $cookiesParams;

    /**
     * Session (from $_SESSION)
     *
     * @var ArrayCollection
     */
    protected ArrayCollection $session;


    /**
     * Request constructor.
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param array $session
     */
    protected function __construct(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        array $session = []
    )
    {
        $this->queryParams = new ArrayCollection($query);
        $this->requestParams = new ArrayCollection($request);
        $this->attributes = new ArrayCollection($attributes);
        $this->cookiesParams = new ArrayCollection($cookies);
        $this->filesParams = new ArrayCollection($files);
        $this->serverParams = new ArrayCollection($server);
        $this->session = new ArrayCollection($session);
    }

    /**
     * @return Request
     */
    public static function createFromGlobals(): self
    {
        return new static($_GET, $_REQUEST, $_POST, $_COOKIE, $_FILES, $_SERVER, $_SESSION);
    }

    /**
     * @return ArrayCollection
     */
    public function getRequestParams(): ArrayCollection
    {
        return $this->requestParams;
    }

    /**
     * @return ArrayCollection
     */
    public function getQueryParams(): ArrayCollection
    {
        return $this->queryParams;
    }

    /**
     * @return ArrayCollection
     */
    public function getAttributes(): ArrayCollection
    {
        return $this->attributes;
    }

    /**
     * @return ArrayCollection
     */
    public function getServerParams(): ArrayCollection
    {
        return $this->serverParams;
    }

    /**
     * @return ArrayCollection
     */
    public function getFilesParams(): ArrayCollection
    {
        return $this->filesParams;
    }

    /**
     * @return ArrayCollection
     */
    public function getCookiesParams(): ArrayCollection
    {
        return $this->cookiesParams;
    }

    /**
     * @return ArrayCollection
     */
    public function getSession(): ArrayCollection
    {
        return $this->session;
    }

    public function isMethod(string $method): bool
    {
        return $this->serverParams->get('REQUEST_METHOD') === $method;
    }
}