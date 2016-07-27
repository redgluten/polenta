<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Artisan;
use Storage;
use App\Http\Requests;
use Illuminate\Support\Collection;

class AdminController extends Controller
{
    use \App\Traits\Format;

    public function index()
    {
        $mostReadArticles  = \App\Article::popular()->take(5)->get();
        $lastModifications = \App\Article::orderBy('updated_at', 'desc')->take(5)->get();
        $backups = $this->getBackups();

        return view('admin.index', compact('mostReadArticles', 'lastModifications', 'backups'));
    }

    /**
     * Retrieve backups from storage
     */
    public function getBackups() : Collection
    {
        $backups = collect();

        foreach (Storage::allFiles(config('backup.name')) as $file) {
            if (substr($file, -4) === '.zip') {
                $backups->put(basename($file), $this->humanReadableSizeFormat(Storage::size($file)));
            }
        }

        return $backups;
    }

    /**
     * Backup the app
     */
    public function backup(Request $request)
    {
        Artisan::queue('backup:run');

        return redirect()->route('admin.index')->with('message', 'La sauvegarde est en cours de préparation');
    }
}
