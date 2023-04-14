<?php

namespace Halimzidoune\LaravelPostmanApi\FileBuilder;

use Halimzidoune\LaravelPostmanApi\Classes\Folder;
use Illuminate\Routing\Route;

class PostmanCollectionBuilder
{
    public function initPostmanStructure($collection_name)
    {
        $result =
            [
                'info' => [
                    '_postman_id' => uniqid(),
                    'name' => $collection_name,
                    'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json',
                ],
                'item' => [],
                'variable' => [
                    [
                        'key' => 'base_url',
                        'value' => config('postman-api.base_url') ?? 'http://localhost:8000',
                        'type' => 'default',
                    ],
                    [
                        'key' => 'token',
                        'value' => 'your_token',
                        'type' => 'default',
                    ],
                ],
            ];

        return $result;
    }

    public function build(Folder $folder)
    {

        $requests = [];
        foreach ($folder->getRequests() as $request) {
            $requests[] = $this->buildRequestNode($request->getRoute(), $request->getName());
        }

        $folders = [];
        foreach ($folder->getFolders() as $sub_folder) {

            $folders[] = $this->build($sub_folder);

        }

        return [
            'name' => $folder->getName(),
            'item' => array_merge($requests, $folders),
        ];

    }

    protected function buildRequestNode(Route $route, $request_name)
    {

        $full_url = '{{base_url}}/'.$route->uri;
        $middlewares = $route->action['middleware'];

        $fields = $this->getRequestFieldsOfRoute($route);

        $auth = [
            'type' => 'bearer',
            'bearer' => [
                [
                    'key' => 'token',
                    'value' => '{{token}}',
                    'type' => 'string',
                ],
            ],
        ];

        $method = $route->methods[0];

        $request = [
            'auth' => $auth,
            'method' => $method,
            'header' => [],
            'body' => [],
            'url' => [
                'raw' => $full_url,
                'host' => [
                    '{{base_url}}',
                ],
                'path' => [
                    $route->uri,
                ],
            ],
        ];

        if (in_array($method, ['POST', 'PUT'])) {
            $form = [];

            if ($method == 'PUT') {
                $form[] = [
                    'key' => '_method',
                    'value' => 'PUT',
                    'type' => 'default',
                ];
            }
            foreach ($fields as $field) {
                $form[] = [
                    'key' => $field,
                    'value' => 'test',
                    'type' => 'default',
                ];
            }

            $request['body'] = [
                'mode' => 'formdata',
                'formdata' => $form,
            ];

        }

        return [
            'name' => ucfirst(strtolower($method)).' '.$request_name,
            'request' => $request,
            'response' => [],
        ];
    }

    protected function getRequestFieldsOfRoute(Route $route)
    {
        if (in_array('POST', $route->methods) && array_key_exists('controller', $route->action)) {

            $controller = explode('@', $route->action['controller']);

            if (count($controller) == 2) {
                $controllerClass = $controller[0];
                $function = $controller[1];

                // app($controllerClass); usefull to used services service

                $controllerMethos = new \ReflectionMethod($controllerClass, $function);
                $params = $controllerMethos->getParameters();

                foreach ($params as $p) {
                    if ($p instanceof \ReflectionParameter) {
                        $type = $p->getType();

                        if ($type != null) {
                            $parent = $p->getClass() ? $p->getClass()->getParentClass() : null;
                            if ($parent instanceof \ReflectionClass) {
                                if ($p->getClass()->getParentClass()->getName() == "Illuminate\Foundation\Http\FormRequest") {
                                    $requestClass = $type->getName();

                                    try {
                                        $request = new $requestClass();
                                        $rules = $request->rules();

                                        return array_keys($rules);
                                    } catch (\Exception $e) {

                                    }

                                }
                            }
                        }
                    }
                }
            } else {
                // no action
            }
        } else {
            // no controller
        }

        return [];
    }
}
