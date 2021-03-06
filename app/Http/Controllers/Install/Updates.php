<?php

namespace App\Http\Controllers\Install;

use App\Http\Controllers\Controller;
use App\Models\Module\Module as Model;
use App\Utilities\Updater;
use App\Utilities\Versions;
use Module;

class Updates extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function index()
    {
        $updates = Updater::all();

        $core = $updates['core'];

        $modules = array();

        $rows = Module::all();
        foreach ($rows as $row) {
            $alias = $row->get('alias');

            if (!isset($updates[$alias])) {
                continue;
            }

            $m = new \stdClass();
            $m->name = $row->get('name');
            $m->alias = $row->get('alias');
            $m->category = $row->get('category');
            $m->installed = $row->get('version');
            $m->latest = $updates[$alias];

            $modules[] = $m;
        }

        return view('install.updates.index', compact('core', 'modules'));
    }

    public function changelog()
    {
        return Versions::changelog();
    }

    public function update($alias, $version)
    {
        set_time_limit(600); // 10 minutes

        $status = Updater::update($alias, $version);

        // Clear cache in order to check for updates again
        Updater::clear();

        return redirect()->back();
    }
}
