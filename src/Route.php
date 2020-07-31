<?php
declare(strict_types=1);

namespace FastD\FastRoute;


/**
 * Class Route
 * @package FastD\FastRoute
 */
class Route
{

    private const DEFAULT_CALLBACK = 'handle';

    /**
     * @var array
     */
    public array $parameters = [];

    /**
     * @var string
     */
    public string $method = 'GET';

    /**
     * @var string
     */
    public string $handler;

    /**
     * @var array
     */
    public array $middlewares = [];

    /**
     * @var array
     */
    public array $variables;

    /**
     * Route constructor.
     * @param string $method
     * @param string $handler
     * @param array $variables
     * @param array $middlewares
     * @param array $parameters
     */
    public function __construct(string $method, string $handler, array $variables, array $middlewares = [], array $parameters = [])
    {
        $this->method = $method;
        $this->handler = $handler;
        $this->middlewares = $middlewares;
        $this->parameters = $parameters;
        $this->variables = $variables;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }


    public function handler()
    {
        if (false === strstr($this->handler, '@')) {
            return call_user_func(array(new $this->handler, self::DEFAULT_CALLBACK), $this->variables, $this->parameters);
        }

        [$class, $callback] = explode('@', $this->handler);
        return call_user_func(array(new $class, $callback), $this->variables, $this->parameters);
    }
}
