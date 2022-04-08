<?php

namespace App\appLogic;

use App\Models\Route;
use App\Models\Time;

class SearchLogic
{
    public function __construct($cities, $nCitiesBetween = 2)
    {
        $this->cities = $cities;
        $this->maxDepth = $nCitiesBetween;
        $this->connections = [];
        $this->track = [];
        $this->connectedCities = [];
        $this->connectedCitiesTimes = [];

    }

    public static function getDirectConnections($cityA, $cityB)
    {
        $routes = Route::all();
        $routesToReturn = [];
        foreach($routes as $route)
        {
            if(strtolower($route->cityFrom) == strtolower($cityA) && strtolower($route->cityTo) == strtolower($cityB))
            {
                $routesToReturn[] = $route;
            }
        }
        return collect($routesToReturn);
    }

    public static function getTimeById($timeId)
    {
        $times = Time::all();
        foreach($times as $time)
        {
            if($time->id == $timeId)
            {
                return $time;
            }
        }
        return null;
    }

    public function getIndirectConnections($cityA, $cityB, $depth = 0, $timesList = [])
    {
        $this->getConnectedCities($cityA);
        $connectedCities = $this->connectedCities;
        $connectedCitiesTimes = $this->connectedCitiesTimes;

        for($index = 0; $index<count($connectedCities); $index++)
        {
            if(strtolower($cityB) == $connectedCities[$index])
            {
                $this->connections[] = array_merge($this->track, [$cityB], TimeLogic::addTime(array_merge($timesList, [$connectedCitiesTimes[$index]])));
                return;
            }
        }
        if($depth == $this->maxDepth)
        {
            return;
        }
        for($index = 0; $index<count($connectedCities); $index++)
        {
            if(in_array($connectedCities[$index], $this->track))
            {
                continue;
            }
            $this->track[] = $connectedCities[$index];
            $this->getIndirectConnections($connectedCities[$index], $cityB, $depth + 1, array_merge($timesList, [$connectedCitiesTimes[$index]]));
            array_pop($this->track);
        }
        if($depth == 0)
        {
            for($index = 0; $index<count($this->connections); $index++)
            {
                array_unshift($this->connections[$index], $cityA);
            }
            return $this->connections;
        }
        array_pop($this->track);
    }

    public function getConnectedCities($cityA)
    {
        $connectedCities = [];
        $connectedCitiesTimes = [];
        foreach($this->cities as $city)
        {
            if(strtolower($city[0]) == strtolower($cityA))
            {
                $connectedCities[] = strtolower($city[1]);
                $connectedCitiesTimes[] = $city[2];
            }
        }
        $this->connectedCities = $connectedCities;
        $this->connectedCitiesTimes =$connectedCitiesTimes;
    }

    public static function getNeededColumns($list): array
    {
        $retList = [];
        foreach($list as $row)
        {
            $retList[] = [$row->cityFrom, $row->cityTo, $row->travelTime];
        }
        return $retList;
    }
}
