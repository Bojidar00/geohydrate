<!DOCTYPE html>
<html>
    <head>
        <title>Page</title>
    </head>

<body>
<?php

$host= 'localhost';
$dbUser= 'root'; 
$dbPass= ''; 

if(!$dbConn=mysqli_connect($host, $dbUser, $dbPass)) {
 die('Не може да се осъществи връзка със сървъра.');
}
 $sql = 'CREATE Database geohydrate';
 if (!$queryResource=mysqli_query($dbConn,$sql))
 {
    die ('Грешка при създаване на базата данни: ');
 }
 
 include "config.php";

 $sql2 ="CREATE TABLE `pearson` (
    `pearson_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `job_location` varchar(100) NOT NULL,
    `education` varchar(100),
    `last_job` varchar(100),
    `job` varchar(100),
    `email` varchar(100) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $result = mysqli_query($dbConn,$sql2);
    if(!$result)
    die('Грешка при създаване на таблица pearson.');
    echo "Таблицa pearson е създадена!"; 

    $sql2 ="CREATE TABLE `news` (
      `news_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `title` varchar(100) NOT NULL,
      `content` TEXT NOT NULL,
      `pic` varchar(100)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
      $result = mysqli_query($dbConn,$sql2);
      if(!$result)
      die('Грешка при създаване на таблица news.');
      echo "Таблицa news е създадена!"; 

      $sql2 ="CREATE TABLE `users` (
        `user_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `username` varchar(100) NOT NULL,
        `password` varchar(100) NOT NULL,
        `access` int(1) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
        $result = mysqli_query($dbConn,$sql2);
        if(!$result)
        die('Грешка при създаване на таблица users.');
        echo "Таблицa users е създадена!"; 
        $sql2 ="CREATE TABLE `website_data` (
          `website_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
          `about` LONGTEXT NOT NULL,
          `Summary` MEDIUMTEXT NOT NULL,
          `Purpose` MEDIUMTEXT NOT NULL,
          `Meaning` MEDIUMTEXT NOT NULL,
          `Challenges` MEDIUMTEXT NOT NULL,
          `Scientific field` MEDIUMTEXT NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          $result = mysqli_query($dbConn,$sql2);
          if(!$result)
          die('Грешка при създаване на таблица website_data.');
          echo "Таблицa website_data е създадена!"; 

        $sql2 ="CREATE TABLE `files` (
          `file_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
          `name` varchar(100) NOT NULL,
          `access` int NOT NULL,
          `path` varchar(100) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          $result = mysqli_query($dbConn,$sql2);
          if(!$result)
          die('Грешка при създаване на таблица files.');
          echo "Таблицa files е създадена!";

        $sql2 ="CREATE TABLE `grafik` (
          `grafik_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
          `activity` varchar(100) NOT NULL,
          `deadline` varchar(100) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
          $result = mysqli_query($dbConn,$sql2);
          if(!$result)
          die('Грешка при създаване на таблица grafik.');
          echo "Таблицa grafik е създадена!"; 
          $sql2 ="CREATE TABLE `grafik_kolektiv` (
            `grafik_id` int(11) ,
            `pearson_id` int(11)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            $result = mysqli_query($dbConn,$sql2);
            if(!$result)
            die('Грешка при създаване на таблица grafik_kolektiv.');
            echo "Таблицa grafik_kolektiv е създадена!"; 
            $sql2 ="ALTER TABLE grafik_kolektiv ADD CONSTRAINT fk_grafik_id FOREIGN KEY ( grafik_id ) REFERENCES grafik ( grafik_id ) ON DELETE CASCADE;";
              $result = mysqli_query($dbConn,$sql2);
              if(!$result)
              die('Грешка при създаване на Fkey.');
              echo "Fkey е създаден!"; 
              $sql2 ="ALTER TABLE grafik_kolektiv ADD CONSTRAINT fk_pearson_id FOREIGN KEY ( pearson_id ) REFERENCES pearson ( pearson_id ) ON DELETE CASCADE;";
              $result = mysqli_query($dbConn,$sql2);
              if(!$result)
              die('Грешка при създаване на Fkey.');
              echo "Fkey е създаден!"; 
              $sql2 ="CREATE TABLE `result` (
                `result_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `result` varchar(100) NOT NULL
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
                $result = mysqli_query($dbConn,$sql2);
                if(!$result)
                die('Грешка при създаване на таблица result.');
                echo "Таблицa result е създадена!"; 
                $sql2 ="CREATE TABLE `grafik_result` (
                  `result_id` int(11) ,
                  `grafik_id` int(11)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
                  $result = mysqli_query($dbConn,$sql2);
                  if(!$result)
                  die('Грешка при създаване на таблица grafik_result.');
                  echo "Таблицa grafik_result е създадена!"; 

                  $sql2 ="ALTER TABLE grafik_result ADD CONSTRAINT fkgrafik_id FOREIGN KEY ( grafik_id ) REFERENCES grafik ( grafik_id ) ON DELETE CASCADE;";
              $result = mysqli_query($dbConn,$sql2);
              if(!$result)
              die('Грешка при създаване на Fkey.');
              echo "Fkey е създаден!"; 
              $sql2 ="ALTER TABLE grafik_result ADD CONSTRAINT fkresult_id FOREIGN KEY ( result_id ) REFERENCES result ( result_id ) ON DELETE CASCADE;";
              $result = mysqli_query($dbConn,$sql2);
              if(!$result)
              die('Грешка при създаване на Fkey.');
              echo "Fkey е създаден!"; 
                

    

      $sql3 ="INSERT INTO pearson (name,job_location, education,last_job,job,email)
      VALUES ('доц. д-р Орлин Димитров','Институт по океанология при БАН, гр. Варна, Секция: Морска геология и археология','Магистър, 1982 г. - МГУ, гр. София - Геология и проучване на полезни изкопаеми, Доктор, 1997 г. - РАН, Институт по физика на Земята, гр. Москва,','Доцент в ИО-БАН','Сеизмостратиграфия, Неотектоника, Океанология, Морска геология, Геоморфология.','ovdimitrov@gmail.com');";
        $result = mysqli_query($dbConn,$sql3);
        if(!$result)
        die('Грешка при insert.');
        echo "  Insert!"; 
        $sql3 ="INSERT INTO pearson (name,job_location, education,last_job,job,email)
        VALUES ('доц. д-р Орлин Димитров','Институт по океанология при БАН, гр. Варна, Секция: Морска геология и археология','Магистър, 1982 г. - МГУ, гр. София - Геология и проучване на полезни изкопаеми, Доктор, 1997 г. - РАН, Институт по физика на Земята, гр. Москва,','Доцент в ИО-БАН','Сеизмостратиграфия, Неотектоника, Океанология, Морска геология, Геоморфология.','ovdimitrov@gmail.com');";
          $result = mysqli_query($dbConn,$sql3);
          if(!$result)
          die('Грешка при insert.');
          echo "  Insert!"; 
          $sql3 ="INSERT INTO news (title,content,pic)
          VALUES ('Тест новина','дадва ажксладйжа дсйаодиайжосдхажи дйалжсйдоадйоасожд','Logo_IO.gif');";
            $result = mysqli_query($dbConn,$sql3);
            if(!$result)
            die('Грешка при insert.');
            $sql3 ="INSERT INTO news (title,content,pic)
            VALUES ('Тест новина2','asdsadasda asd asda дадва ажксладйжа дсйаодиайжосдхажи дйалжсйдоадйоасожд','Logo_IO.gif');";
              $result = mysqli_query($dbConn,$sql3);
              if(!$result)
              die('Грешка при insert.');
            echo "  Insert!";
            $sql3 ="INSERT INTO users (username,password,access)
            VALUES ('AVasilev','bcb52b932993bd3ca490bb2cb238c3ccf9a8cea7',1);";
              $result = mysqli_query($dbConn,$sql3);
              if(!$result)
              die('Грешка при insert.');
              echo "  Insert!"; 

   
    ?>

    </body>
    </html>