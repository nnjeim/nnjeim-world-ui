<?php

namespace App\Http\Controllers;

use App\Support\ComponentCatalog;
use Illuminate\Contracts\View\View;

class ComponentController extends Controller
{
    public function __invoke(string $component): View
    {
        $selectedComponent = ComponentCatalog::find($component);

        abort_if($selectedComponent === null, 404);

        return view('components.show', [
            'component' => $selectedComponent,
            'components' => ComponentCatalog::all(),
            'slug' => $component,
        ]);
    }
}
