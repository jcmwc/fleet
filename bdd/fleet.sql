-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 10 Septembre 2015 à 09:38
-- Version du serveur :  5.5.44-0+deb8u1
-- Version de PHP :  5.6.12-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `fleet`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `analyseposition`(device_id INT,
      time datetime,
      valid tinyint(1),
      latitude double,
      longitude double,
      altitude double,
      speed double,
      course double,
      power double,
      address varchar(255),
      extended_info text
      )
BEGIN
  DECLARE protocol varchar(255);
  DECLARE IO66 varchar(255);
  DECLARE event varchar(255);
  DECLARE lastspeed double;
  DECLARE vplug INT;
  DECLARE vcompte_id INT;

  SET protocol = ExtractValue(extended_info, 
    '/info/protocol');

  SET lastspeed = 0;
  
  -- on regarde si l'enregistrement date de plus d'une heure
  IF time < now()+3600 THEN
    -- on recalcul la vitesse si nécessaire
    IF speed < 6 THEN
      SET lastspeed = speed;
      SET speed= 0;
    ELSE
      UPDATE phantom_device set lastdeplacement=time where devices_id=device_id;
    END IF;
  
    SELECT plug,compte_id INTO vplug,vcompte_id FROM phantom_device WHERE devices_id=device_id;
  	    
    IF protocol = 'teltonika' THEN
      SET IO66 = ExtractValue(extended_info, 
      '/info/io66');  
      UPDATE phantom_device SET info=concat(vplug,' ',vcompte_id) where devices_id=device_id;     
      IF cast(IO66 as signed)>1000 THEN 
        IF vplug = 0 THEN
          UPDATE phantom_device SET plug=1 where devices_id=device_id;
  		    INSERT INTO phantom_debranchement (devices_id, plug, time, compte_id) VALUES (device_id,1,now(),vcompte_id);
  		  END IF;
      ELSE
        IF vplug = 1 THEN
          UPDATE phantom_device SET plug=0 where devices_id=device_id;
  		    INSERT INTO phantom_debranchement (devices_id, plug, time, compte_id) VALUES (device_id,0,now(),vcompte_id);
  		  END IF;
      END IF;
    ELSE
       SET event = ExtractValue(extended_info, 
      '/info/event');  
      UPDATE phantom_device SET info='la' where devices_id=device_id;
      IF cast(event as signed) =22 THEN 
        IF vplug = 0 THEN
          UPDATE phantom_device SET plug=1 where devices_id=device_id;
  		    INSERT INTO phantom_debranchement (devices_id, plug, time, compte_id) VALUES (device_id,1,now(),vcompte_id);
  		  END IF;
      END IF;
      IF cast(event as signed)=23 THEN 
        IF vplug = 1 THEN
          UPDATE phantom_device SET plug=0 where devices_id=device_id;
  		    INSERT INTO phantom_debranchement (devices_id, plug, time, compte_id) VALUES (device_id,0,now(),vcompte_id);
  		  END IF;
      END IF;
    END IF;
  END IF;
  -- insertion dans la table position
  INSERT INTO positions (device_id, time, valid, latitude, longitude, altitude, speed, course, power, address, other,lastspeed,protocol)
  VALUES (device_id, time, valid, latitude, longitude, altitude, speed, course, power, address, extended_info,lastspeed,protocol);
  
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `application_settings`
--

