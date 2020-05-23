<?php


if (!function_exists('named_route_info')) {

    /**
     * Return the info for a given route.
     *
     * @param $name
     * @param $parameters
     *
     * @return array
     *
     * @throws Exception
     */
    function named_route_info($name, $parameters = []): array
    {
        $info = app('router')->getRoutes()->getByName($name);

        if (!$info) {
            throw new Exception("Unable to locate route by alias '{$name}'");
        }

        return [
            'url'    => route($name, $parameters),
            'method' => strtolower($info->methods[0]),
        ];
    }
}


if (!function_exists('named_route_info_json')) {

    /**
     * JSON encode results from named_route_info_json()
     *
     * @param $name
     * @param $parameters
     *
     * @return string
     *
     * @throws Exception
     */
    function named_route_info_json($name, $parameters = []): string
    {
        return json_encode(named_route_info($name, $parameters));
    }
}
