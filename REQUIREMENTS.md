# Abast actual de SprintBoard

SprintBoard és una aplicació web didàctica en PHP 8.3 que simula un tauler de treball Scrum/Kanban per a un grup de 2n de DAW. En aquesta versió l'objectiu és practicar el cicle petició-resposta, els formularis, les sessions, la validació i una persistència senzilla amb JSON.

## Sprint 1 / UP1

Aquestes funcionalitats formen part de la versió essencial:

- Login amb usuaris predefinits, logout i protecció de pàgines privades.
- Perfil bàsic de l'usuari autenticat.
- Visualització de l'esprint actiu.
- Tauler Kanban amb les columnes To do, In progress i Done.
- Filtre del tauler per equip.
- Canvi d'estat d'una tasca amb un formulari `POST` protegit amb CSRF.
- Creació de tasques dins de l'esprint actiu.
- Validació dels formularis i conservació dels valors introduïts.
- Consulta del detall d'una tasca.
- Creació i visualització de comentaris no buits.
- Missatges visibles quan una validació o una operació de persistència falla.

La persistència de l'Sprint 1 es fa en `data/store.json`. Aquesta decisió manté visible per a l'alumnat el flux de lectura i escriptura sense introduir encara SQL ni PDO.

## Funcionalitats preparades per a una fase posterior

Les funcionalitats següents no són necessàries per completar UP1:

- Llistat i fitxa detallada de diversos esprints.
- Edició de tasques.
- Filtres per estat i responsable.
- Edició de rols i validació de Scrum Masters per equip.
- Històric d'esprints i estadístiques.
- Evidències i pujada de fitxers.
- Assignació automàtica d'equips.
- Recuperació de contrasenya, permisos avançats i panell d'administració.
- API REST, notificacions, integració amb GitHub i exportació d'informes.

El registre d'usuaris està disponible com una extensió senzilla per practicar validació i `password_hash`, però no és necessari per a l'activitat essencial d'UP1.

## Criteris didàctics

Cada funcionalitat ha de permetre explicar el recorregut següent:

```text
petició -> lectura de dades -> validació -> canvi de dades -> resposta
```

No s'utilitzen frameworks, MVC, ORM, repositoris ni serveis. Les pàgines processen els seus propis formularis perquè l'alumnat puga seguir el flux de manera directa.
