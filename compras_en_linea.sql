create DATABASE compras_en_linea;

create table album(
numero_album smallint auto_increment PRIMARY KEY,
titulo VARCHAR(50),
artista varchar(30),
genero varchar(20),
precio decimal(4,2),
existencias mediumint(11),
portada varchar(20)
);



create table cliente(
numero_cliente smallint auto_increment primary key,
nombre varchar(25),
apellido varchar(30),
direccion varchar(40),
codigo_postal varchar(5),
ciudad varchar(20),
correo_electronico varchar(35),
contraseña varchar(72),
ficha_token varchar(64),
rol tinyint(2) DEFAULT 0
);

INSERT INTO album (numero_album, titulo, artista, genero, precio, existencias, portada) VALUES
(1, 'Café Atlântico', 'Cesarie Evora', 'World', 3.00, 100, 'atlantico.png'),
(2, 'Rumba Azul', 'Caetano Veloso', 'Latin', 4.90, 50, 'RumbaAzul.png'),
(3, 'Survivor', 'Destiny''s Child', 'R&B', 3.00, 789, 'Survivor.png'),
(4, 'Oh Girl', 'The Chi-lites', 'Pop', 3.00, 2, NULL),
(5, 'Der Her ist mei getreu', 'Ton Koopman', 'Klasiek', 5.50, 30, NULL),
(6, 'Closing Time', 'Tom Waits', 'Rock', 3.00, 6, NULL),
(7, 'Irresistible', 'Celia Cruz', 'Latin', 3.50, 23, NULL),
(8, 'Marvin Gaye II', 'Marvin Gaye', 'R&B', 4.00, 154, NULL),
(9, 'Mi Sangre', 'Juanes', 'Latin', 3.90, 123, NULL),
(10, 'Greatest Hits 2', 'Queen', 'Rock', 3.00, 0, NULL),
(11, '3121', 'Prince', 'Rock', 3.45, 0, NULL),
(12, 'Antología I', 'Paco de Lucia', 'World', 3.00, 320, NULL);

create table orden (
numero_de_orden int auto_increment primary key,
numero_de_cliente smallint,
fecha datetime
);

create table articulo(
	numero_de_articulo smallint auto_increment primary key,
	numero_de_orden smallint,
	numero_de_album smallint,
	cantidad smallint,
	precio_de_venta decimal(4,2)
)

SELECT numero_de_orden, SUM(cantidad) AS Cantidad FROM articulo GROUP BY numero_de_orden WITH ROLLUP;

SELECT IFNULL(numero_de_orden,"TOTAL") AS Orden, SUM(cantidad) AS Cantidad FROM articulo GROUP BY numero_de_orden WITH ROLLUP;

SELECT numero_de_orden AS Orden, numero_de_album, SUM(cantidad) AS Cantidad FROM articulo GROUP BY numero_de_orden, numero_de_album WITH ROLLUP;

SELECT IFNULL(numero_de_orden,"Total") AS Orden, IFNULL(numero_de_album,"Subtotal") As Numero_de_album, SUM(cantidad) AS Cantidad FROM articulo GROUP BY numero_de_orden, numero_de_album WITH ROLLUP;

SELECT numero_album, album.titulo FROM album WHERE numero_album IN (SELECT numero_de_album FROM articulo);