CREATE TABLE IF NOT EXISTS `application_settings` (
`id` bigint(20) NOT NULL,
  `registrationEnabled` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `application_settings`
--

INSERT INTO `application_settings` (`id`, `registrationEnabled`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
`id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `uniqueId` varchar(255) DEFAULT NULL,
  `latestPosition_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `devices`
--

INSERT INTO `devices` (`id`, `name`, `uniqueId`, `latestPosition_id`) VALUES
(1, 'Device1', '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_addresscache`
--

CREATE TABLE IF NOT EXISTS `phantom_addresscache` (
`addresscache_id` int(11) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_agence_compte`
--

CREATE TABLE IF NOT EXISTS `phantom_agence_compte` (
`agence_compte_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `principal` tinyint(4) NOT NULL,
  `supprimer` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_agence_compte`
--

INSERT INTO `phantom_agence_compte` (`agence_compte_id`, `libelle`, `compte_id`, `principal`, `supprimer`) VALUES
(1, 'Agence 1', 1, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_agence_compte_usergps`
--

CREATE TABLE IF NOT EXISTS `phantom_agence_compte_usergps` (
  `agence_compte_id` int(11) NOT NULL,
  `usergps_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_alarme_compte`
--

CREATE TABLE IF NOT EXISTS `phantom_alarme_compte` (
`alarme_compte_id` int(11) NOT NULL,
  `typealarme_agence_id` int(11) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `agence_compte_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `valeur` varchar(20) NOT NULL,
  `supprimer` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_alarme_compte_device`
--

CREATE TABLE IF NOT EXISTS `phantom_alarme_compte_device` (
  `alarme_compte_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_alarme_compte_jour`
--

CREATE TABLE IF NOT EXISTS `phantom_alarme_compte_jour` (
  `alarme_compte_id` int(11) NOT NULL,
  `jour_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_alarme_compte_lieu`
--

CREATE TABLE IF NOT EXISTS `phantom_alarme_compte_lieu` (
  `alarme_compte_id` int(11) NOT NULL,
  `lieu_compte_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_alarme_compte_lieu_duree`
--

CREATE TABLE IF NOT EXISTS `phantom_alarme_compte_lieu_duree` (
  `alarme_compte_id` int(11) NOT NULL,
  `alarme_compte_lieu_id` int(11) NOT NULL,
  `date_entree` datetime NOT NULL,
  `device_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_alarme_compte_usergps`
--

CREATE TABLE IF NOT EXISTS `phantom_alarme_compte_usergps` (
  `alarme_compte_id` int(11) NOT NULL,
  `usergps_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_alarme_entretien`
--

CREATE TABLE IF NOT EXISTS `phantom_alarme_entretien` (
`alarme_entretien_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `km` int(11) NOT NULL,
  `date` date NOT NULL,
  `entretien_compte_id` int(11) NOT NULL,
  `supprimer` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_alerte`
--

CREATE TABLE IF NOT EXISTS `phantom_alerte` (
  `date_debut` datetime NOT NULL,
  `date_fin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_arbre`
--

CREATE TABLE IF NOT EXISTS `phantom_arbre` (
`arbre_id` int(11) NOT NULL,
  `gabarit_id` int(11) DEFAULT NULL,
  `pere` int(11) DEFAULT NULL,
  `supprimer` int(1) DEFAULT '0',
  `users_id_crea` int(11) DEFAULT NULL,
  `users_id_verrou` int(4) DEFAULT NULL,
  `arbre_id_alias` int(11) DEFAULT NULL,
  `secure` tinyint(1) NOT NULL DEFAULT '0',
  `ordre` int(11) NOT NULL,
  `etat_id` int(11) NOT NULL,
  `root` int(11) DEFAULT NULL,
  `arbre_id_import` int(11) NOT NULL DEFAULT '0',
  `datepublication` datetime NOT NULL,
  `datedepublication` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `phantom_arbre`
--

INSERT INTO `phantom_arbre` (`arbre_id`, `gabarit_id`, `pere`, `supprimer`, `users_id_crea`, `users_id_verrou`, `arbre_id_alias`, `secure`, `ordre`, `etat_id`, `root`, `arbre_id_import`, `datepublication`, `datedepublication`) VALUES
(1, 1, NULL, 0, -1, NULL, NULL, 0, 1, 1, NULL, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 3, 1, 0, -1, NULL, NULL, 0, 1, 2, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 3, 1, 0, -1, NULL, NULL, 0, 2, 2, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 2, 2, 0, -1, -1, NULL, 0, 1, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 2, 2, 2, -1, NULL, NULL, 0, 2, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 2, 2, 2, -1, NULL, NULL, 0, 2, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 7, 3, 0, -1, NULL, NULL, 0, 1, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 5, 3, 0, -1, NULL, NULL, 0, 2, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 6, 3, 0, -1, NULL, NULL, 0, 3, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 2, 3, 0, -1, -1, NULL, 0, 5, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 4, 3, 0, -1, NULL, NULL, 0, 6, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 8, 1, 0, -1, NULL, NULL, 0, 3, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 9, 1, 0, -1, NULL, NULL, 0, 4, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 10, 1, 0, -1, NULL, NULL, 0, 5, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 11, 1, 0, -1, NULL, NULL, 0, 6, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 9, 1, 2, -1, -1, NULL, 0, 7, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 12, 1, 0, -1, NULL, NULL, 0, 7, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 2, 1, 0, -1, NULL, NULL, 0, 8, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 2, 2, 2, -1, -1, NULL, 0, 2, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 6, 3, 0, -1, NULL, NULL, 0, 4, 1, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `phantom_categorie_compte`
--

CREATE TABLE IF NOT EXISTS `phantom_categorie_compte` (
`categorie_compte_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `supprimer` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_categorie_compte_device`
--

CREATE TABLE IF NOT EXISTS `phantom_categorie_compte_device` (
  `categorie_compte_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_cat_module`
--

CREATE TABLE IF NOT EXISTS `phantom_cat_module` (
`cat_module_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_cat_module`
--

INSERT INTO `phantom_cat_module` (`cat_module_id`, `libelle`) VALUES
(1, 'Temps réél'),
(2, 'Rapports'),
(3, 'Administration');

-- --------------------------------------------------------

--
-- Structure de la table `phantom_commercial`
--

CREATE TABLE IF NOT EXISTS `phantom_commercial` (
`commercial_id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `actif` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_commercial`
--

INSERT INTO `phantom_commercial` (`commercial_id`, `nom`, `prenom`, `actif`) VALUES
(1, 'Commercial1', 'commercial', 1);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_compte`
--

CREATE TABLE IF NOT EXISTS `phantom_compte` (
`compte_id` int(11) NOT NULL,
  `commercial_id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `codecreation` varchar(255) NOT NULL,
  `raisonsociale` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `cp` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL,
  `password` varchar(255) NOT NULL,
  `supprimer` tinyint(1) NOT NULL,
  `actif` tinyint(1) NOT NULL,
  `application_id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_compte`
--

INSERT INTO `phantom_compte` (`compte_id`, `commercial_id`, `nom`, `codecreation`, `raisonsociale`, `adresse`, `cp`, `ville`, `tel`, `email`, `date_creation`, `password`, `supprimer`, `actif`, `application_id`) VALUES
(1, 1, 'compte1', '1234', 'raison', 'adresse', '75000', 'Paris', '044444444', 'toto@toto.fr', '2015-09-09 21:36:11', '', 0, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_compte_log`
--

CREATE TABLE IF NOT EXISTS `phantom_compte_log` (
`compte_log_id` int(11) NOT NULL,
  `date_connexion` datetime NOT NULL,
  `compte_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_compte_log`
--

INSERT INTO `phantom_compte_log` (`compte_log_id`, `date_connexion`, `compte_id`) VALUES
(1, '2015-09-09 21:49:32', 1),
(2, '2015-09-09 22:19:11', 1),
(3, '2015-09-09 22:23:37', 1),
(4, '2015-09-09 22:27:21', 1),
(5, '2015-09-09 22:33:08', 1);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_compte_options`
--

CREATE TABLE IF NOT EXISTS `phantom_compte_options` (
  `compte_id` int(11) NOT NULL,
  `options_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_compte_options`
--

INSERT INTO `phantom_compte_options` (`compte_id`, `options_id`) VALUES
(1, 5),
(1, 1),
(1, 10),
(1, 14),
(1, 4),
(1, 2),
(1, 8);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_connexe`
--

CREATE TABLE IF NOT EXISTS `phantom_connexe` (
`connexe_id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `abstract` text NOT NULL,
  `lien` varchar(255) NOT NULL,
  `ext` varchar(4) DEFAULT NULL,
  `connexelangue_id` int(11) NOT NULL,
  `langue_id` int(11) NOT NULL,
  `supprimer` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_connexelangue`
--

CREATE TABLE IF NOT EXISTS `phantom_connexelangue` (
`connexelangue_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_connexelangue_content`
--

CREATE TABLE IF NOT EXISTS `phantom_connexelangue_content` (
  `connexelangue_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_content`
--

CREATE TABLE IF NOT EXISTS `phantom_content` (
`content_id` int(11) NOT NULL,
  `titre1` text CHARACTER SET latin1,
  `titre2` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `titre3` varchar(255) CHARACTER SET latin1 NOT NULL,
  `abstract` text CHARACTER SET latin1,
  `contenu` text CHARACTER SET latin1,
  `date_actu` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `ext` varchar(4) COLLATE utf8_bin DEFAULT NULL,
  `version_id` int(11) NOT NULL,
  `contenu_id` int(11) NOT NULL,
  `ext2` varchar(4) COLLATE utf8_bin DEFAULT NULL,
  `note` int(11) NOT NULL DEFAULT '0',
  `note1` int(11) NOT NULL,
  `note2` int(11) NOT NULL,
  `note3` int(11) NOT NULL,
  `note4` int(11) NOT NULL,
  `titre4` text CHARACTER SET latin1 NOT NULL,
  `titre5` text CHARACTER SET latin1 NOT NULL,
  `abstract3` text CHARACTER SET latin1 NOT NULL,
  `abstract4` text CHARACTER SET latin1 NOT NULL,
  `abstract5` text CHARACTER SET latin1 NOT NULL,
  `ext3` varchar(4) COLLATE utf8_bin DEFAULT NULL,
  `ext4` varchar(4) COLLATE utf8_bin DEFAULT NULL,
  `archive` tinyint(1) NOT NULL,
  `envoye` tinyint(1) NOT NULL,
  `twitter` tinyint(1) NOT NULL,
  `tva_id` int(11) NOT NULL DEFAULT '0',
  `fournisseur_id` int(11) NOT NULL DEFAULT '0',
  `ext5` varchar(4) COLLATE utf8_bin DEFAULT NULL,
  `titleseo` varchar(255) CHARACTER SET latin1 NOT NULL,
  `abstractseo` text CHARACTER SET latin1 NOT NULL,
  `robotseo` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `abstract2` text CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `phantom_content`
--

INSERT INTO `phantom_content` (`content_id`, `titre1`, `titre2`, `titre3`, `abstract`, `contenu`, `date_actu`, `date_fin`, `ext`, `version_id`, `contenu_id`, `ext2`, `note`, `note1`, `note2`, `note3`, `note4`, `titre4`, `titre5`, `abstract3`, `abstract4`, `abstract5`, `ext3`, `ext4`, `archive`, `envoye`, `twitter`, `tva_id`, `fournisseur_id`, `ext5`, `titleseo`, `abstractseo`, `robotseo`, `abstract2`) VALUES
(1, 'Fleet', 'contact@contact.fr', '', '/var/www/dev/fleet', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 1, NULL, 0, 0, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Fleet', '/var/www/dev/fleet', 'index,follow', ''),
(2, 'Pied', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 2, NULL, 0, 0, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Pied', '', 'index,follow', ''),
(3, 'Compte', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 3, NULL, 0, 0, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Compte', '', 'index,follow', ''),
(4, 'Mentions légales', 'Informations concernant la société', '', 'Misterfleet est une marque déposée par la société RUBYCOM.<br />\r\n<br />\r\nSiège social : 27b rue du petit Pont, 45000 Orléans.<br />\r\nTel : 02 38 71 60 88<br />\r\nStatut : SARL<br />\r\nNuméro de SIRET : 44842492900058<br />\r\nCapital social : 7500 €<br />\r\nCode NAF : télécommunications filaires 6110Z<br />\r\nDirigeant : Monsieur Jonathan LASSMAN<br />\r\nDirection Générale Misterfleet : Monsieur Matthieu LOGEL<br />', 'Directeur de la publication : Monsieur Matthieu LOGEL<br />\r\n<br />\r\nConception du site : Société <a target="_blank" href="http://www.agence-modedemploi.com">Modemploi</a><br />\r\nResponsable : Monsieur Antoine CHAUVEAU <br />\r\nSiège social : 8 rue des champs, 92600 Asnières Sur Seine<br />\r\n<br />\r\nHébergeur :&#160; Société Hexatom<br />\r\nContact : Monsieur Christophe&#160;BONNEFEMME<br />\r\nAdresse : 16-18 avenue de l''Europe, 78140 Vélizy<br />\r\nTel : 01 45 06 80 32<br />', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 4, NULL, 0, 0, 0, 0, 0, 'Informations relatives au site internet', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Mentions légales', 'Misterfleet est une marque déposée par la société RUBYCOM.\r\n\r\nSiège social : 27b rue du petit Pont, 45000 ...', 'index,follow', ''),
(16, 'Qui sommes-nous', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 16, NULL, 0, 0, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Qui sommes-nous', '', 'index,follow', ''),
(17, 'qui sommes-nous', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 17, NULL, 0, 0, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'qui sommes-nous', '', 'index,follow', ''),
(18, 'Métiers', '', '', 'A chaque métier la géolocalisation a ses avantages :<br />\r\n<br />\r\n<div class="uppercase title_style"><span class="bg_color">Techniciens</span></div>\r\n<img width="400" height="130" src="http://www.tracking-misterfleet.com/tpl/img/front_office/techniciens.jpg" alt="" /><br />\r\n<div class="uppercase title_style"><span class="bg_color"><br />\r\nTransporteurs</span></div>\r\n<img width="400" height="130" src="http://www.tracking-misterfleet.com/tpl/img/front_office/transport.jpg" alt="" /><br />\r\n<div class="uppercase title_style"><span class="bg_color"><br />\r\nAuto-écoles</span></div>\r\n<img width="400" height="130" src="http://www.tracking-misterfleet.com/tpl/img/front_office/auto-ecole.jpg" alt="" /><br />', '<div class="uppercase title_style"><span class="bg_color">Loueurs de véhicules</span></div>\r\n<img width="400" height="130" src="http://www.tracking-misterfleet.com/tpl/img/front_office/transport.jpg" alt="" /><br />\r\n<div class="uppercase title_style"><span class="bg_color"><br />\r\nForce de Vente</span></div>\r\n<img width="400" height="130" src="http://www.tracking-misterfleet.com/tpl/img/front_office/force-de-vente.jpg" alt="" /><br />\r\n<div class="uppercase title_style"><span class="bg_color"><br />\r\nAgent de Bâtiment</span></div>\r\n<img width="400" height="130" src="http://www.tracking-misterfleet.com/tpl/img/front_office/batiment.jpg" alt="" /><br />\r\n<div class="uppercase title_style"><span class="bg_color"><br />\r\nLivreurs, SAV, maintenance</span></div>\r\n<img width="400" height="130" src="http://www.tracking-misterfleet.com/tpl/img/front_office/transport.jpg" alt="" /><br />', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 18, NULL, 0, 0, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Metiers', 'A chaque métier la géolocalisation a ses avantages :\r\n-          ...', 'index,follow', ''),
(19, 'test jc', 'dsfsf', 'sdf', '&#160;sdf<br />\r\nsdf<br />\r\nsdf<br />\r\nsdf<br />\r\nsdf', '&#160;sdfsdf<br />\r\nsdf<br />\r\nsdf<br />\r\nsdf', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 19, NULL, 0, 0, 0, 0, 0, 'sdf', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'test jc', '&#160;sdf\r\nsdf\r\nsdf\r\nsdf\r\nsdf', 'index,follow', ''),
(5, 'Charte de confidentialité', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 5, NULL, 0, 0, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Charte de confidentialité', '', 'index,follow', ''),
(6, 'Crédits', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 6, NULL, 0, 0, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Crédits', '', 'index,follow', ''),
(7, 'Situation', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 7, NULL, 0, 1, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Situation', '', 'index,follow', ''),
(8, 'Cartographie', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 8, NULL, 0, 1, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Cartographie', '', 'index,follow', ''),
(9, 'Rapport véhicule', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 9, NULL, 0, 3, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Rapports véhicule', '', 'index,follow', ''),
(10, 'Aide', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 10, NULL, 0, 0, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Aide', '', 'index,follow', ''),
(11, 'Configuration', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 11, NULL, 0, 11, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Configuration', '', 'index,follow', ''),
(12, 'Fonctionnement', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 12, NULL, 0, 0, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Fonctionnement', '', 'index,follow', ''),
(13, 'Service', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 13, NULL, 0, 0, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Service', '', 'index,follow', ''),
(14, 'Eco conduite', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 14, NULL, 0, 0, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Eco conduite', '', 'index,follow', ''),
(15, 'Contact', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 15, NULL, 0, 0, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Contact', '', 'index,follow', ''),
(20, 'Rapport de flotte', '', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, 1, 20, NULL, 0, 3, 0, 0, 0, '', '', '', '', '', NULL, NULL, 0, 0, 0, 0, 0, NULL, 'Rapport de flotte', '', 'index,follow', '');

-- --------------------------------------------------------

--
-- Structure de la table `phantom_content_content`
--

CREATE TABLE IF NOT EXISTS `phantom_content_content` (
  `content_id_principal` int(11) NOT NULL,
  `content_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_contenu`
--

CREATE TABLE IF NOT EXISTS `phantom_contenu` (
`contenu_id` int(11) NOT NULL,
  `arbre_id` int(11) DEFAULT NULL,
  `langue_id` int(11) DEFAULT NULL,
  `translate` tinyint(4) NOT NULL DEFAULT '0',
  `nom` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `phantom_contenu`
--

INSERT INTO `phantom_contenu` (`contenu_id`, `arbre_id`, `langue_id`, `translate`, `nom`) VALUES
(1, 1, 1, 1, 'http://dev.madewithcaffeine.com/fleet/'),
(2, 2, 1, 1, 'pied'),
(3, 3, 1, 1, 'compte'),
(4, 4, 1, 1, 'mentions_legales'),
(5, 5, 1, 1, 'charte_de_confidentialite'),
(6, 6, 1, 1, 'credits'),
(7, 7, 1, 1, 'situation'),
(8, 8, 1, 1, 'cartographie'),
(9, 9, 1, 1, 'rapport'),
(10, 10, 1, 1, 'aide'),
(11, 11, 1, 1, 'compte'),
(12, 12, 1, 1, 'fonctionnement'),
(13, 13, 1, 1, 'service'),
(14, 14, 1, 1, 'eco_conduite'),
(15, 15, 1, 1, 'contact'),
(16, 16, 1, 1, 'qui_sommes-nous'),
(17, 17, 1, 1, 'qui_sommes-nous'),
(18, 18, 1, 1, 'metiers'),
(19, 19, 1, 1, 'test_jc'),
(20, 20, 1, 1, 'rapports_de_flotte');

-- --------------------------------------------------------

--
-- Structure de la table `phantom_debranchement`
--

CREATE TABLE IF NOT EXISTS `phantom_debranchement` (
`branchement_id` int(12) NOT NULL,
  `devices_id` int(8) NOT NULL,
  `compte_id` int(8) NOT NULL,
  `time` datetime NOT NULL,
  `plug` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_device`
--

CREATE TABLE IF NOT EXISTS `phantom_device` (
`device_id` int(11) NOT NULL,
  `devices_id` int(11) NOT NULL,
  `vieprivee` tinyint(4) NOT NULL,
  `modepieton` tinyint(4) NOT NULL,
  `type_compte_id` int(11) NOT NULL,
  `agence_compte_id` int(11) NOT NULL,
  `nomvehicule` varchar(255) NOT NULL,
  `immatriculation` varchar(255) NOT NULL,
  `chassis` varchar(255) NOT NULL,
  `marque` varchar(255) NOT NULL,
  `modele` varchar(255) NOT NULL,
  `kminit` int(11) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `kmactuel` int(11) NOT NULL,
  `consommation` float NOT NULL,
  `correctifkm` int(11) NOT NULL,
  `correctifh` int(11) NOT NULL,
  `type_moteur_id` int(11) NOT NULL,
  `consommationtype` tinyint(1) NOT NULL,
  `vitessemax` float(8,2) NOT NULL,
  `kilometreentretien` int(11) NOT NULL,
  `dateentretien` date NOT NULL,
  `nbheureentretien` int(11) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `IMEI` varchar(255) NOT NULL,
  `serialnumber` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL,
  `supprimer` tinyint(1) NOT NULL,
  `type_device_id` int(11) NOT NULL,
  `telboitier` varchar(255) NOT NULL,
  `unitid` int(11) NOT NULL,
  `lastid` int(11) NOT NULL,
  `plug` tinyint(1) NOT NULL,
  `lastdeplacement` datetime NOT NULL,
  `info` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_device`
--

INSERT INTO `phantom_device` (`device_id`, `devices_id`, `vieprivee`, `modepieton`, `type_compte_id`, `agence_compte_id`, `nomvehicule`, `immatriculation`, `chassis`, `marque`, `modele`, `kminit`, `tel`, `kmactuel`, `consommation`, `correctifkm`, `correctifh`, `type_moteur_id`, `consommationtype`, `vitessemax`, `kilometreentretien`, `dateentretien`, `nbheureentretien`, `compte_id`, `IMEI`, `serialnumber`, `date_creation`, `supprimer`, `type_device_id`, `telboitier`, `unitid`, `lastid`, `plug`, `lastdeplacement`, `info`) VALUES
(1, 1, 0, 0, 2, 1, 'boitier1', '', '', '', '', 0, '', 0, 0, 0, 0, 1, 0, 0.00, 0, '0000-00-00', 0, 1, '123456', '12344', '2015-09-09 21:36:57', 0, 1, '134456767', 0, 0, 0, '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Structure de la table `phantom_droits`
--

CREATE TABLE IF NOT EXISTS `phantom_droits` (
`droits_id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `droitarbre` tinyint(1) DEFAULT '0',
  `shortright` varchar(4) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_email`
--

CREATE TABLE IF NOT EXISTS `phantom_email` (
`email_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `exclu` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_entretien_compte`
--

CREATE TABLE IF NOT EXISTS `phantom_entretien_compte` (
`entretien_compte_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `supprimer` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_etat`
--

CREATE TABLE IF NOT EXISTS `phantom_etat` (
`etat_id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `style` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `phantom_etat`
--

INSERT INTO `phantom_etat` (`etat_id`, `libelle`, `style`) VALUES
(1, 'publié', 'enligne'),
(2, 'non publié', 'brouillon');

-- --------------------------------------------------------

--
-- Structure de la table `phantom_etat_moteur`
--

CREATE TABLE IF NOT EXISTS `phantom_etat_moteur` (
`etat_moteur_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `defaultcouleur` varchar(255) NOT NULL,
  `etat` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_etat_moteur`
--

INSERT INTO `phantom_etat_moteur` (`etat_moteur_id`, `libelle`, `defaultcouleur`, `etat`) VALUES
(1, 'Moteur éteint', '#FF0000', 0),
(2, 'Moteur allumé', '#00FF00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_etat_moteur_compte`
--

CREATE TABLE IF NOT EXISTS `phantom_etat_moteur_compte` (
`etat_moteur_compte_id` int(11) NOT NULL,
  `etat_moteur_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `couleur` varchar(255) NOT NULL,
  `compte_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_etat_sociaux`
--

CREATE TABLE IF NOT EXISTS `phantom_etat_sociaux` (
`etat_sociaux_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_etat_sociaux_compte`
--

CREATE TABLE IF NOT EXISTS `phantom_etat_sociaux_compte` (
`etat_sociaux_compte_id` int(11) NOT NULL,
  `etat_sociaux__id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `compte_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_fichiers`
--

CREATE TABLE IF NOT EXISTS `phantom_fichiers` (
`fichiers_id` int(11) NOT NULL,
  `content_id` int(11) DEFAULT NULL,
  `titre` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `abstract` text CHARACTER SET latin1,
  `ext` varchar(4) CHARACTER SET latin1 DEFAULT NULL,
  `nom_fichier` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `supprimer` tinyint(1) NOT NULL,
  `contenu` text CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_fournisseur`
--

CREATE TABLE IF NOT EXISTS `phantom_fournisseur` (
`fournisseur_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `supprimer` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_gabarit`
--

CREATE TABLE IF NOT EXISTS `phantom_gabarit` (
`gabarit_id` int(11) NOT NULL,
  `iconnormal` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `iconsecure` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `libelle` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `table_nom` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `nom_fichier` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `supprimer` tinyint(1) NOT NULL DEFAULT '0',
  `sitemap` tinyint(1) NOT NULL DEFAULT '0',
  `rss` tinyint(1) NOT NULL DEFAULT '0',
  `search` tinyint(1) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `phantom_gabarit`
--

INSERT INTO `phantom_gabarit` (`gabarit_id`, `iconnormal`, `iconsecure`, `libelle`, `table_nom`, `nom_fichier`, `supprimer`, `sitemap`, `rss`, `search`, `visible`) VALUES
(1, 'gif', 'gif', 'Site', 'content', 'index.php', 0, 0, 0, 0, 0),
(2, 'gif', 'gif', 'Contenu', 'content', 'contenu.php', 0, 0, 0, 0, 0),
(3, 'gif', 'gif', 'Dossier', 'content', 'index.php', 0, 0, 0, 0, 0),
(4, 'gif', 'gif', 'Parametre', 'content', 'parametre.php', 0, 0, 0, 0, 0),
(5, 'gif', 'gif', 'Cartographie', 'content', 'cartographie.php', 0, 0, 0, 0, 0),
(6, 'gif', 'gif', 'Rapport', 'content', 'rapport.php', 0, 0, 0, 0, 0),
(7, 'gif', 'gif', 'situation', 'content', 'situation.php', 0, 0, 0, 0, 0),
(8, 'gif', 'gif', 'Fonctionnement', 'content', 'fonctionnement.php', 0, 0, 0, 0, 0),
(9, 'gif', 'gif', 'Service', 'content', 'service.php', 0, 0, 0, 0, 0),
(10, 'gif', 'gif', 'Eco conduite', 'content', 'eco.php', 0, 0, 0, 0, 0),
(11, 'gif', 'gif', 'Contact', 'content', 'contact.php', 0, 0, 0, 0, 0),
(12, 'gif', 'gif', 'Qui sommes nous', 'content', 'qui_sommes-nous__.php', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_grille`
--

CREATE TABLE IF NOT EXISTS `phantom_grille` (
`grille_id` int(11) NOT NULL,
  `poids` float(8,2) NOT NULL,
  `prix` float(8,2) NOT NULL,
  `transport_id` int(11) NOT NULL,
  `supprimer` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_groupe`
--

CREATE TABLE IF NOT EXISTS `phantom_groupe` (
`groupe_id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_groupefront`
--

CREATE TABLE IF NOT EXISTS `phantom_groupefront` (
`groupefront_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `supprimer` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_groupefront_content`
--

CREATE TABLE IF NOT EXISTS `phantom_groupefront_content` (
  `groupefront_id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_groupefront_user`
--

CREATE TABLE IF NOT EXISTS `phantom_groupefront_user` (
  `groupefront_id` int(11) NOT NULL,
  `userfront_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_groupe_arbre`
--

CREATE TABLE IF NOT EXISTS `phantom_groupe_arbre` (
  `arbre_id` int(11) DEFAULT NULL,
  `groupe_id` int(11) DEFAULT NULL,
  `droits_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_groupe_droits`
--

CREATE TABLE IF NOT EXISTS `phantom_groupe_droits` (
  `droits_id` int(11) DEFAULT NULL,
  `groupe_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_groupe_gabarit`
--

CREATE TABLE IF NOT EXISTS `phantom_groupe_gabarit` (
  `groupe_id` int(11) DEFAULT NULL,
  `gabarit_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_groupe_users`
--

CREATE TABLE IF NOT EXISTS `phantom_groupe_users` (
  `groupe_id` int(11) NOT NULL,
  `users_id` int(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_inscript`
--

CREATE TABLE IF NOT EXISTS `phantom_inscript` (
`inscript_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `supprimer` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_jour`
--

CREATE TABLE IF NOT EXISTS `phantom_jour` (
  `jour_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_jour`
--

INSERT INTO `phantom_jour` (`jour_id`, `libelle`) VALUES
(1, 'Lundi'),
(2, 'Mardi'),
(3, 'Mercredi'),
(4, 'Jeudi'),
(5, 'Vendredi'),
(6, 'Samedi'),
(7, 'Dimanche');

-- --------------------------------------------------------

--
-- Structure de la table `phantom_jour_usersgps`
--

CREATE TABLE IF NOT EXISTS `phantom_jour_usersgps` (
  `jour_id` int(11) NOT NULL,
  `usergps_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_jour_usersgps`
--

INSERT INTO `phantom_jour_usersgps` (`jour_id`, `usergps_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_langue`
--

CREATE TABLE IF NOT EXISTS `phantom_langue` (
`langue_id` int(11) NOT NULL,
  `libelle` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `shortlib` varchar(4) COLLATE utf8_bin NOT NULL,
  `ext` varchar(4) COLLATE utf8_bin DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `phantom_langue`
--

INSERT INTO `phantom_langue` (`langue_id`, `libelle`, `shortlib`, `ext`, `active`) VALUES
(1, 'Français', 'fr', 'gif', 1);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_lieu_compte`
--

CREATE TABLE IF NOT EXISTS `phantom_lieu_compte` (
`lieu_compte_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `type_lieu_compte_id` int(11) NOT NULL,
  `agence_compte_id` int(11) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `icon` varchar(255) NOT NULL,
  `rayon` int(11) NOT NULL,
  `affichage` tinyint(1) NOT NULL,
  `alarme` tinyint(1) NOT NULL,
  `supprimer` tinyint(1) NOT NULL,
  `adresse` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_list_images`
--

CREATE TABLE IF NOT EXISTS `phantom_list_images` (
`images_id` int(11) NOT NULL,
  `titre1` varchar(255) NOT NULL,
  `nom_fichier1` varchar(255) NOT NULL,
  `titre2` varchar(255) NOT NULL,
  `ext1` varchar(4) NOT NULL,
  `ext2` varchar(4) NOT NULL,
  `nom_fichier2` varchar(4) NOT NULL,
  `lightbox` tinyint(1) NOT NULL,
  `contenulightbox` text NOT NULL,
  `supprimer` tinyint(1) NOT NULL,
  `content_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_list_val`
--

CREATE TABLE IF NOT EXISTS `phantom_list_val` (
`val_id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `val` varchar(255) NOT NULL,
  `supprimer` tinyint(1) NOT NULL,
  `content_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_log`
--

CREATE TABLE IF NOT EXISTS `phantom_log` (
`log_id` int(11) NOT NULL,
  `arbre_id` int(11) DEFAULT NULL,
  `langue_id` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_evt` datetime NOT NULL,
  `supprimer` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `phantom_log`
--

INSERT INTO `phantom_log` (`log_id`, `arbre_id`, `langue_id`, `users_id`, `libelle`, `date_evt`, `supprimer`) VALUES
(1, 12, NULL, -1, 'Modification d''etat du noeud', '2015-09-09 21:21:36', 0),
(2, 12, NULL, -1, 'Modification d''etat du noeud', '2015-09-09 21:21:41', 0),
(3, 5, NULL, -1, 'Suppression définitive du noeud', '2015-09-09 21:22:18', 0),
(4, 6, NULL, -1, 'Suppression définitive du noeud', '2015-09-09 21:22:18', 0),
(5, 19, NULL, -1, 'Suppression définitive du noeud', '2015-09-09 21:22:18', 0),
(6, 16, NULL, -1, 'Suppression définitive du noeud', '2015-09-09 21:22:18', 0),
(7, 1, NULL, -1, 'Modification d''etat du nom du noeud', '2015-09-09 21:29:23', 0),
(8, 1, NULL, -1, 'Modification du noeud (En ligne)', '2015-09-09 21:32:16', 0);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_module`
--

CREATE TABLE IF NOT EXISTS `phantom_module` (
`module_id` int(11) NOT NULL,
  `cat_module_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `shortright` varchar(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_module`
--

INSERT INTO `phantom_module` (`module_id`, `cat_module_id`, `libelle`, `shortright`) VALUES
(1, 1, 'Temps réél', 'REEL'),
(2, 1, 'Export', 'EXP'),
(3, 2, 'Rapports', 'RAPP'),
(7, 3, 'Véhicules', 'VEH'),
(8, 3, 'Lieux', 'LIEU'),
(9, 3, 'Alarmes', 'ALA'),
(10, 3, 'Utilisateurs', 'USER'),
(11, 3, 'Gestion du site', 'GSIT'),
(12, 3, 'Agences', 'AGE'),
(13, 3, 'Entretien', 'ENT');

-- --------------------------------------------------------

--
-- Structure de la table `phantom_module_usersgps`
--

CREATE TABLE IF NOT EXISTS `phantom_module_usersgps` (
  `module_id` int(11) NOT NULL,
  `usergps_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_module_usersgps`
--

INSERT INTO `phantom_module_usersgps` (`module_id`, `usergps_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_news`
--

CREATE TABLE IF NOT EXISTS `phantom_news` (
`news_id` int(11) NOT NULL,
  `texte` text NOT NULL,
  `date_creation` date NOT NULL,
  `supprimer` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_news`
--

INSERT INTO `phantom_news` (`news_id`, `texte`, `date_creation`, `supprimer`) VALUES
(1, 'blablabla', '2014-09-10', 0);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_newsletter`
--

CREATE TABLE IF NOT EXISTS `phantom_newsletter` (
`newsletter_id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `edito` text NOT NULL,
  `envoye` tinyint(1) NOT NULL,
  `supprimer` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_newsletterline`
--

CREATE TABLE IF NOT EXISTS `phantom_newsletterline` (
`newsletterline_id` int(11) NOT NULL,
  `newsletter_id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `lien` varchar(255) NOT NULL,
  `ext` varchar(4) DEFAULT NULL,
  `ordre` int(11) NOT NULL,
  `supprimer` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_options`
--

CREATE TABLE IF NOT EXISTS `phantom_options` (
`options_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `shortcut` varchar(4) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_options`
--

INSERT INTO `phantom_options` (`options_id`, `libelle`, `shortcut`) VALUES
(1, 'Rapports horaire', 'RAPH'),
(2, 'Entretien', 'ENTR'),
(4, 'Envoi de SMS', 'SMS'),
(5, 'Rapports par mail', 'RMAI'),
(8, 'Alarmes avancées', 'ALAR'),
(10, 'Rapport de flotte par agence', 'RFLO'),
(14, 'Export CSV', 'ECSV');

-- --------------------------------------------------------

--
-- Structure de la table `phantom_paysreference`
--

CREATE TABLE IF NOT EXISTS `phantom_paysreference` (
`paysreference_id` int(11) NOT NULL,
  `nompays` varchar(255) NOT NULL,
  `supprimer` tinyint(1) NOT NULL,
  `paysreferencelangue_id` int(11) NOT NULL,
  `langue_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_paysreferencelangue`
--

CREATE TABLE IF NOT EXISTS `phantom_paysreferencelangue` (
`paysreferencelangue_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_preference_compte`
--

CREATE TABLE IF NOT EXISTS `phantom_preference_compte` (
`preference_compte_id` int(11) NOT NULL,
  `delaimail` int(11) NOT NULL,
  `dureemintraj` int(11) NOT NULL,
  `dureeminattente` int(11) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `lastenvoi` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_preference_compte`
--

INSERT INTO `phantom_preference_compte` (`preference_compte_id`, `delaimail`, `dureemintraj`, `dureeminattente`, `compte_id`, `lastenvoi`) VALUES
(1, 60, 120, 180, 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `phantom_rapport`
--

CREATE TABLE IF NOT EXISTS `phantom_rapport` (
`rapport_id` int(11) NOT NULL,
  `date_envoi` date NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_rapport`
--

INSERT INTO `phantom_rapport` (`rapport_id`, `date_envoi`, `libelle`) VALUES
(4, '0000-00-00', 'Rapport kilométrique'),
(5, '0000-00-00', 'Rapport de flotte journalier'),
(6, '0000-00-00', 'Rapport de flotte hebdomadaire'),
(7, '0000-00-00', 'Rapport de flotte mensuel'),
(8, '0000-00-00', 'Rapport conducteur journalier'),
(9, '0000-00-00', 'Rapport conducteur hebdomadaire'),
(10, '0000-00-00', 'Rapport conducteur mensuel'),
(11, '0000-00-00', 'Alarme de vitesse'),
(12, '0000-00-00', 'Alarme d''entretien');

-- --------------------------------------------------------

--
-- Structure de la table `phantom_rapport_usersgps`
--

CREATE TABLE IF NOT EXISTS `phantom_rapport_usersgps` (
  `rapport_id` int(11) NOT NULL,
  `usergps_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_rapport_usersgps`
--

INSERT INTO `phantom_rapport_usersgps` (`rapport_id`, `usergps_id`) VALUES
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_status`
--

CREATE TABLE IF NOT EXISTS `phantom_status` (
`status_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_tag`
--

CREATE TABLE IF NOT EXISTS `phantom_tag` (
`tag_id` int(11) NOT NULL,
  `libelle` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `ponderation` int(11) DEFAULT NULL,
  `supprimer` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_tag_content`
--

CREATE TABLE IF NOT EXISTS `phantom_tag_content` (
  `tag_id` int(11) DEFAULT NULL,
  `content_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_tag_search`
--

CREATE TABLE IF NOT EXISTS `phantom_tag_search` (
`tag_search_id` int(11) NOT NULL,
  `libelle` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `supprimer` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_tag_search_content`
--

CREATE TABLE IF NOT EXISTS `phantom_tag_search_content` (
  `content_id` int(11) DEFAULT NULL,
  `tag_search_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_traduction`
--

CREATE TABLE IF NOT EXISTS `phantom_traduction` (
`traduction_id` int(11) NOT NULL,
  `langue_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `supprimer` tinyint(4) NOT NULL,
  `libelle_trad` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_typealarme_agence`
--

CREATE TABLE IF NOT EXISTS `phantom_typealarme_agence` (
`typealarme_agence_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `libchamps` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_typealarme_agence`
--

INSERT INTO `phantom_typealarme_agence` (`typealarme_agence_id`, `libelle`, `libchamps`, `type`) VALUES
(1, 'Temps d''arrêt insuffisant', 'Temps d''arrêt insuffisant (min)', 1),
(2, 'Durée de conduite anormale', 'Temps de conduite (min)', 1),
(3, 'Embauche tardive', 'Heure (HH:MM) ', 1),
(4, 'Distance quotidienne excessive', 'Distance (km) ', 1),
(5, 'Distance quotidienne insuffisante', 'Distance (en kms)', 1),
(6, 'Vitesse moyenne insuffisante', 'Vitesse moyenne (en km/h)', 1),
(7, 'Vitesse moyenne excessive', 'Vitesse moyenne (en km/h)', 1),
(8, 'Temps de d''arrêt journalier excessif', 'Temps d''arrêt (en minutes) :', 1),
(9, 'Temps de conduite journalier insuffisant', 'Temps de conduite (en minutes)', 1),
(10, 'Alarme standard', 'alarmeradio', 2),
(11, 'Temps de présence dans un lieu anormal', 'alarmetxt', 2);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_typereference`
--

CREATE TABLE IF NOT EXISTS `phantom_typereference` (
`typereference_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `supprimer` tinyint(1) NOT NULL,
  `typereferencelangue_id` int(11) NOT NULL,
  `langue_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_typereferencelangue`
--

CREATE TABLE IF NOT EXISTS `phantom_typereferencelangue` (
`typereferencelangue_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_type_compte`
--

CREATE TABLE IF NOT EXISTS `phantom_type_compte` (
`type_compte_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `consommation` float(8,2) NOT NULL,
  `vitesseattente` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `supprimer` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_type_compte`
--

INSERT INTO `phantom_type_compte` (`type_compte_id`, `libelle`, `compte_id`, `consommation`, `vitesseattente`, `icon`, `supprimer`) VALUES
(1, 'Voiture', 1, 0.00, 0, 'car_icon.png', 0),
(2, 'Camion', 1, 0.00, 0, 'supercamion_icon.png', 0),
(3, 'Utilitaire', 1, 0.00, 0, 'camion_icon.png', 0);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_type_device`
--

CREATE TABLE IF NOT EXISTS `phantom_type_device` (
`type_device_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_type_device`
--

INSERT INTO `phantom_type_device` (`type_device_id`, `libelle`) VALUES
(1, 'Orion'),
(2, 'Teltonika');

-- --------------------------------------------------------

--
-- Structure de la table `phantom_type_lieu_compte`
--

CREATE TABLE IF NOT EXISTS `phantom_type_lieu_compte` (
`type_lieu_compte_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `supprimer` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_type_moteur`
--

CREATE TABLE IF NOT EXISTS `phantom_type_moteur` (
`type_moteur_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_type_moteur`
--

INSERT INTO `phantom_type_moteur` (`type_moteur_id`, `libelle`) VALUES
(1, 'Diesel'),
(2, 'Essence'),
(3, 'Hybride'),
(4, 'Electrique');

-- --------------------------------------------------------

--
-- Structure de la table `phantom_userfront`
--

CREATE TABLE IF NOT EXISTS `phantom_userfront` (
`userfront_id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `supprimer` tinyint(1) NOT NULL,
  `compte_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_userfrontcat`
--

CREATE TABLE IF NOT EXISTS `phantom_userfrontcat` (
`userfrontcat_id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_usergps`
--

CREATE TABLE IF NOT EXISTS `phantom_usergps` (
`usergps_id` int(11) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `compte_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `supprimer` tinyint(1) NOT NULL,
  `date_creation` datetime NOT NULL,
  `sms` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_usergps`
--

INSERT INTO `phantom_usergps` (`usergps_id`, `tel`, `compte_id`, `name`, `email`, `password`, `username`, `supprimer`, `date_creation`, `sms`) VALUES
(1, '0998888', 1, 'user1', 'toto@toto.fr', '5f4dcc3b5aa765d61d8327deb882cf99', 'user1', 0, '2015-09-09 21:37:25', 0);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_usergps_device`
--

CREATE TABLE IF NOT EXISTS `phantom_usergps_device` (
  `usergps_id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `phantom_usergps_device`
--

INSERT INTO `phantom_usergps_device` (`usergps_id`, `device_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `phantom_users`
--

CREATE TABLE IF NOT EXISTS `phantom_users` (
`users_id` int(11) NOT NULL,
  `login` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `mdp` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `supprimer` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `phantom_version`
--

CREATE TABLE IF NOT EXISTS `phantom_version` (
`version_id` int(11) NOT NULL,
  `libelle` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `phantom_version`
--

INSERT INTO `phantom_version` (`version_id`, `libelle`) VALUES
(1, 'En ligne'),
(2, 'Brouillon');

-- --------------------------------------------------------

--
-- Structure de la table `positions`
--

CREATE TABLE IF NOT EXISTS `positions` (
`id` bigint(20) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `altitude` double DEFAULT NULL,
  `course` double DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `other` text,
  `power` double DEFAULT NULL,
  `speed` double DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `valid` tinyint(1) DEFAULT NULL,
  `device_id` bigint(20) DEFAULT NULL,
  `dateserver` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastspeed` double NOT NULL,
  `protocol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` bigint(20) NOT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `userSettings_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `admin`, `login`, `password`, `userSettings_id`) VALUES
(1, 1, 'admin', 'admin', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users_devices`
--

CREATE TABLE IF NOT EXISTS `users_devices` (
  `users_id` bigint(20) NOT NULL,
  `devices_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users_devices`
--

INSERT INTO `users_devices` (`users_id`, `devices_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_settings`
--

CREATE TABLE IF NOT EXISTS `user_settings` (
`id` bigint(20) NOT NULL,
  `speedUnit` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `application_settings`
--
ALTER TABLE `application_settings`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `devices`
--
ALTER TABLE `devices`
 ADD PRIMARY KEY (`id`), ADD KEY `FK5CF8ACDD7C6208C3` (`latestPosition_id`);

--
-- Index pour la table `phantom_addresscache`
--
ALTER TABLE `phantom_addresscache`
 ADD PRIMARY KEY (`addresscache_id`);

--
-- Index pour la table `phantom_agence_compte`
--
ALTER TABLE `phantom_agence_compte`
 ADD PRIMARY KEY (`agence_compte_id`);

--
-- Index pour la table `phantom_alarme_compte`
--
ALTER TABLE `phantom_alarme_compte`
 ADD PRIMARY KEY (`alarme_compte_id`);

--
-- Index pour la table `phantom_alarme_entretien`
--
ALTER TABLE `phantom_alarme_entretien`
 ADD PRIMARY KEY (`alarme_entretien_id`);

--
-- Index pour la table `phantom_arbre`
--
ALTER TABLE `phantom_arbre`
 ADD PRIMARY KEY (`arbre_id`), ADD KEY `etat_id` (`etat_id`), ADD KEY `gabarit_id` (`gabarit_id`), ADD KEY `pere` (`pere`), ADD KEY `users_id_crea` (`users_id_crea`), ADD KEY `users_id_verrou` (`users_id_verrou`), ADD KEY `arbre_id_alias` (`arbre_id_alias`), ADD KEY `root` (`root`);

--
-- Index pour la table `phantom_categorie_compte`
--
ALTER TABLE `phantom_categorie_compte`
 ADD PRIMARY KEY (`categorie_compte_id`);

--
-- Index pour la table `phantom_cat_module`
--
ALTER TABLE `phantom_cat_module`
 ADD PRIMARY KEY (`cat_module_id`);

--
-- Index pour la table `phantom_commercial`
--
ALTER TABLE `phantom_commercial`
 ADD PRIMARY KEY (`commercial_id`);

--
-- Index pour la table `phantom_compte`
--
ALTER TABLE `phantom_compte`
 ADD PRIMARY KEY (`compte_id`);

--
-- Index pour la table `phantom_compte_log`
--
ALTER TABLE `phantom_compte_log`
 ADD PRIMARY KEY (`compte_log_id`);

--
-- Index pour la table `phantom_connexe`
--
ALTER TABLE `phantom_connexe`
 ADD PRIMARY KEY (`connexe_id`);

--
-- Index pour la table `phantom_connexelangue`
--
ALTER TABLE `phantom_connexelangue`
 ADD PRIMARY KEY (`connexelangue_id`);

--
-- Index pour la table `phantom_content`
--
ALTER TABLE `phantom_content`
 ADD PRIMARY KEY (`content_id`), ADD KEY `contenu_id` (`contenu_id`), ADD KEY `version_id` (`version_id`), ADD FULLTEXT KEY `titre1` (`titre1`,`titre2`,`titre3`,`abstract`,`contenu`,`abstract3`,`abstract4`,`abstract5`);

--
-- Index pour la table `phantom_contenu`
--
ALTER TABLE `phantom_contenu`
 ADD PRIMARY KEY (`contenu_id`), ADD KEY `arbre_id` (`arbre_id`), ADD KEY `langue_id` (`langue_id`);

--
-- Index pour la table `phantom_debranchement`
--
ALTER TABLE `phantom_debranchement`
 ADD PRIMARY KEY (`branchement_id`);

--
-- Index pour la table `phantom_device`
--
ALTER TABLE `phantom_device`
 ADD PRIMARY KEY (`device_id`);

--
-- Index pour la table `phantom_droits`
--
ALTER TABLE `phantom_droits`
 ADD PRIMARY KEY (`droits_id`);

--
-- Index pour la table `phantom_email`
--
ALTER TABLE `phantom_email`
 ADD PRIMARY KEY (`email_id`);

--
-- Index pour la table `phantom_entretien_compte`
--
ALTER TABLE `phantom_entretien_compte`
 ADD PRIMARY KEY (`entretien_compte_id`);

--
-- Index pour la table `phantom_etat`
--
ALTER TABLE `phantom_etat`
 ADD PRIMARY KEY (`etat_id`);

--
-- Index pour la table `phantom_etat_moteur`
--
ALTER TABLE `phantom_etat_moteur`
 ADD PRIMARY KEY (`etat_moteur_id`);

--
-- Index pour la table `phantom_etat_moteur_compte`
--
ALTER TABLE `phantom_etat_moteur_compte`
 ADD PRIMARY KEY (`etat_moteur_compte_id`);

--
-- Index pour la table `phantom_etat_sociaux`
--
ALTER TABLE `phantom_etat_sociaux`
 ADD PRIMARY KEY (`etat_sociaux_id`);

--
-- Index pour la table `phantom_etat_sociaux_compte`
--
ALTER TABLE `phantom_etat_sociaux_compte`
 ADD PRIMARY KEY (`etat_sociaux_compte_id`);

--
-- Index pour la table `phantom_fichiers`
--
ALTER TABLE `phantom_fichiers`
 ADD PRIMARY KEY (`fichiers_id`), ADD KEY `content_id` (`content_id`), ADD FULLTEXT KEY `titre` (`titre`,`abstract`,`contenu`);

--
-- Index pour la table `phantom_fournisseur`
--
ALTER TABLE `phantom_fournisseur`
 ADD PRIMARY KEY (`fournisseur_id`);

--
-- Index pour la table `phantom_gabarit`
--
ALTER TABLE `phantom_gabarit`
 ADD PRIMARY KEY (`gabarit_id`);

--
-- Index pour la table `phantom_grille`
--
ALTER TABLE `phantom_grille`
 ADD PRIMARY KEY (`grille_id`);

--
-- Index pour la table `phantom_groupe`
--
ALTER TABLE `phantom_groupe`
 ADD PRIMARY KEY (`groupe_id`);

--
-- Index pour la table `phantom_groupefront`
--
ALTER TABLE `phantom_groupefront`
 ADD PRIMARY KEY (`groupefront_id`);

--
-- Index pour la table `phantom_inscript`
--
ALTER TABLE `phantom_inscript`
 ADD PRIMARY KEY (`inscript_id`);

--
-- Index pour la table `phantom_jour`
--
ALTER TABLE `phantom_jour`
 ADD PRIMARY KEY (`jour_id`);

--
-- Index pour la table `phantom_langue`
--
ALTER TABLE `phantom_langue`
 ADD PRIMARY KEY (`langue_id`);

--
-- Index pour la table `phantom_lieu_compte`
--
ALTER TABLE `phantom_lieu_compte`
 ADD PRIMARY KEY (`lieu_compte_id`);

--
-- Index pour la table `phantom_list_images`
--
ALTER TABLE `phantom_list_images`
 ADD PRIMARY KEY (`images_id`);

--
-- Index pour la table `phantom_list_val`
--
ALTER TABLE `phantom_list_val`
 ADD PRIMARY KEY (`val_id`);

--
-- Index pour la table `phantom_log`
--
ALTER TABLE `phantom_log`
 ADD PRIMARY KEY (`log_id`), ADD KEY `arbre_id` (`arbre_id`), ADD KEY `users_id` (`users_id`);

--
-- Index pour la table `phantom_module`
--
ALTER TABLE `phantom_module`
 ADD PRIMARY KEY (`module_id`);

--
-- Index pour la table `phantom_news`
--
ALTER TABLE `phantom_news`
 ADD PRIMARY KEY (`news_id`);

--
-- Index pour la table `phantom_newsletter`
--
ALTER TABLE `phantom_newsletter`
 ADD PRIMARY KEY (`newsletter_id`);

--
-- Index pour la table `phantom_newsletterline`
--
ALTER TABLE `phantom_newsletterline`
 ADD PRIMARY KEY (`newsletterline_id`);

--
-- Index pour la table `phantom_options`
--
ALTER TABLE `phantom_options`
 ADD PRIMARY KEY (`options_id`);

--
-- Index pour la table `phantom_paysreference`
--
ALTER TABLE `phantom_paysreference`
 ADD PRIMARY KEY (`paysreference_id`);

--
-- Index pour la table `phantom_paysreferencelangue`
--
ALTER TABLE `phantom_paysreferencelangue`
 ADD PRIMARY KEY (`paysreferencelangue_id`);

--
-- Index pour la table `phantom_preference_compte`
--
ALTER TABLE `phantom_preference_compte`
 ADD PRIMARY KEY (`preference_compte_id`);

--
-- Index pour la table `phantom_rapport`
--
ALTER TABLE `phantom_rapport`
 ADD PRIMARY KEY (`rapport_id`);

--
-- Index pour la table `phantom_status`
--
ALTER TABLE `phantom_status`
 ADD PRIMARY KEY (`status_id`);

--
-- Index pour la table `phantom_tag`
--
ALTER TABLE `phantom_tag`
 ADD PRIMARY KEY (`tag_id`), ADD FULLTEXT KEY `libelle` (`libelle`);

--
-- Index pour la table `phantom_tag_content`
--
ALTER TABLE `phantom_tag_content`
 ADD KEY `tag_id` (`tag_id`), ADD KEY `content_id` (`content_id`);

--
-- Index pour la table `phantom_tag_search`
--
ALTER TABLE `phantom_tag_search`
 ADD PRIMARY KEY (`tag_search_id`), ADD FULLTEXT KEY `libelle` (`libelle`);

--
-- Index pour la table `phantom_tag_search_content`
--
ALTER TABLE `phantom_tag_search_content`
 ADD KEY `content_id` (`content_id`), ADD KEY `tag_search_id` (`tag_search_id`);

--
-- Index pour la table `phantom_traduction`
--
ALTER TABLE `phantom_traduction`
 ADD PRIMARY KEY (`traduction_id`), ADD KEY `langue_id` (`langue_id`);

--
-- Index pour la table `phantom_typealarme_agence`
--
ALTER TABLE `phantom_typealarme_agence`
 ADD PRIMARY KEY (`typealarme_agence_id`);

--
-- Index pour la table `phantom_typereference`
--
ALTER TABLE `phantom_typereference`
 ADD PRIMARY KEY (`typereference_id`);

--
-- Index pour la table `phantom_typereferencelangue`
--
ALTER TABLE `phantom_typereferencelangue`
 ADD PRIMARY KEY (`typereferencelangue_id`);

--
-- Index pour la table `phantom_type_compte`
--
ALTER TABLE `phantom_type_compte`
 ADD PRIMARY KEY (`type_compte_id`);

--
-- Index pour la table `phantom_type_device`
--
ALTER TABLE `phantom_type_device`
 ADD PRIMARY KEY (`type_device_id`);

--
-- Index pour la table `phantom_type_lieu_compte`
--
ALTER TABLE `phantom_type_lieu_compte`
 ADD PRIMARY KEY (`type_lieu_compte_id`);

--
-- Index pour la table `phantom_type_moteur`
--
ALTER TABLE `phantom_type_moteur`
 ADD PRIMARY KEY (`type_moteur_id`);

--
-- Index pour la table `phantom_userfront`
--
ALTER TABLE `phantom_userfront`
 ADD PRIMARY KEY (`userfront_id`);

--
-- Index pour la table `phantom_userfrontcat`
--
ALTER TABLE `phantom_userfrontcat`
 ADD PRIMARY KEY (`userfrontcat_id`);

--
-- Index pour la table `phantom_usergps`
--
ALTER TABLE `phantom_usergps`
 ADD PRIMARY KEY (`usergps_id`);

--
-- Index pour la table `phantom_users`
--
ALTER TABLE `phantom_users`
 ADD PRIMARY KEY (`users_id`);

--
-- Index pour la table `phantom_version`
--
ALTER TABLE `phantom_version`
 ADD PRIMARY KEY (`version_id`);

--
-- Index pour la table `positions`
--
ALTER TABLE `positions`
 ADD PRIMARY KEY (`id`), ADD KEY `FK65C08C6ADB0C3B8A` (`device_id`), ADD KEY `positionsIndex` (`device_id`,`time`), ADD KEY `device_id` (`device_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD KEY `FK6A68E0862018CAA` (`userSettings_id`);

--
-- Index pour la table `users_devices`
--
ALTER TABLE `users_devices`
 ADD KEY `FK81E459A68294BA3` (`devices_id`), ADD KEY `FK81E459A6712480D` (`users_id`);

--
-- Index pour la table `user_settings`
--
ALTER TABLE `user_settings`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `application_settings`
--
ALTER TABLE `application_settings`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `devices`
--
ALTER TABLE `devices`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `phantom_addresscache`
--
ALTER TABLE `phantom_addresscache`
MODIFY `addresscache_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_agence_compte`
--
ALTER TABLE `phantom_agence_compte`
MODIFY `agence_compte_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `phantom_alarme_compte`
--
ALTER TABLE `phantom_alarme_compte`
MODIFY `alarme_compte_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_alarme_entretien`
--
ALTER TABLE `phantom_alarme_entretien`
MODIFY `alarme_entretien_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_arbre`
--
ALTER TABLE `phantom_arbre`
MODIFY `arbre_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `phantom_categorie_compte`
--
ALTER TABLE `phantom_categorie_compte`
MODIFY `categorie_compte_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_cat_module`
--
ALTER TABLE `phantom_cat_module`
MODIFY `cat_module_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `phantom_commercial`
--
ALTER TABLE `phantom_commercial`
MODIFY `commercial_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `phantom_compte`
--
ALTER TABLE `phantom_compte`
MODIFY `compte_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `phantom_compte_log`
--
ALTER TABLE `phantom_compte_log`
MODIFY `compte_log_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `phantom_connexe`
--
ALTER TABLE `phantom_connexe`
MODIFY `connexe_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_connexelangue`
--
ALTER TABLE `phantom_connexelangue`
MODIFY `connexelangue_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_content`
--
ALTER TABLE `phantom_content`
MODIFY `content_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `phantom_contenu`
--
ALTER TABLE `phantom_contenu`
MODIFY `contenu_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `phantom_debranchement`
--
ALTER TABLE `phantom_debranchement`
MODIFY `branchement_id` int(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_device`
--
ALTER TABLE `phantom_device`
MODIFY `device_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `phantom_droits`
--
ALTER TABLE `phantom_droits`
MODIFY `droits_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_email`
--
ALTER TABLE `phantom_email`
MODIFY `email_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_entretien_compte`
--
ALTER TABLE `phantom_entretien_compte`
MODIFY `entretien_compte_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_etat`
--
ALTER TABLE `phantom_etat`
MODIFY `etat_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `phantom_etat_moteur`
--
ALTER TABLE `phantom_etat_moteur`
MODIFY `etat_moteur_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `phantom_etat_moteur_compte`
--
ALTER TABLE `phantom_etat_moteur_compte`
MODIFY `etat_moteur_compte_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_etat_sociaux`
--
ALTER TABLE `phantom_etat_sociaux`
MODIFY `etat_sociaux_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_etat_sociaux_compte`
--
ALTER TABLE `phantom_etat_sociaux_compte`
MODIFY `etat_sociaux_compte_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_fichiers`
--
ALTER TABLE `phantom_fichiers`
MODIFY `fichiers_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_fournisseur`
--
ALTER TABLE `phantom_fournisseur`
MODIFY `fournisseur_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_gabarit`
--
ALTER TABLE `phantom_gabarit`
MODIFY `gabarit_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `phantom_grille`
--
ALTER TABLE `phantom_grille`
MODIFY `grille_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_groupe`
--
ALTER TABLE `phantom_groupe`
MODIFY `groupe_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_groupefront`
--
ALTER TABLE `phantom_groupefront`
MODIFY `groupefront_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_inscript`
--
ALTER TABLE `phantom_inscript`
MODIFY `inscript_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_langue`
--
ALTER TABLE `phantom_langue`
MODIFY `langue_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `phantom_lieu_compte`
--
ALTER TABLE `phantom_lieu_compte`
MODIFY `lieu_compte_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_list_images`
--
ALTER TABLE `phantom_list_images`
MODIFY `images_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_list_val`
--
ALTER TABLE `phantom_list_val`
MODIFY `val_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_log`
--
ALTER TABLE `phantom_log`
MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `phantom_module`
--
ALTER TABLE `phantom_module`
MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT pour la table `phantom_news`
--
ALTER TABLE `phantom_news`
MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `phantom_newsletter`
--
ALTER TABLE `phantom_newsletter`
MODIFY `newsletter_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_newsletterline`
--
ALTER TABLE `phantom_newsletterline`
MODIFY `newsletterline_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_options`
--
ALTER TABLE `phantom_options`
MODIFY `options_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `phantom_paysreference`
--
ALTER TABLE `phantom_paysreference`
MODIFY `paysreference_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_paysreferencelangue`
--
ALTER TABLE `phantom_paysreferencelangue`
MODIFY `paysreferencelangue_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_preference_compte`
--
ALTER TABLE `phantom_preference_compte`
MODIFY `preference_compte_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `phantom_rapport`
--
ALTER TABLE `phantom_rapport`
MODIFY `rapport_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `phantom_status`
--
ALTER TABLE `phantom_status`
MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_tag`
--
ALTER TABLE `phantom_tag`
MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_tag_search`
--
ALTER TABLE `phantom_tag_search`
MODIFY `tag_search_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_traduction`
--
ALTER TABLE `phantom_traduction`
MODIFY `traduction_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_typealarme_agence`
--
ALTER TABLE `phantom_typealarme_agence`
MODIFY `typealarme_agence_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `phantom_typereference`
--
ALTER TABLE `phantom_typereference`
MODIFY `typereference_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_typereferencelangue`
--
ALTER TABLE `phantom_typereferencelangue`
MODIFY `typereferencelangue_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_type_compte`
--
ALTER TABLE `phantom_type_compte`
MODIFY `type_compte_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `phantom_type_device`
--
ALTER TABLE `phantom_type_device`
MODIFY `type_device_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `phantom_type_lieu_compte`
--
ALTER TABLE `phantom_type_lieu_compte`
MODIFY `type_lieu_compte_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `phantom_type_moteur`
--
ALTER TABLE `phantom_type_moteur`
MODIFY `type_moteur_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `phantom_userfront`
--
ALTER TABLE `phantom_userfront`
MODIFY `userfront_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_userfrontcat`
--
ALTER TABLE `phantom_userfrontcat`
MODIFY `userfrontcat_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_usergps`
--
ALTER TABLE `phantom_usergps`
MODIFY `usergps_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `phantom_users`
--
ALTER TABLE `phantom_users`
MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `phantom_version`
--
ALTER TABLE `phantom_version`
MODIFY `version_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `positions`
--
ALTER TABLE `positions`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `user_settings`
--
ALTER TABLE `user_settings`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
