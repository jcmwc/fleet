<?

/************************************************************\
* php-smsMode version 1.0, modified 28-Aug-06
/************************************************************\
* This library is free software; you can redistribute it
* and/or modify it under the terms of the GNU Lesser General
* Public License as published by the Free Software
* Foundation; either version 2.1 of the  License, or (at your
* option) any later version.
/************************************************************\
* PLEASE CHANGE THE FOLLOWING BEFORE RUNNING THIS SCRIPT.
\************************************************************/


// smsMode account details
define('MY_SQL_USER',		'user');
define('MY_SQL_PASSWORD',	'password');
define('MY_SQL_HOST', 		'localhost');
define('MY_SQL_DATABASE',	'database');

class DAO {


	function get_numeros() {
     mysql_connect(MY_SQL_HOST, MY_SQL_USER, MY_SQL_PASSWORD) OR die('Erreur de connexion à la base');
     mysql_select_db(MY_SQL_DATABASE) OR die('Erreur de sélection de la base');
     $requete = mysql_query('SELECT NUMERO FROM USER') OR die('Erreur de la requête MySQL');
     mysql_close();
     	
     /**
     * On récupère les données
     * Tant qu'une ligne sera présente, la boucle continuera
     */

     while($resultat = mysql_fetch_object($requete))
     {
          $nums[] = $resultat->NUMERO;
     }
     return $nums;
	}

}
?>