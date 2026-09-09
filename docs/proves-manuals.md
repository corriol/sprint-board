# Proves manuals d'UP1

## Accés i sessions

- [ ] Obrir una pàgina privada sense sessió i comprovar la redirecció a `login.php`.
- [ ] Iniciar sessió amb les credencials de prova i comprovar que s'accedeix a l'inici.
- [ ] Introduir una contrasenya incorrecta i comprovar el missatge d'error.
- [ ] Tancar sessió amb el botó del menú i comprovar que la sessió deixa de ser vàlida.

## Tasques i esprint actiu

- [ ] Comprovar que l'inici només compta les tasques de l'esprint actiu.
- [ ] Crear una tasca correcta i comprovar que apareix en `To do`.
- [ ] Enviar una tasca sense títol ni descripció i comprovar els errors i els valors conservats.
- [ ] Canviar l'estat d'una tasca des del tauler.
- [ ] Filtrar el tauler per equip i retirar el filtre.

## Comentaris i errors

- [ ] Obrir el detall d'una tasca existent.
- [ ] Intentar enviar un comentari buit i comprovar el missatge visible.
- [ ] Afegir un comentari correcte i comprovar que apareix al detall.
- [ ] Eliminar o modificar temporalment el JSON, recarregar la pàgina i observar el missatge d'error de dades.

## Flux per explicar a classe

Per a cada prova, l'alumnat ha d'identificar:

1. Quin fitxer rep la petició.
2. Quins camps del formulari es llegeixen.
3. Quines validacions s'executen.
4. En quin moment es modifica `data/store.json`.
5. Quina resposta rep el navegador.
