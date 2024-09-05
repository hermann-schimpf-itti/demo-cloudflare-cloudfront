<?php declare(strict_types=1);

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

final class FrontendController extends Controller {

    public function index() {
        return inertia('Frontend::Index', [
            'laravel' => app()->version(),
            'php' => PHP_VERSION,
        ]);
    }

    public function create() {
        return inertia('Frontend::Create');
    }

    public function store(Request $request) {
        //
    }

    public function show($resource) {
        return inertia('Frontend::Show');
    }

    public function edit($resource) {
        return inertia('Frontend::Edit');
    }

    public function update(Request $request, $resource) {
        //
    }

    public function destroy($resource) {
        //
    }

}
