<?php

namespace App\Extensions;

use Illuminate\Session\DatabaseSessionHandler as BaseDatabaseSessionHandler;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Guard;

class CustomDatabaseSessionHandler extends BaseDatabaseSessionHandler
{
    /**
     * Generate a new session ID.
     *
     * @return string
     */
    protected function generateSessionId()
    {
        // Usar Str::random como método alternativo para generar IDs
        return Str::random(40);
    }

    /**
     * Get the user ID from the session.
     *
     * @param  array  $session
     * @return int|null
     */
    protected function getUserId($session)
    {
        return $session['user_id'] ?? null;
    }

    /**
     * Get the default payload for the session.
     *
     * @param  string  $data
     * @return array
     */
    protected function getDefaultPayload($data)
    {
        $payload = [
            'id' => $this->generateSessionId(),
            'payload' => base64_encode($data),
            'last_activity' => $this->currentTime(),
        ];

        if (! $this->container->bound(Guard::class)) {
            return $payload;
        }

        $guard = $this->container->make(Guard::class);

        if ($guard->guest()) {
            return $payload;
        }

        // Aquí está la modificación clave - usa id_usuario en lugar de id
        return array_merge($payload, [
            'user_id' => $guard->user()->id_usuario,
        ]);
    }
}