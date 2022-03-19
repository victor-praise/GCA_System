CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);

INSERT INTO users (username,name,role, password) VALUES ('v_nat','victor','student','$10$xouZfFgVhLPZ3qCRS664.ePEtc.0XewvdGXOvNt0pyFp33pyq3JkS');
INSERT INTO users (username,name,role, password) VALUES ('vic_tor','victor praise','student','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii');
INSERT INTO users (username,name,role, password) VALUES ( 'praise','victor praise','student','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii');
INSERT INTO users (username,name,role, password) VALUES ( 'james','victor praise','student','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii');
INSERT INTO users (username,name,role, password) VALUES ( 'john','victor praise','admin','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii');
INSERT INTO users (username,name,role, password) VALUES ( 'desai','victor praise','instructor','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii');
INSERT INTO users (username,name,role, password) VALUES ( 'yogesh','victor praise','ta','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii');
INSERT INTO users (username,name,role, password) VALUES ( 'vlad','victor praise','student','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii');
INSERT INTO users (username,name,role, password) VALUES ('paul','victor praise','student','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii');
INSERT INTO users (username,name,role, password) VALUES ( 'messi','victor praise','student','$2y$10$aiHSsEs9CNG0LTY7hk1sueMDneXSzYVu6KZRK40NwckuP3IOJK4ii');

select * from users;