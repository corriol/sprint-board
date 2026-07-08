-- Users (password is "1234" hashed with password_hash)
INSERT INTO users (username, password, name, email, role) VALUES
('admin', '$2y$10$KUguFeJrAkWPRS4vwaa10eZ/hcxmoFN.LYb0eHshQqVJE4TMgqbWC', 'Admin', 'admin@sprintboard.local', 'teacher'),
('alice', '$2y$10$KUguFeJrAkWPRS4vwaa10eZ/hcxmoFN.LYb0eHshQqVJE4TMgqbWC', 'Alice Johnson', 'alice@sprintboard.local', 'student'),
('bob', '$2y$10$KUguFeJrAkWPRS4vwaa10eZ/hcxmoFN.LYb0eHshQqVJE4TMgqbWC', 'Bob Smith', 'bob@sprintboard.local', 'student'),
('carol', '$2y$10$KUguFeJrAkWPRS4vwaa10eZ/hcxmoFN.LYb0eHshQqVJE4TMgqbWC', 'Carol White', 'carol@sprintboard.local', 'student'),
('david', '$2y$10$KUguFeJrAkWPRS4vwaa10eZ/hcxmoFN.LYb0eHshQqVJE4TMgqbWC', 'David Brown', 'david@sprintboard.local', 'student'),
('eva', '$2y$10$KUguFeJrAkWPRS4vwaa10eZ/hcxmoFN.LYb0eHshQqVJE4TMgqbWC', 'Eva Green', 'eva@sprintboard.local', 'student');

INSERT INTO teams (name) VALUES
('Equip Alpha'),
('Equip Beta'),
('Equip Gamma');

INSERT INTO team_members (team_id, user_id, role) VALUES
(1, 2, 'scrum_master'),
(1, 3, 'developer'),
(2, 4, 'scrum_master'),
(2, 5, 'developer'),
(3, 6, 'developer');

INSERT INTO sprints (name, goal, start_date, end_date, status) VALUES
('Sprint 1', 'Implementar autenticació i gestió bàsica', '2026-02-01', '2026-02-14', 'completed'),
('Sprint 2', 'Desenvolupar el tauler Kanban', '2026-02-15', '2026-02-28', 'completed'),
('Sprint 3', 'Afegir comentaris i evidències', '2026-03-01', '2026-03-14', 'active'),
('Sprint 4', 'Estadístiques i millores finals', '2026-03-15', '2026-03-28', 'pending');

INSERT INTO sprint_team_members (sprint_id, team_id, user_id, role) VALUES
(1, 1, 2, 'scrum_master'),
(1, 1, 3, 'developer'),
(1, 2, 4, 'scrum_master'),
(1, 2, 5, 'developer'),
(1, 3, 6, 'developer'),
(2, 1, 2, 'scrum_master'),
(2, 1, 3, 'developer'),
(2, 2, 4, 'scrum_master'),
(2, 2, 5, 'developer'),
(2, 3, 6, 'developer'),
(3, 1, 2, 'scrum_master'),
(3, 1, 3, 'developer'),
(3, 2, 4, 'scrum_master'),
(3, 2, 5, 'developer'),
(3, 3, 6, 'developer');

INSERT INTO tasks (title, description, status, team_id, user_id, sprint_id) VALUES
('Dissenyar base de dades', 'Crear les taules i relacions del sistema', 'done', 1, 2, 1),
('Implementar login', 'Pàgina d''inici de sessió amb validació', 'done', 1, 3, 1),
('Crear gestió d''usuaris', 'CRUD bàsic d''usuaris', 'done', 2, 4, 1),
('Desenvolupar tauler', 'Tauler Kanban amb tres columnes', 'done', 1, 2, 2),
('Afegir filtre per equip', 'Filtre de tasques per equip al tauler', 'done', 1, 3, 2),
('Dissenyar pàgina d''equips', 'Llistat i fitxa d''equips', 'done', 2, 4, 2),
('Implementar comentaris', 'Afegir i mostrar comentaris a les tasques', 'in_progress', 1, 2, 3),
('Sistema d''evidències', 'Pujar i mostrar evidències de tasques', 'todo', 2, 4, 3),
('Pàgina d''estadístiques', 'Mètriques i gràfics bàsics', 'todo', 1, 3, 3),
('Millorar filtres', 'Filtres per estat i responsable', 'todo', 2, 5, 4),
('Històric d''esprints', 'Pàgina d''històric detallat', 'todo', 3, 6, 4);

INSERT INTO comments (task_id, user_id, content) VALUES
(1, 2, 'He dissenyat el diagrama ENT i l''he convertit en SQL.'),
(1, 3, 'El esquema inclou totes les taules necessàries.'),
(2, 3, 'Login funcionant amb sessions i hash de contrasenya.'),
(7, 2, 'Comentaris funcionant, només falta polir el disseny.');
