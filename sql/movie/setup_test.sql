DROP TABLE IF EXISTS `movie`;
CREATE TABLE `movie`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `director` VARCHAR(100),
    `length` INT DEFAULT NULL,
    `year` INT NOT NULL DEFAULT 1900,
    `plot` TEXT,
    `image` VARCHAR(100) DEFAULT NULL,
    `subtext` CHAR(3) DEFAULT NULL,
    `speech` CHAR(3) DEFAULT NULL,
    `quality` CHAR(3) DEFAULT NULL,
    `format` CHAR(3) DEFAULT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

DELETE FROM `movie`;
INSERT INTO `movie` (`title`, `year`, `image`) VALUES
    ('Pulp fiction', 1994, 'pulp-fiction.jpg'),
    ('American Pie', 1999, 'american-pie.jpg'),
    ('Pokémon The Movie 2000', 1999, 'pokemon.jpg'),  
    ('Kopps', 2003, 'kopps.jpg'),
    ('From Dusk Till Dawn', 1996, 'from-dusk-till-dawn.jpg')
;

SELECT * FROM `movie`;
