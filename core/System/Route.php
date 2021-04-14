<?php
/*
 * Copyright (c) 2021. Boulatar Oualid - All Rights Reserved
 *  You may use, distribute and modify this code under the
 *  terms of the LGP license, which unfortunately won't be
 *  written for another century.
 *
 *  You should have received a copy of the LGP license with
 *  this file. If not, please write to:  oualid@boulatar.com, or visit : https://boulatar.com
 */

namespace System;

class Route
{
    /**
     * Application Object
     *
     * @var Application
     */
    private Application $app;

    /**
     * Routes Container
     *
     * @var array
     */
    private array $routes = [];

    /**
     * Current route
     *
     * @var array
     */
    private array $current = [];

    /**
     * Not found Url
     *
     * @var string|null
     */
    private ?string $notFound = '/404';

    /**
     *Calls Container
     *
     * @var array
     */
    private array $calls = [];

    /**
     * Constructor
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get All routes
     *
     * @return array
     */
    public function routes(): array
    {
        return $this->routes;
    }

    /**
     * Add new Route
     *
     * @param  string  $url
     * @param  string  $action
     * @param  string  $requestMethod  $_POST or $_GET
     *
     * @return void
     */
    public function add(string $url, string $action,string $requestMethod = 'GET'): void
    {
        $route = [
            'url'        => $url,
            'pattern'    => $this->generatePattern($url),
            'action'     => $this->getAction($action),
            'method'     => strtoupper($requestMethod),
        ];
        $this->routes[] = $route;
    }

    /**
     * Generate a regex pattern for the given url
     *
     * @param  string $url
     *
     * @return string
     */
    private function generatePattern(string $url): string
    {
        $pattern = '#^';
        $pattern .= str_replace([':text', ':id'], ['([a-zA-Z0-9-]+)', '(\d+)'], $url);

        return $pattern . '$#';
    }

    /**
     * Get the proper action = the controller's method
     *
     * @param  string $action
     *
     * @return string
     */
    private function getAction(string $action): string
    {
        $action = str_replace('/', '\\', $action);

        return strpos($action, '@') !== false ? $action : $action . '@index';
    }

    /**
     * Set not Found Url
     *
     * @param  string $url
     *
     * @return void
     */
    public function notFound(string $url): void
    {
        $this->notFound = $url;
    }

    /**
     * Call the given callback before calling the main controller
     *
     * @var callable $callable
     *
     * @return self
     */

    public function callFirst(callable $callable): self
    {
        $this->calls['first'][] = $callable;

        return $this;
    }

    /**
     * Determine if there are any callbacks that will be called before calling the main controller
     *
     * @return boolean
     */
    public function hasCallsFirst(): bool
    {
        return !empty($this->calls['first']);
    }

    /**
     * Call All callbacks that will be called before calling the main controller
     *
     * @return bool
     */
    public function callFirstCalls(): bool
    {
        foreach ($this->calls['first'] as $callback) {
            call_user_func($callback, $this->app);
        }
    }

    /**
     * Get proper route
     *
     * @return array
     */
    public function getProperRoute(): array
    {
        foreach ($this->routes as $route ) {
            if ($this->isMatching($route['pattern']) && $this->isMatchingRequestMethod($route['method'])) {
                $arguments = $this->getArgumentsFrom($route['pattern']);
                // controller@method
                [$controller, $method] = explode('@', $route['action']);

                $this->current = $route;

                return [$controller, $method, $arguments];
            }
        }

        return $this->app->url->redirectTo($this->notFound);
    }

    /**
     * Get current route Url
     */
    public function getCurrentRouteUrl(): string
    {
        return $this->current['url'];
    }

    /**
     * Determine if the given pattern matches the current request url
     *
     * @param  string  $pattern
     *
     * @return boolean
     */
    private function isMatching(string $pattern): bool
    {
        return preg_match($pattern, $this->app->request->url());
    }

    /**
     * Determine if the given current request method equals the given route method
     *
     * @param  string  $routeMethod
     *
     * @return boolean
     */
    private function isMatchingRequestMethod(string $routeMethod): bool
    {
        return $routeMethod == $this->app->request->method();
    }

    /**
     * Get Arguments from the current request url based on the given pattern
     *
     * @param  string $pattern
     *
     * @return array
     */
    private function getArgumentsFrom(string $pattern): array
    {
        preg_match($pattern, $this->app->request->url(), $matches);
        array_shift($matches);

        return $matches;
    }
}