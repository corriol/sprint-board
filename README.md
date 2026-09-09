# SprintBoard

Aplicació PHP 8.3 didàctica per practicar sessions, formularis, validació i persistència en JSON.

## Execució local

1. Comprova que tens PHP 8.3 o posterior:

   ```bash
   php -v
   ```

2. Inicia el servidor integrat des de l'arrel del projecte:

   ```bash
   php -S localhost:8000 -t public
   ```

3. Obri `http://localhost:8000` en el navegador.

El procés de PHP necessita permisos d'escriptura sobre `data/store.json` per crear tasques, comentaris i usuaris.

## Credencials de prova

- `alex@example.test` / `password`
- `maria@example.test` / `password`

## Fluxos principals

- `login.php`: valida les credencials i regenera la sessió.
- `index.php`: localitza l'esprint actiu i calcula els comptadors de les seues tasques.
- `board.php`: filtra les tasques de l'esprint actiu i canvia l'estat amb `POST` i CSRF.
- `task-create.php`: valida i guarda una tasca dins de l'esprint actiu.
- `task.php`: mostra una tasca i permet afegir comentaris no buits.

La guia de proves i depuració es troba en `docs/proves-manuals.md`.
