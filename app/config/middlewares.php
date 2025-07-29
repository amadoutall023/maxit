<?php

// Fonction pour exécuter les middlewares
function runMiddleWare(array $middlewares): void {
    foreach ($middlewares as $middleware) {
        // Si le middleware est une fonction
        if (is_callable($middleware)) {
            $middleware();
        }
        // Si le middleware est une classe
        elseif (is_string($middleware) && class_exists($middleware)) {
            $middlewareInstance = new $middleware();
            if (method_exists($middlewareInstance, 'handle')) {
                $middlewareInstance->handle();
            }
        }
    }
}
