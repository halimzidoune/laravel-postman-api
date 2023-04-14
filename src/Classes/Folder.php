<?php

namespace Halimzidoune\LaravelPostmanApi\Classes;

use Illuminate\Routing\Route;

class Folder
{
    protected $folders = [];

    protected $requests = [];

    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getFolders(): array
    {
        return $this->folders;
    }

    public function getRequests(): array
    {
        return $this->requests;
    }

    public function addRoute(Route $route, $path)
    {
        $parts = explode('/', $path);
        if (count($parts) > 1) {
            $folder_name = $parts[0];
            $sub_path = implode('/', array_slice(explode('/', $path), 1));

            $folder = $this->getFolderByName($folder_name);
            if (! $folder) {
                $folder = $this->createFolder($folder_name);
            }
            $folder->addRoute($route, $sub_path);
        } else {
            // add Here
            $request = $this->createRequest($parts[0], $route);
        }

    }

    public function createRequest($name, Route $route)
    {
        $request = new PostmanRequest($name, $route);
        $this->requests[] = $request;

        return $request;
    }

    public function createFolder($name)
    {
        $folder = new Folder($name);
        $this->folders[] = $folder;

        return $folder;
    }

    public function getFolderByName($name)
    {
        $index = $this->getFolderIndex($name);
        if ($index >= 0) {
            return $this->folder($index);
        }

        return null;
    }

    public function getFolder($index)
    {
        return $this->folder($index);
    }

    public function folderExists($name)
    {
        return $this->getFolderIndex($name) >= 0;
    }

    public function getFolderIndex($name)
    {
        $i = 0;
        foreach ($this->folders as $folder) {
            if ($folder->name == $name) {
                return $i;
            }
            $i++;
        }

        return -1;
    }
}
