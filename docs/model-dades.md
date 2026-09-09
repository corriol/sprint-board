# Model de dades de SprintBoard

SprintBoard utilitza un únic fitxer de text JSON (`data/store.json`) per guardar les dades. No hi ha una base de dades relacional ni una capa de persistència amb SQL.

## Entitats

### Usuari (`users`)

Representa una persona que pot accedir a l'aplicació.

| Camp | Tipus | Descripció |
| --- | --- | --- |
| `id` | enter | Identificador únic de l'usuari |
| `name` | text | Nom de l'usuari |
| `email` | text | Correu utilitzat per iniciar sessió |
| `password` | text | Contrasenya emmagatzemada amb hash |
| `role` | text | Rol general, per exemple `student` o `teacher` |

### Esprint (`sprints`)

Representa un període de treball amb un objectiu concret.

| Camp | Tipus | Descripció |
| --- | --- | --- |
| `id` | enter | Identificador únic de l'esprint |
| `name` | text | Nom de l'esprint |
| `goal` | text | Objectiu de l'esprint |
| `start_date` | data | Data d'inici en format `YYYY-MM-DD` |
| `end_date` | data | Data de finalització en format `YYYY-MM-DD` |
| `status` | text | Estat: `pending`, `active` o `finished` |

### Equip (`teams`)

Representa un grup de treball.

| Camp | Tipus | Descripció |
| --- | --- | --- |
| `id` | enter | Identificador únic de l'equip |
| `name` | text | Nom de l'equip |

### Tasca (`tasks`)

Representa una unitat de treball del tauler Kanban.

| Camp | Tipus | Descripció |
| --- | --- | --- |
| `id` | enter | Identificador únic de la tasca |
| `title` | text | Títol curt de la tasca |
| `description` | text | Explicació de la tasca |
| `status` | text | Estat: `todo`, `in_progress` o `done` |
| `team_id` | enter o `null` | Identificador de l'equip assignat |
| `user_id` | enter o `null` | Identificador del responsable |
| `sprint_id` | enter o `null` | Identificador de l'esprint |

### Comentari (`comments`)

Representa una aportació escrita en una tasca.

| Camp | Tipus | Descripció |
| --- | --- | --- |
| `id` | enter | Identificador únic del comentari |
| `task_id` | enter | Tasca a la qual pertany |
| `user_id` | enter | Usuari que ha escrit el comentari |
| `body` | text | Contingut del comentari |
| `created_at` | data i hora | Moment de creació |

### Membre d'equip (`team_members`)

Relaciona un usuari amb un equip i permet guardar el seu rol dins de l'equip.

| Camp | Tipus | Descripció |
| --- | --- | --- |
| `team_id` | enter | Identificador de l'equip |
| `user_id` | enter | Identificador de l'usuari |
| `role` | text | Rol dins de l'equip, per exemple `Developer` o `Scrum Master` |
| `sprint_id` | enter | Esprint en què s'aplica aquesta assignació |

## Relacions

```text
Usuari 1 ─────── N Tasca
Usuari 1 ─────── N Comentari
Usuari N ─────── N Equip, mitjançant `team_members`
Esprint 1 ────── N Tasca
Equip 1 ──────── N Tasca
Tasca 1 ──────── N Comentari
```

En el model actual, un usuari pot ser responsable de moltes tasques i una tasca té com a màxim un responsable. De la mateixa manera, una tasca pertany com a màxim a un equip i a un esprint.

## Camps de control

El fitxer també conté l'objecte `next_ids`:

```json
"next_ids": {
    "tasks": 3,
    "comments": 1
}
```

Aquests valors permeten assignar identificadors nous quan es crea una tasca o un comentari.

## Limitacions actuals

- El canvi de rol encara no té formulari, però l'assignació ja identifica l'esprint amb `sprint_id`.
- No hi ha entitats per a evidències, notificacions o historial de canvis.
- Les relacions es controlen amb identificadors dins dels arrays i no amb claus foranes.
- El JSON és adequat per a una activitat inicial, però no resol concurrència, permisos de base de dades ni consultes complexes.
- Un error de lectura o un JSON corrupte atura la petició amb un missatge general; en producció caldria registrar el detall sense mostrar-lo a l'usuari.
- Les tasques noves es creen sense equip assignat i amb l'usuari autenticat com a responsable.
