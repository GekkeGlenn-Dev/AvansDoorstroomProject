<?php


namespace App\Http;


use Inertia\Inertia;
use Inertia\Response;

trait InertiaRender
{
    public function renderVue($component, $props = []): Response
    {
        return Inertia::render($component, $props);
    }
}
