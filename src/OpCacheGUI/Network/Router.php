<?php
/**
 * All requests are directed through this class and runs to correct route
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    Network
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2014 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\Network;

/**
 * All requests are directed through this class and runs to correct route
 *
 * @category   OpCacheGUI
 * @package    Network
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Router
{
    /**
     * @var int The types of URIs used by the system
     */
    const URL_REWRITE  = 1;
    const QUERY_STRING = 2;

    /**
     * @var \OpCacheGUI\Network\RequestData Instance of a request class
     */
    private $request;

    /**
     * @var \OpCacheGUI\Network\RouteBuilder The route factory
     */
    private $routeFactory;

    /**
     * @var int The type of the identifiers in URLs
     */
    private $identifierType;

    /**
     * @var array List of available routes
     */
    private $routes = [];

    /**
     * Creates instance
     *
     * @param \OpCacheGUI\Network\RequestData  $request        Instance of a request class
     * @param \OpCacheGUI\Network\RouteBuilder $routeFactory   Instance of a route builder
     * @param int                              $identifierType The type of URIs used by the system
     */
    public function __construct(RequestData $request, RouteBuilder $routeFactory, $identifierType = self::URL_REWRITE)
    {
        $this->request        = $request;
        $this->routeFactory   = $routeFactory;
        $this->identifierType = $identifierType;
    }

    /**
     * Adds a post route to the collection
     *
     * @param string   $identifier The identifier of this route
     * @param callable $callback   The callback to execute when this route matches
     */
    public function post($identifier, callable $callback)
    {
        $this->routes[] = $this->routeFactory->build($identifier, 'POST', $callback);
    }

    /**
     * Adds a get route to the collection
     *
     * @param string   $identifier The identifier of this route
     * @param callable $callback   The callback to execute when this route matches
     */
    public function get($identifier, callable $callback)
    {
        $this->routes[] = $this->routeFactory->build($identifier, 'GET', $callback);
    }

    /**
     * Finds the matching route and runs the callback on it
     *
     * @return mixed The result of the callback
     */
    public function run()
    {
        foreach ($this->routes as $route) {
            if (!$route->matchesRequest($this->getIdentifier(), $this->request->getVerb())) {
                continue;
            }

            return $route->run();
        }

        return $this->getMainPage();
    }

    /**
     * Gets the identifier of the current request
     *
     * @return string The identifier of the current request
     */
    public function getIdentifier()
    {
        if ($this->identifierType === self::URL_REWRITE) {
            return $this->request->path();
        }

        return $this->request->get();
    }

    /**
     * Gets the main page (either the status page or the login page)
     *
     * @return mixed The result of the callback
     */
    private function getMainPage()
    {
        foreach ($this->routes as $route) {
            if (!$route->matchesRequest('', 'GET')) {
                continue;
            }

            return $route->run();
        }
    }
}
