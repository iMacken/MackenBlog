<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany('App\MenuItem');
    }

    public function parent_items()
    {
        return $this->hasMany('App\MenuItem')
            ->whereNull('parent_id');
    }

    /**
     * Display menu.
     *
     * @param string      $menuName
     * @param string|null $type
     * @param array       $options
     *
     * @return string
     */
    public static function display($menuName, $type = null, array $options = [])
    {
        // GET THE MENU - sort collection in blade
        $menu = static::where('name', '=', $menuName)
            ->with('parent_items.children')
            ->first();

        // Check for Menu Existence
        if (!isset($menu)) {
            return false;
        }

        event('macken.menu.display', $menu);

        // Convert options array into object
        $options = (object) $options;

        if (!isset($options->locale)) {
            $options->locale = app()->getLocale();
        }

        return new \Illuminate\Support\HtmlString(
            \Illuminate\Support\Facades\View::make('menu.type.' . $type, ['items' => $menu->parent_items, 'options' => $options])->render()
        );
    }
}
