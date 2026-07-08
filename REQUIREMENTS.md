```text
Funcionalitats de l’aplicació SprintBoard

Genera una aplicació web didàctica en PHP 8.2 anomenada SprintBoard.

L’aplicació ha de simular una eina senzilla per gestionar el treball per projectes amb Scrum i Kanban en un grup de 2n de DAW.

Funcionalitats completament implementades:

1. Autenticació
- Login amb usuaris predefinits.
- Logout.
- Protecció de pàgines privades.
- Perfil bàsic de l’usuari autenticat.

2. Esprints
- Llistat d’esprints.
- Visualització de l’esprint actual.
- Fitxa d’un esprint amb dates, objectiu i estat.
- Indicació visual de si l’esprint està actiu, finalitzat o pendent.

3. Equips
- Llistat d’equips.
- Fitxa d’un equip.
- Visualització dels membres de cada equip.
- Visualització del rol de cada membre en l’esprint actual.

4. Tauler Kanban
- Visualització de tasques en tres columnes:
  - To do
  - In progress
  - Done
- Cada tasca mostra títol, descripció breu, equip assignat, responsable i estat.
- Possibilitat de canviar una tasca d’estat.
- Filtre bàsic per equip.

5. Tasques
- Crear una nova tasca.
- Validació del formulari de creació.
- Missatges d’error.
- Conservació dels valors antics del formulari.
- Missatge de confirmació quan la tasca es crea correctament.

6. Comentaris
- Afegir comentaris simples a una tasca.
- Mostrar els comentaris associats a cada tasca.
- Validar que el comentari no estiga buit.

Funcionalitats parcialment implementades amb TODO perquè les complete l’alumnat:

1. Assignació de rols
- Mostrar els rols ja assignats.
- Deixar pendent la funcionalitat per canviar el rol d’un membre.
- TODO: implementar formulari per modificar rols.
- TODO: validar que un equip no tinga dos Scrum Master en el mateix esprint.

2. Edició de tasques
- Mostrar un enllaç o botó “Editar”.
- Deixar creada la pàgina d’edició, però sense tota la lògica completa.
- TODO: carregar les dades actuals de la tasca.
- TODO: validar el formulari d’edició.
- TODO: guardar els canvis.

3. Filtres del tauler
- Implementar filtre per equip.
- Deixar pendent el filtre per estat i responsable.
- TODO: filtrar tasques per estat.
- TODO: filtrar tasques per alumne responsable.

4. Històric d’esprints
- Mostrar el llistat d’esprints.
- Deixar pendent una pàgina d’històric detallat.
- TODO: mostrar quin rol ha tingut cada alumne en cada esprint.
- TODO: mostrar quantes tasques ha completat cada alumne.

5. Evidències
- Crear l’opció “Evidències” en el menú.
- Deixar creada la pàgina buida.
- TODO: permetre pujar una evidència associada a una tasca.
- TODO: mostrar les evidències d’una tasca.
- TODO: validar el tipus de fitxer.

6. Estadístiques
- Mostrar una pàgina inicial d’estadístiques molt simple.
- TODO: calcular nombre de tasques per estat.
- TODO: calcular tasques completades per equip.
- TODO: calcular participació per alumne.
- TODO: mostrar percentatge de finalització de l’esprint.

7. Assignació automàtica d’equips
- Mostrar els alumnes existents.
- Mostrar els equips existents.
- TODO: crear una funció que repartisca alumnes en equips.
- TODO: evitar repetir companys de l’esprint anterior.
- TODO: garantir que cada equip tinga un nombre semblant de membres.

Funcionalitats no implementades, només previstes per a fases posteriors:

1. Registre d’usuaris.
2. Recuperació de contrasenya.
4. Panell complet d’administració.
5. API REST.
6. Permisos avançats per rol.
7. Notificacions.
8. Integració amb GitHub.
9. Exportació d’informes.

La idea és que l’aplicació siga funcional des del principi, però que continga buits didàctics reals perquè l’alumnat puga completar-los progressivament durant els esprints.