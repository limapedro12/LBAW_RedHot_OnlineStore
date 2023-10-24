SET search_path TO lbaw2352;

SET timezone = 'Europe/Lisbon';

INSERT INTO Utilizador (id, nome, email, password) VALUES
  (1,'Dominic Walter','et.eros@yahoo.couk','XRC92KGT3PX'),
  (2,'Scott Mckenzie','nonummy.ultricies.ornare@icloud.org','HEE09TED7XV'),
  (3,'Janna Santiago','proin.vel.nisl@yahoo.net','JLY18UFO0RY'),
  (4,'Nathan Horne','dolor.nulla@icloud.couk','JFX71BSD7SC'),
  (5,'Tiger Boyle','dignissim@hotmail.net','SDU69QXM4TH'),
  (6,'James Gutierrez','dolor.quisque@hotmail.ca','GEV73ERP4BN'),
  (7,'Miranda Holmes','curae.phasellus@protonmail.org','CQX21FNX0MB'),
  (8,'Vincent Chambers','pede.nonummy@hotmail.edu','EVH63ZKS0DY'),
  (9,'Inez Barrera','nibh.aliquam@outlook.ca','EJY18RGV2MU'),
  (10,'Jordan Chandler','enim.nunc@icloud.edu','CKN22QHB2VH'),
  (11,'Octavia Hickman','enim.diam@protonmail.couk','FNQ14POC4VY'),
  (12,'Neil Petersen','metus.aliquam@hotmail.net','VCC55JKP7GF'),
  (13,'Kyla Tanner','tempor.lorem.eget@outlook.org','OME47XIN8YG'),
  (14,'Leilani Sargent','amet.ornare.lectus@aol.org','OUQ44TKA3PO'),
  (15,'Prescott Mayer','donec.dignissim@icloud.couk','DWF44MCK4DM'),
  (16,'Dean Lawson','ut@aol.com','XJC01OKK3IO'),
  (17,'John Holmes','nec.eleifend@protonmail.org','SPQ25VQX5BT'),
  (18,'Colorado Lamb','sed.nec@yahoo.edu','UQY34WSJ5XT'),
  (19,'Ralph Lambert','commodo.hendrerit@outlook.edu','JSA88KNH7BS'),
  (20,'Brenna Cline','a.felis.ullamcorper@yahoo.org','RTF10SNH7CL');

INSERT INTO Administrador (id, nome, email, password) VALUES
  (1, 'Guilherme Couto', 'guicouto@aol.com', 'JAF73FJA9'),
  (2, 'Filipa Antunes', 'fisantunes@google.pt', 'AD2155FWA'),
  (3, 'Sofia Pereira', 'pereirasofia@iol.pt', '278WGFBFL1'),
  (4, 'Gustavo Faria', 'gugafaria@hotmail.com', '28RTG2UFIW'),
  (5, 'Pedro Martins', 'pedromart@yahoo.es', 'HUG317FBU');

