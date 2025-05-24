<?php

use Inertia\Inertia;
use Inertia\Response;

if (! function_exists('responseDefault')) {
    function responseDefault(string $path, $data = null, $message = null): Response
    {
        return Inertia::render($path, [
            'message' => $message ?: 'Request processed successfully',
            'data' => $data ?? null
        ]);
    }
}

if (! function_exists('responseCreated')) {
    function responseCreated(string $path, $message = null, $data = null): Response
    {
        return Inertia::render($path, [
            'message' => $message ?: 'Record created successfully',
            'data' => $data ?? null
        ]);
    }
}

if (! function_exists('responseEdited')) {
    function responseEdited(string $path, $message = null, $data = null): Response
    {
        return Inertia::render($path, [
            'message' => $message ?: 'Record updated successfully',
            'data' => $data ?? null
        ]);
    }
}

if (! function_exists('responseDeleted')) {
    function responseDeleted(string $path, $message = null, $data = null): Response
    {
        return Inertia::render($path, [
            'message' => $message ?: 'Record deleted successfully',
            'data' => $data ?? null
        ]);
    }
}
