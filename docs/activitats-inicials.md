# Activitats inicials de PHP

Activitats pràctiques integrades en el projecte SprintBoard per a alumnat que acaba de començar amb PHP.

Les activitats treballen principalment amb formularis, sessions, arrays, condicions, bucles i funcions. No cal modificar manualment tots els fitxers de dades per completar-les.

## 1. Mostrar un missatge personalitzat

- **Fitxer:** `public/index.php`
- **Objectiu:** Mostrar al costat del nom de l'usuari el seu email.
- **Tasques:** Utilitzar les dades retornades per `currentUser()` i mostrar el nom amb la funció `h()`.
- **Conceptes:** Variables, arrays associatius, sessions i escapament HTML.
- **Criteri de finalització:** La pàgina mostra un missatge personalitzat sense exposar HTML introduït per l'usuari.

## 2. Mostrar la data al peu de pàgina

- **Fitxer:** `includes/footer.php`
- **Objectiu:** Mostrar la data i l'hora en totes les pàgines
- **Tasques:** Utilitzar les funcions de manipulació de dates de PHP per a generar la data en format español. Utilitzarem una funció personalitzada que rebrà un paràmentre booleà i que retornarà la data si el paràmetre és false i la data i l'hora si el paràmetre és true.
- **Conceptes:** Inclusions, funcions, paràmetres, tipus de dades
- **Criteri de finalització:** Totes la pàgines mostraran la data en format "dilluns, 14 de setembre de 2026"

## 3. Millorar la validació de tasques

- **Fitxer:** `public/task-create.php`
- **Objectiu:** Evitar que es creen tasques amb títols massa curts o massa llargs.
- **Tasques:** Afegir una longitud mínima i màxima al títol, mostrar els errors i conservar els valors del formulari.
- **Conceptes:** `POST`, `trim()`, condicions i validació.
- **Criteri de finalització:** El formulari rebutja títols no vàlids i informa clarament de l'error.

## 4. Mostrar tasques per equip

- **Fitxers:** `public/index.php`, `data/tasks.json` i `data/teams.json` si s'utilitzen fitxers separats.
- **Objectiu:** Calcular quantes tasques té cada equip.
- **Tasques:** Recórrer les tasques, relacionar-les amb els equips mitjançant `team_id` i mostrar el resultat en targetes.
- **Conceptes:** Arrays, `foreach`, comptadors i identificadors.
- **Criteri de finalització:** L'inici mostra un recompte correcte per a cada equip.

## 5. Millorar els comentaris

- **Fitxer:** `public/task.php`
- **Objectiu:** Fer més completa la informació dels comentaris.
- **Tasques:** Mostrar la data de creació i validar que el comentari tinga almenys 10 caràcters.
- **Conceptes:** Formularis, validació i arrays associatius.
- **Criteri de finalització:** Els comentaris massa curts no es guarden i els comentaris vàlids mostren la seua data.

## 6. Afegir prioritat a les tasques

- **Fitxers:** `public/task-create.php`, `public/board.php` i les dades de tasques.
- **Objectiu:** Permetre indicar la importància d'una tasca.
- **Tasques:** Afegir les prioritats `Baixa`, `Mitjana` i `Alta`, validar l'opció i mostrar-la amb una etiqueta Bootstrap.
- **Conceptes:** Formularis, opcions, condicions i validació.
- **Criteri de finalització:** Cada tasca mostra una prioritat vàlida al tauler.

## 8. Filtrar tasques per estat

- **Fitxer:** `public/board.php`
- **Objectiu:** Facilitar la consulta del tauler Kanban.
- **Tasques:** Afegir les opcions `Totes`, `To do`, `In progress` i `Done`, i mostrar només les tasques de l'estat seleccionat.
- **Conceptes:** `GET`, `foreach` i condicions.
- **Criteri de finalització:** El filtre funciona i conserva l'opció seleccionada després de fer la consulta.

## 9. Buscar tasques pel títol

- **Fitxer:** `public/board.php`
- **Objectiu:** Localitzar ràpidament una tasca.
- **Tasques:** Afegir un camp de cerca, comparar el text sense diferenciar majúscules i minúscules i mostrar un missatge si no hi ha resultats.
- **Conceptes:** `GET`, `strtolower()`, `str_contains()` i bucles.
- **Criteri de finalització:** La cerca mostra les tasques que contenen el text introduït.

## 9. Mostrar un resum de l'esprint

- **Fitxer:** `public/index.php`
- **Objectiu:** Mostrar una visió ràpida de l'estat de l'esprint actiu.
- **Tasques:** Calcular i mostrar el nombre de tasques pendents, en progrés i completades.
- **Conceptes:** Arrays, comptadors i condicions.
- **Criteri de finalització:** Els comptadors només inclouen les tasques de l'esprint actiu.

## 10. Mostrar les meues tasques

- **Fitxer:** `public/board.php`
- **Objectiu:** Permetre que cada usuari consulte les tasques que té assignades.
- **Tasques:** Afegir el filtre `Només les meues tasques` i comparar `user_id` amb l'usuari autenticat.
- **Conceptes:** Sessions, `$_SESSION`, identificadors i filtres.
- **Criteri de finalització:** El filtre només mostra les tasques de l'usuari actual.

## 11. Ordenar les tasques per títol

- **Fitxer:** `public/board.php`
- **Objectiu:** Ordenar les tasques perquè siguen més fàcils de consultar.
- **Tasques:** Afegir una opció per ordenar alfabèticament en ordre ascendent o descendent.
- **Conceptes:** Arrays, comparacions, funcions i `usort()`.
- **Criteri de finalització:** Les tasques apareixen en l'ordre seleccionat.

## Recomanacions

- Fer una activitat cada vegada i provar-la abans de començar la següent.
- No modificar directament les dades de producció durant les proves.
- Explicar sempre el recorregut `petició -> lectura -> validació -> resposta`.
- Comprovar tant els casos correctes com els casos amb dades buides o incorrectes.