INSERT INTO Compra (id, timestamp, total, descricao, id_utilizador, estado, id_administrador) VALUES
  (1, '2023-01-15 09:23:54', 99.99, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 1, 'Enviada', 1),
  (2, '2023-01-30 10:47:06', 49.95, 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 2, 'Aguarda pagamento', 2),
  (3, '2023-02-05 03:56:15', 199.99, 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris', 3, 'Enviada', 3),
  (4, '2023-02-09 07:53:18', 79.99, 'Nisi ut aliquip ex ea commodo consequat', 4, 'Enviada', 4),
  (5, '2023-02-12 18:24:22', 129.99, 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum', 5, 'Aguarda pagamento', 5),
  (6, '2023-02-15 01:15:26', 59.99, 'Excepteur sint occaecat cupidatat non proident, sunt in culpa', 6, 'Aguarda pagamento', 5),
  (7, '2023-02-19 16:05:57', 89.99, 'Qui officia deserunt mollit anim id est laborum', 7, 'Aguarda pagamento', 4),
  (8, '2023-02-26 00:59:05', 39.99, 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt', 8, 'Aguarda pagamento', 3),
  (9, '2023-03-02 11:32:11', 69.99, 'Ut labore et dolore magna aliqua. Ut enim ad', 9, 'Aguarda pagamento', 2),
  (10, '2023-03-06 03:39:05', 119.99, 'Minim veniam, quis nostrud exercitation ullamco laboris nisi', 10, 'Aguarda pagamento', 1),
  (11, '2023-03-11 18:03:47', 69.99, 'Ut aliquip ex ea commodo consequat. Duis aute', 11, 'Aguarda pagamento', 1),
  (12, '2023-03-14 01:18:38', 179.99, 'Excepteur sint occaecat cupidatat non proident, sunt in', 12, 'Aguarda pagamento', 2),
  (13, '2023-03-19 19:56:04', 49.99, 'Culpa qui officia deserunt mollit anim id est', 13, 'Aguarda pagamento', 3),
  (14, '2023-03-21 06:48:31', 99.99, 'Eiusmod tempor incididunt ut labore et dolore magna', 14, 'Aguarda pagamento', 4),
  (15, '2023-03-25 00:23:36', 69.99, 'Aliqua. Ut enim ad minim veniam, quis', 15, 'Aguarda pagamento', 5),
  (16, '2023-03-30 21:47:10', 149.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 16, 'Aguarda pagamento', 5),
  (17, '2023-04-02 04:35:50', 79.99, 'Ex ea commodo consequat. Duis aute irure', 17, 'Enviada', 4),
  (18, '2023-04-05 02:46:03', 119.99, 'Dolor in reprehenderit in voluptate velit esse', 18, 'Entregue', 3),
  (19, '2023-04-09 16:23:37', 49.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 19, 'Entregue', 2),
  (20, '2023-04-12 22:38:22', 139.99, 'Sint occaecat cupidatat non proident, sunt in', 20, 'Enviada', 1),
  (21, '2023-04-17 07:50:19', 79.99, 'Culpa qui officia deserunt mollit anim id est', 1, 'Aguarda pagamento', 1),
  (22, '2023-04-22 18:02:54', 89.99, 'Eiusmod tempor incididunt ut labore et dolore magna', 2, 'Enviada', 2),
  (23, '2023-04-27 15:12:08', 69.99, 'Aliqua. Ut enim ad minim veniam, quis', 3, 'Enviada', 3),
  (24, '2023-05-01 11:37:33', 129.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 4, 'Aguarda pagamento', 4),
  (25, '2023-05-04 10:10:43', 149.99, 'Ex ea commodo consequat. Duis aute irure', 5, 'Entregue', 5),
  (26, '2023-05-07 13:42:41', 79.99, 'Dolor in reprehenderit in voluptate velit esse', 6, 'Enviada', 5),
  (27, '2023-05-11 12:31:20', 109.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 7, 'Enviada', 4),
  (28, '2023-05-13 14:51:36', 159.99, 'Sint occaecat cupidatat non proident, sunt in', 8, 'Enviada', 3),
  (29, '2023-05-17 08:07:42', 59.99, 'Culpa qui officia deserunt mollit anim id est', 9, 'Enviada', 2),
  (30, '2023-05-22 23:40:01', 89.99, 'Eiusmod tempor incididunt ut labore et dolore', 10, 'Entregue', 1),
  (31, '2023-05-26 02:07:23', 119.99, 'Aliqua. Ut enim ad minim veniam, quis', 11, 'Enviada', 1),
  (32, '2023-05-30 04:33:45', 99.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 12, 'Entregue', 2),
  (33, '2023-06-03 08:41:16', 129.99, 'Ex ea commodo consequat. Duis aute irure', 13, 'Entregue', 3),
  (34, '2023-06-06 13:21:39', 119.99, 'Dolor in reprehenderit in voluptate velit esse', 14, 'Entregue', 4),
  (35, '2023-06-08 01:19:59', 69.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 15, 'Enviada', 5),
  (36, '2023-06-12 16:54:29', 119.99, 'Sint occaecat cupidatat non proident, sunt in', 16, 'Entregue', 5),
  (37, '2023-06-18 12:20:29', 139.99, 'Culpa qui officia deserunt mollit anim id est', 17, 'Devolução solicitada', 4),
  (38, '2023-06-20 08:45:31', 129.99, 'Eiusmod tempor incididunt ut labore et dolore', 18, 'Devolução solicitada', 3),
  (39, '2023-06-22 21:01:00', 99.99, 'Aliqua. Ut enim ad minim veniam, quis', 19, 'Devolução solicitada', 2),
  (40, '2023-06-28 19:30:58', 99.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 20, 'Entregue', 1),
  (41, '2023-07-03 00:01:29', 69.99, 'Ex ea commodo consequat. Duis aute irure', 1, 'Entregue', 1),
  (42, '2023-07-07 06:29:30', 139.99, 'Dolor in reprehenderit in voluptate velit esse', 2, 'Devolvida', 2),
  (43, '2023-07-10 21:34:42', 199.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 3, 'Entregue', 3),
  (44, '2023-07-12 22:28:47', 49.99, 'Sint occaecat cupidatat non proident, sunt in', 4, 'Entregue', 4),
  (45, '2023-07-16 14:58:19', 109.99, 'Culpa qui officia deserunt mollit anim id est', 5, 'Devolução solicitada', 5),
  (46, '2023-07-18 03:08:13', 69.99, 'Eiusmod tempor incididunt ut labore et dolore magna', 6, 'Enviada', 5),
  (47, '2023-07-23 03:45:12', 119.99, 'Aliqua. Ut enim ad minim veniam, quis', 7, 'Entregue', 4),
  (48, '2023-07-28 12:43:49', 59.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 8, 'Entregue', 3),
  (49, '2023-07-29 10:14:57', 99.99, 'Ex ea commodo consequat. Duis aute irure', 9, 'Entregue', 2),
  (50, '2023-08-03 21:50:14', 89.99, 'Dolor in reprehenderit in voluptate velit esse', 10, 'Entregue', 1),
  (51, '2023-08-04 19:40:28', 69.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 11, 'Entregue', 1),
  (52, '2023-08-07 14:49:59', 49.99, 'Sint occaecat cupidatat non proident, sunt in', 12, 'Entregue', 2),
  (53, '2023-08-10 14:09:52', 69.99, 'Culpa qui officia deserunt mollit anim id est', 13, 'Entregue', 3),
  (54, '2023-08-14 14:49:17', 99.99, 'Eiusmod tempor incididunt ut labore et dolore', 14, 'Devolução solicitada', 4),
  (55, '2023-08-17 17:59:53', 149.99, 'Aliqua. Ut enim ad minim veniam, quis', 15, 'Aguarda pagamento', 5),
  (56, '2023-08-20 05:28:06', 139.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 16, 'Devolvida', 5),
  (57, '2023-08-21 13:13:02', 89.99, 'Ex ea commodo consequat. Duis aute irure', 17, 'Aguarda pagamento', 4),
  (58, '2023-08-24 14:32:04', 79.99, 'Dolor in reprehenderit in voluptate velit esse', 18, 'Aguarda pagamento', 3),
  (59, '2023-08-28 20:45:15', 99.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 19, 'Aguarda pagamento', 2),
  (60, '2023-08-30 23:55:30', 119.99, 'Sint occaecat cupidatat non proident, sunt in', 20, 'Entregue', 1),
  (61, '2023-09-03 12:38:59', 49.99, 'Culpa qui officia deserunt mollit anim id', 1, 'Entregue', 1),
  (62, '2023-09-09 06:06:43', 79.99, 'Eiusmod tempor incididunt ut labore et dolore', 2, 'Entregue', 2),
  (63, '2023-09-15 22:46:11', 119.99, 'Aliqua. Ut enim ad minim veniam, quis', 3, 'Entregue', 3),
  (64, '2023-09-18 07:49:59', 129.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 4, 'Enviada', 4),
  (65, '2023-09-25 05:33:56', 129.99, 'Culpa qui officia deserunt mollit anim id', 5, 'Enviada', 5),
  (66, '2023-09-28 13:20:42', 149.99, 'Eiusmod tempor incididunt ut labore et dolore', 6, 'Enviada', 5),
  (67, '2023-10-02 23:54:20', 99.99, 'Aliqua. Ut enim ad minim veniam, quis', 7, 'Devolução solicitada', 4),
  (68, '2023-10-08 07:03:17', 179.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 8, 'Enviada', 3),
  (69, '2023-10-10 16:47:16', 79.99, 'Ex ea commodo consequat. Duis aute irure', 9, 'Entregue', 2),
  (70, '2023-10-14 15:03:32', 99.99, 'Dolor in reprehenderit in voluptate velit esse', 10, 'Entregue', 1),
  (71, '2023-10-15 23:07:55', 199.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 11, 'Entregue', 1),
  (72, '2023-10-18 10:24:37', 149.99, 'Sint occaecat cupidatat non proident, sunt in', 12, 'Entregue', 2),
  (73, '2023-10-22 16:16:52', 139.99, 'Culpa qui officia deserunt mollit anim id est', 13, 'Entregue', 3),
  (74, '2023-10-23 08:45:34', 119.99, 'Eiusmod tempor incididunt ut labore et dolore magna', 14, 'Enviada', 4),
  (75, '2023-10-16 11:58:07', 89.99, 'Aliqua. Ut enim ad minim veniam, quis', 15, 'Devolvida', 5),
  (76, '2023-10-17 01:34:20', 109.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 16, 'Entregue', 5),
  (77, '2023-10-18 19:16:45', 129.99, 'Ex ea commodo consequat. Duis aute irure', 17, 'Entregue', 4),
  (78, '2023-10-19 06:59:55', 69.99, 'Dolor in reprehenderit in voluptate velit esse', 18, 'Entregue', 3),
  (79, '2023-10-20 08:24:33', 79.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 19, 'Entregue', 2),
  (80, '2023-10-21 10:43:51', 99.99, 'Sint occaecat cupidatat non proident, sunt in', 20, 'Entregue', 1),
  (81, '2023-10-22 05:05:33', 179.99, 'Culpa qui officia deserunt mollit anim id est', 1, 'Entregue', 1),
  (82, '2023-10-23 00:05:28', 69.99, 'Eiusmod tempor incididunt ut labore et dolore magna', 2, 'Entregue', 2),
  (83, '2023-10-23 00:39:35', 79.99, 'Aliqua. Ut enim ad minim veniam, quis', 3, 'Entregue', 3),
  (84, '2023-10-23 01:17:05', 59.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 4, 'Enviada', 4),
  (85, '2023-10-23 02:01:32', 139.99, 'Ex ea commodo consequat. Duis aute irure', 5, 'Entregue', 5),
  (86, '2023-10-23 03:55:27', 49.99, 'Dolor in reprehenderit in voluptate velit esse', 6, 'Entregue', 5),
  (87, '2023-10-23 04:12:29', 89.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 7, 'Entregue', 4),
  (88, '2023-10-23 05:26:37', 79.99, 'Sint occaecat cupidatat non proident, sunt in', 8, 'Entregue', 3),
  (89, '2023-10-23 06:25:36', 119.99, 'Culpa qui officia deserunt mollit anim id est', 9, 'Entregue', 2),
  (90, '2023-10-23 07:20:39', 29.99, 'Eiusmod tempor incididunt ut labore et dolore magna', 10, 'Entregue', 1),
  (91, '2023-10-23 08:46:01', 179.99, 'Aliqua. Ut enim ad minim veniam, quis', 11, 'Entregue', 2),
  (92, '2023-10-23 09:40:25', 69.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 12, 'Enviada', 3),
  (93, '2023-10-23 10:33:23', 109.99, 'Ex ea commodo consequat. Duis aute irure', 13, 'Enviada', 4),
  (94, '2023-10-23 11:47:45', 59.99, 'Dolor in reprehenderit in voluptate velit esse', 14, 'Enviada', 5),
  (95, '2023-10-23 12:54:04', 149.99, 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 15, 'Enviada', 5),
  (96, '2023-10-23 13:58:29', 79.99, 'Sint occaecat cupidatat non proident, sunt in', 16, 'Enviada', 4),
  (97, '2023-10-23 14:10:09', 139.99, 'Culpa qui officia deserunt mollit anim id est', 17, 'Enviada', 3),
  (98, '2023-10-23 15:30:15', 99.99, 'Eiusmod tempor incididunt ut labore et dolore magna', 18, 'Enviada', 2),
  (99, '2023-10-23 16:15:02', 119.99, 'Aliqua. Ut enim ad minim veniam, quis', 19, 'Enviada', 1),
  (100, '2023-10-23 17:25:44', 69.99, 'Nostrud exercitation ullamco laboris nisi ut aliquip', 20, 'Enviada', 1);

INSERT INTO Transporte (id, tipo, precoAtual) VALUES
  (1, 'Grátis', 0),
  (2, 'Levantamento em Ponto Pick-up', 2.5),
  (3, 'Entrega ao domicílio', 5);

INSERT INTO Devolucao (id, timestamp, estado, id_compra) VALUES
  (1, '2023-08-15 08:15:30', 'Pendente', 27),
  (2, '2023-08-20 15:42:12', 'Aprovado', 56),
  (3, '2023-08-25 14:30:59', 'Rejeitado', 89),
  (4, '2023-09-05 11:20:47', 'Pendente', 7),
  (5, '2023-09-10 20:05:34', 'Aprovado', 42),
  (6, '2023-09-15 05:38:29', 'Rejeitado', 13),
  (7, '2023-09-20 09:51:01', 'Pendente', 61),
  (8, '2023-09-25 14:17:55', 'Aprovado', 75),
  (9, '2023-09-30 23:42:03', 'Rejeitado', 93),
  (10, '2023-10-05 16:29:14', 'Pendente', 34);

INSERT INTO Reembolso (id, timestamp, estado, id_compra) VALUES
  (1, '2023-08-15 08:15:30', 'Pendente', 27),
  (2, '2023-08-20 15:42:12', 'Aprovado', 56),
  (3, '2023-08-25 14:30:59', 'Rejeitado', 89),
  (4, '2023-09-05 11:20:47', 'Pendente', 7),
  (5, '2023-09-10 20:05:34', 'Aprovado', 42),
  (6, '2023-09-15 05:38:29', 'Rejeitado', 13),
  (7, '2023-09-20 09:51:01', 'Pendente', 61),
  (8, '2023-09-25 14:17:55', 'Aprovado', 75),
  (9, '2023-09-30 23:42:03', 'Rejeitado', 93),
  (10, '2023-10-05 16:29:14', 'Pendente', 34);

INSERT INTO Notificacao (id, timestamp, texto, id_utilizador)
VALUES
  (1, '2023-09-01 08:15:30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 1),
  (2, '2023-09-02 15:42:12', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua', 2),
  (3, '2023-09-03 14:30:59', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris', 3),
  (4, '2023-09-04 11:20:47', 'Nisi ut aliquip ex ea commodo consequat', 4),
  (5, '2023-09-05 20:05:34', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum', 5),
  (6, '2023-09-06 05:38:29', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa', 6),
  (7, '2023-09-07 09:51:01', 'Qui officia deserunt mollit anim id est laborum', 7),
  (8, '2023-09-08 14:17:55', 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt', 8),
  (9, '2023-09-09 23:42:03', 'Ut labore et dolore magna aliqua. Ut enim ad', 9),
  (10, '2023-09-10 16:29:14', 'Minim veniam, quis nostrud exercitation ullamco laboris nisi', 10),
  (11, '2023-09-11 05:05:33', 'Ut aliquip ex ea commodo consequat. Duis aute', 11),
  (12, '2023-09-12 17:56:28', 'Excepteur sint occaecat cupidatat non proident, sunt in', 12),
  (13, '2023-09-13 00:39:35', 'Culpa qui officia deserunt mollit anim id est', 13),
  (14, '2023-09-14 08:17:05', 'Eiusmod tempor incididunt ut labore et dolore magna', 14),
  (15, '2023-09-15 19:01:32', 'Aliqua. Ut enim ad minim veniam, quis', 15),
  (16, '2023-09-16 06:54:04', 'Nostrud exercitation ullamco laboris nisi ut aliquip', 16),
  (17, '2023-09-17 17:58:29', 'Ex ea commodo consequat. Duis aute irure', 17),
  (18, '2023-09-18 21:10:09', 'Dolor in reprehenderit in voluptate velit esse', 18),
  (19, '2023-09-19 10:30:15', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 19),
  (20, '2023-09-20 19:15:02', 'Sint occaecat cupidatat non proident, sunt in', 20),
  (21, '2023-09-21 11:58:07', 'Aliqua. Ut enim ad minim veniam, quis', 1),
  (22, '2023-09-22 01:34:20', 'Nostrud exercitation ullamco laboris nisi ut aliquip', 2),
  (23, '2023-09-23 19:16:45', 'Ex ea commodo consequat. Duis aute irure', 3),
  (24, '2023-09-24 06:59:55', 'Dolor in reprehenderit in voluptate velit esse', 4),
  (25, '2023-09-25 08:24:33', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 5),
  (26, '2023-09-26 10:43:51', 'Sint occaecat cupidatat non proident, sunt in', 6),
  (27, '2023-09-27 05:05:33', 'Culpa qui officia deserunt mollit anim id est', 7),
  (28, '2023-09-28 17:56:28', 'Eiusmod tempor incididunt ut labore et dolore magna', 8),
  (29, '2023-09-29 00:39:35', 'Aliqua. Ut enim ad minim veniam, quis', 9),
  (30, '2023-09-30 08:17:05', 'Nostrud exercitation ullamco laboris nisi ut aliquip', 10),
  (31, '2023-10-01 19:01:32', 'Ex ea commodo consequat. Duis aute irure', 11),
  (32, '2023-10-02 06:54:04', 'Dolor in reprehenderit in voluptate velit esse', 12),
  (33, '2023-10-03 00:12:29', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 13),
  (34, '2023-10-04 06:26:37', 'Sint occaecat cupidatat non proident, sunt in', 14),
  (35, '2023-10-05 21:25:36', 'Culpa qui officia deserunt mollit anim id est', 15),
  (36, '2023-10-06 08:20:39', 'Eiusmod tempor incididunt ut labore et dolore magna', 16),
  (37, '2023-10-07 05:46:01', 'Aliqua. Ut enim ad minim veniam, quis', 17),
  (38, '2023-10-08 16:40:25', 'Nostrud exercitation ullamco laboris nisi ut', 18),
  (39, '2023-10-09 03:33:23', 'Ex ea commodo consequat. Duis aute irure', 19),
  (40, '2023-10-10 14:47:45', 'Dolor in reprehenderit in voluptate velit esse', 20),
  (41, '2023-10-11 06:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 1),
  (42, '2023-10-12 17:58:29', 'Sint occaecat cupidatat non proident, sunt in', 2),
  (43, '2023-10-13 21:10:09', 'Culpa qui officia deserunt mollit anim id est', 3),
  (44, '2023-10-14 10:30:15', 'Eiusmod tempor incididunt ut labore et dolore magna', 4),
  (45, '2023-10-15 19:15:02', 'Aliqua. Ut enim ad minim veniam, quis', 5),
  (46, '2023-10-16 08:20:39', 'Nostrud exercitation ullamco laboris nisi ut aliquip', 6),
  (47, '2023-10-17 05:46:01', 'Ex ea commodo consequat. Duis aute irure', 7),
  (48, '2023-10-18 16:40:25', 'Dolor in reprehenderit in voluptate velit esse', 8),
  (49, '2023-10-19 03:33:23', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 9),
  (50, '2023-10-20 14:47:45', 'Sint occaecat cupidatat non proident, sunt in', 10),
  (51, '2023-10-21 06:54:04', 'Culpa qui officia deserunt mollit anim id est', 11),
  (52, '2023-10-22 17:58:29', 'Eiusmod tempor incididunt ut labore et dolore magna', 12),
  (53, '2023-10-23 00:10:09', 'Aliqua. Ut enim ad minim veniam, quis', 13),
  (54, '2023-10-23 01:30:15', 'Nostrud exercitation ullamco laboris nisi ut', 14),
  (55, '2023-10-23 02:15:02', 'Ex ea commodo consequat. Duis aute irure', 15),
  (56, '2023-10-23 02:20:39', 'Dolor in reprehenderit in voluptate velit esse', 16),
  (57, '2023-10-23 02:46:01', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 17),
  (58, '2023-10-23 03:40:25', 'Sint occaecat cupidatat non proident, sunt in', 18),
  (59, '2023-10-23 04:33:23', 'Culpa qui officia deserunt mollit anim id est', 19),
  (60, '2023-10-23 04:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 20),
  (61, '2023-10-23 04:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 1),
  (62, '2023-10-23 04:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 2),
  (63, '2023-10-23 05:33:23', 'Ex ea commodo consequat. Duis aute irure', 3),
  (64, '2023-10-23 05:47:45', 'Dolor in reprehenderit in voluptate velit esse', 4),
  (65, '2023-10-23 05:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 5),
  (66, '2023-10-23 06:40:25', 'Sint occaecat cupidatat non proident, sunt in', 6),
  (67, '2023-10-23 07:33:23', 'Culpa qui officia deserunt mollit anim id est', 7),
  (68, '2023-10-23 07:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 8),
  (69, '2023-10-23 07:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 9),
  (70, '2023-10-23 07:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 10),
  (71, '2023-10-23 08:33:23', 'Ex ea commodo consequat. Duis aute irure', 11),
  (72, '2023-10-23 08:47:45', 'Dolor in reprehenderit in voluptate velit esse', 12),
  (73, '2023-10-23 08:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 13),
  (74, '2023-10-23 09:40:25', 'Sint occaecat cupidatat non proident, sunt in', 14),
  (75, '2023-10-23 10:33:23', 'Culpa qui officia deserunt mollit anim id est', 15),
  (76, '2023-10-23 10:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 16),
  (77, '2023-10-23 11:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 17),
  (78, '2023-10-23 11:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 18),
  (79, '2023-10-23 12:33:23', 'Ex ea commodo consequat. Duis aute irure', 19),
  (80, '2023-10-23 12:47:45', 'Dolor in reprehenderit in voluptate velit esse', 20),
  (81, '2023-10-23 12:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 1),
  (82, '2023-10-23 13:40:25', 'Sint occaecat cupidatat non proident, sunt in', 2),
  (83, '2023-10-23 14:33:23', 'Culpa qui officia deserunt mollit anim id est', 3),
  (84, '2023-10-23 14:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 4),
  (85, '2023-10-23 14:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 5),
  (86, '2023-10-23 14:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 6),
  (87, '2023-10-23 15:33:23', 'Ex ea commodo consequat. Duis aute irure', 7),
  (88, '2023-10-23 15:47:45', 'Dolor in reprehenderit in voluptate velit esse', 8),
  (89, '2023-10-23 15:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 9),
  (90, '2023-10-23 16:40:25', 'Sint occaecat cupidatat non proident, sunt in', 10),
  (91, '2023-10-23 17:33:23', 'Culpa qui officia deserunt mollit anim id est', 11),
  (92, '2023-10-23 17:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 12),
  (93, '2023-10-23 17:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 13),
  (94, '2023-10-23 17:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 14),
  (95, '2023-10-23 18:33:23', 'Ex ea commodo consequat. Duis aute irure', 15),
  (96, '2023-10-23 19:47:45', 'Dolor in reprehenderit in voluptate velit esse', 16),
  (97, '2023-10-23 20:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 17),
  (98, '2023-10-23 21:58:29', 'Sint occaecat cupidatat non proident, sunt in', 18),
  (99, '2023-10-23 22:33:23', 'Culpa qui officia deserunt mollit anim id est', 19),
  (100, '2023-10-23 22:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 20),
  (101, '2023-10-23 22:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 1),
  (102, '2023-10-23 22:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 2),
  (103, '2023-10-23 23:33:23', 'Ex ea commodo consequat. Duis aute irure', 3),
  (104, '2023-10-23 23:47:45', 'Dolor in reprehenderit in voluptate velit esse', 4),
  (105, '2023-10-23 23:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 5),
  (106, '2023-10-24 00:40:25', 'Sint occaecat cupidatat non proident, sunt in', 6),
  (107, '2023-10-24 01:33:23', 'Culpa qui officia deserunt mollit anim id est', 7),
  (108, '2023-10-24 01:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 8),
  (109, '2023-10-24 01:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 9),
  (110, '2023-10-24 01:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 10),
  (111, '2023-10-24 02:33:23', 'Ex ea commodo consequat. Duis aute irure', 11),
  (112, '2023-10-24 02:47:45', 'Dolor in reprehenderit in voluptate velit esse', 12),
  (113, '2023-10-24 02:54:04', 'Cillum dolore eu fugiat nulla pariatur. Excepteur', 13),
  (114, '2023-10-24 03:40:25', 'Sint occaecat cupidatat non proident, sunt in', 14),
  (115, '2023-10-24 04:33:23', 'Culpa qui officia deserunt mollit anim id est', 15),
  (116, '2023-10-24 04:47:45', 'Eiusmod tempor incididunt ut labore et dolore magna', 16),
  (117, '2023-10-24 04:54:04', 'Aliqua. Ut enim ad minim veniam, quis', 17),
  (118, '2023-10-24 04:58:29', 'Nostrud exercitation ullamco laboris nisi ut', 18),
  (119, '2023-10-24 05:33:23', 'Ex ea commodo consequat. Duis aute irure', 19),
  (120, '2023-10-24 05:47:45', 'Dolor in reprehenderit in voluptate velit esse', 20);

INSERT INTO Produto (id, nome, descricao, precoAtual, desconto, stock, id_administrador) VALUES
  (1, 'Pimenta Malagueta', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 3.99, 5, 100, 1),
  (2, 'Molho de Piri-Piri', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 4.50, 3, 75, 2),
  (3, 'Canela em Pau', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 6.25, 0, 250, 3),
  (4, 'Paprica Doce', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.', 8.75, 2, 150, 4),
  (5, 'Molho de Tomate Picante', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa.', 3.25, 4, 200, 5),
  (6, 'Noz-Moscada Moída', 'Qui officia deserunt mollit anim id est laborum.', 7.80, 1, 50, 1),
  (7, 'Molho de Mostarda', 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt.', 5.75, 7, 100, 2),
  (8, 'Alho em Pó', 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 6.50, 0, 300, 3),
  (9, 'Salsa Seca', 'Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.', 2.50, 9, 20, 4),
  (10, 'Molho de Soja Picante', 'Ut aliquip ex ea commodo consequat. Duis aute.', 4.99, 6, 350, 5),
  (11, 'Orégãos Secos', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 3.99, 5, 100, 1),
  (12, 'Molho de Piri-Piri', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 4.50, 3, 75, 2),
  (13, 'Canela em Pau', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 6.25, 0, 250, 3),
  (14, 'Paprica Doce', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.', 8.75, 2, 150, 4),
  (15, 'Molho de Tomate Picante', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa.', 3.25, 4, 200, 5),
  (16, 'Noz-Moscada Moída', 'Qui officia deserunt mollit anim id est laborum.', 7.80, 1, 50, 1),
  (17, 'Molho de Mostarda', 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt.', 5.75, 7, 100, 2),
  (18, 'Alho em Pó', 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 6.50, 0, 300, 3),
  (19, 'Salsa Seca', 'Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.', 2.50, 9, 20, 4),
  (20, 'Molho de Soja Picante', 'Ut aliquip ex ea commodo consequat. Duis aute.', 4.99, 6, 350, 5),
  (21, 'Orégãos Secos', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 3.99, 5, 100, 1),
  (22, 'Molho de Piri-Piri', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 4.50, 3, 75, 2),
  (23, 'Canela em Pau', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 6.25, 0, 250, 3),
  (24, 'Paprica Doce', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.', 8.75, 2, 150, 4),
  (25, 'Molho de Tomate Picante', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa.', 3.25, 4, 200, 5),
  (26, 'Noz-Moscada Moída', 'Qui officia deserunt mollit anim id est laborum.', 7.80, 1, 50, 1),
  (27, 'Molho de Mostarda', 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt.', 5.75, 7, 100, 2),
  (28, 'Alho em Pó', 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 6.50, 0, 300, 3),
  (29, 'Salsa Seca', 'Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.', 2.50, 9, 20, 4),
  (30, 'Molho de Soja Picante', 'Ut aliquip ex ea commodo consequat. Duis aute.', 4.99, 6, 350, 5),
  (31, 'Orégãos Secos', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 3.99, 5, 100, 1),
  (32, 'Molho de Piri-Piri', 'Sed do eiusmod tempor incididunt ut labore et dolore magna.', 4.50, 3, 75, 2),
  (33, 'Canela em Pau', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 6.25, 0, 250, 3),
  (34, 'Paprica Doce', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.', 8.75, 2, 150, 4),
  (35, 'Molho de Tomate Picante', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa.', 3.25, 4, 200, 5),
  (36, 'Noz-Moscada Moída', 'Qui officia deserunt mollit anim id est laborum.', 7.80, 1, 50, 1),
  (37, 'Molho de Mostarda', 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt.', 5.75, 7, 100, 2),
  (38, 'Alho em Pó', 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 6.50, 0, 300, 3),
  (39, 'Salsa Seca', 'Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.', 2.50, 9, 20, 4),
  (40, 'Molho de Soja Picante', 'Ut aliquip ex ea commodo consequat. Duis aute.', 4.99, 6, 350, 5),
  (41, 'Orégãos Secos', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 3.99, 5, 100, 1),
  (42, 'Molho de Piri-Piri', 'Sed do eiusmod tempor incididunt ut labore et dolore magna.', 4.50, 3, 75, 2),
  (43, 'Canela em Pau', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 6.25, 0, 250, 3),
  (44, 'Paprica Doce', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.', 8.75, 2, 150, 4),
  (45, 'Molho de Tomate Picante', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa.', 3.25, 4, 200, 5),
  (46, 'Noz-Moscada Moída', 'Qui officia deserunt mollit anim id est laborum.', 7.80, 1, 50, 1),
  (47, 'Molho de Mostarda', 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt.', 5.75, 7, 100, 2),
  (48, 'Alho em Pó', 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam.', 6.50, 0, 300, 3),
  (49, 'Salsa Seca', 'Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.', 2.50, 9, 20, 4),
  (50, 'Molho de Soja Picante', 'Ut aliquip ex ea commodo consequat. Duis aute.', 4.99, 6, 350, 5);

INSERT INTO Comentario (id, timestamp, texto, avaliacao, id_utilizador, id_produto) VALUES
  (1, '2023-08-15 08:15:30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 4, 20, 8),
  (2, '2023-08-16 10:20:45', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 3, 10, 15),
  (3, '2023-08-17 12:35:15', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.', 5, 8, 32),
  (4, '2023-08-18 14:45:59', 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.', 2, 12, 21),
  (5, '2023-08-19 16:55:37', 'Excepteur sint occaecat cupidatat non proident, sunt in culpa.', 1, 11, 5);

INSERT INTO Notificacao_Compra (id, id_compra) VALUES
  (1, 1),
  (2, 2),
  (3, 3),
  (4, 4),
  (5, 5),
  (6, 6),
  (7, 7),
  (8, 8),
  (9, 9),
  (10, 10),
  (11, 11),
  (12, 12),
  (13, 13),
  (14, 14),
  (15, 15),
  (16, 16),
  (17, 17),
  (18, 18),
  (19, 19),
  (20, 20),
  (21, 21),
  (22, 22),
  (23, 23),
  (24, 24),
  (25, 25),
  (26, 26),
  (27, 27),
  (28, 28),
  (29, 29),
  (30, 30),
  (31, 31),
  (32, 32),
  (33, 33),
  (34, 34),
  (35, 35),
  (36, 36),
  (37, 37),
  (38, 38),
  (39, 39),
  (40, 40),
  (41, 41),
  (42, 42),
  (43, 43),
  (44, 44),
  (45, 45),
  (46, 46),
  (47, 47),
  (48, 48),
  (49, 49),
  (50, 50),
  (51, 51),
  (52, 52),
  (53, 53),
  (54, 54),
  (55, 55),
  (56, 56),
  (57, 57),
  (58, 58),
  (59, 59),
  (60, 60),
  (61, 61),
  (62, 62),
  (63, 63),
  (64, 64),
  (65, 65),
  (66, 66),
  (67, 67),
  (68, 68),
  (69, 69),
  (70, 70),
  (71, 71),
  (72, 72),
  (73, 73),
  (74, 74),
  (75, 75),
  (76, 76),
  (77, 77),
  (78, 78),
  (79, 79),
  (80, 80),
  (81, 81),
  (82, 82),
  (83, 83),
  (84, 84),
  (85, 85),
  (86, 86),
  (87, 87),
  (88, 88),
  (89, 89),
  (90, 90),
  (91, 91),
  (92, 92),
  (93, 93),
  (94, 94),
  (95, 95),
  (96, 96),
  (97, 97),
  (98, 98),
  (99, 99),
  (100, 100);
