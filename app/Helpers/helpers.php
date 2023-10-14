<?php

use App\Models\Category;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\Link;

if (!function_exists('apiResponse')) {
    function apiResponse($message = null, $status = 200, $data = null)
    {
        return response()->json(['message' => $message, 'data' => $data, 'status' => $status], $status);
    }
}


if (!function_exists('imageExist')) {
    function imageExist(string|null $imagePath, string $defaultImagePath): string
    {
        if (!file_exists(public_path($imagePath)) || is_null($imagePath)) {
            $imagePath = $defaultImagePath;
        }
        return asset($imagePath);
    }
}

if (!function_exists('getMoneyTypeChange')) {
    function getMoneyTypeChange($price): float
    {
        return str_replace(",", ".", str_replace(".", "", $price));
    }
}

if (!function_exists('getMoneyFormat')) {
    function getMoneyFormat($price = null, string $type = "tr")
    {
        if ($type == "tr")
            return number_format($price, 2, ',', '.');
        else
            return number_format($price, 2, '.', '');
    }
}

function getCategories()
{
    $categories = Category::where("status", 1)->get();

    $allCategories = new stdClass();
    foreach ($categories as $item_category) {
        if ($item_category->parent_id) {
            $allCategories['child'] = $item_category;
        } else {
            $allCategories = $item_category;
        }
    }

    return $categories;
}


function buildTree($elements, $parentId = null)
{
    $data = array();
    // $data = new stdClass();
    foreach ($elements as $element) {
        if ($element->parent_id == $parentId) {
            $children = buildTree($elements, $element->id);
            if ($children) {
                $element->children = $children;
            } else {
                $element->children = array();
                // $element->children = new stdClass();
            }
            $data[] = $element;
            // $data = $element;
        }
    }
    return $data;
}

function drawElements($items)
{
    foreach ($items as $item) {
        if (empty($item->children)) {
            echo "<li><a class='' href='" . route("front.show", ['slug' => $item->slug]) . "'>{$item->name}</a></li>";
        } else {
            echo "<li class='nav-item dropdown'>";
            echo "<a href='asdasdas' class='dropdown-toggle' data-toggle='dropdown'>{$item->name}</a>";

            echo "<ul>";
            if (sizeof($item->children) > 0) {
                drawElements($item->children);
            }
            echo "</ul></li>";
        }
    }
}


function drawElements___($items, &$menu = null)
{
    foreach ($items as $item) {
        if (empty($item->children)) {
            $menu = Menu::new()->link(route('front.show', ['slug' => $item->slug]), $item->name);
        } else {
            $menu->add(Menu::new()->link(route('front.show', ['slug' => $item->slug]), $item->name));

            if (sizeof($item->children) > 0) {
                drawElements($item->children, $menu);
            }
        }
    }

    return $menu;
}

function drawElements_asil($items, &$count = 0)
{
    // $count = 0;
    foreach ($items as $key => $item) {

        echo str_repeat("-", $count) . " " . $item->name . "<br>";

        if (sizeof($item->children) > 0) {
            $count++;
            drawElements($item->children, $count);
        }
    }
}
