# Guia de depuració d'UP1

## Casos intencionadament erronis

- Enviar un formulari sense el camp CSRF.
- Canviar manualment l'estat d'una tasca per un valor que no siga `todo`, `in_progress` o `done`.
- Consultar una tasca amb un identificador inexistent.
- Escriure un comentari que només continga espais.
- Introduir JSON invàlid en `data/store.json` en un entorn de prova.

## Preguntes de defensa

- Per què es crida `session_start()` abans de consultar `$_SESSION`?
- Per què s'utilitza `password_verify()` i no es compara la contrasenya directament?
- Quina diferència hi ha entre validar en HTML amb `required` i validar en PHP?
- Per què el canvi d'estat utilitza `POST` i un token CSRF?
- Què ocorre si no hi ha cap esprint amb estat `active`?
