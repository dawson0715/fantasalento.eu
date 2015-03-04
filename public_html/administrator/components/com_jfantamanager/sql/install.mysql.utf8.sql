-- $Id: install.mysql.utf8.sql 24 2009-11-09 11:56:31Z chdemko $

CREATE TABLE IF NOT EXISTS `#__fanta_calendario` (
  `giornata` tinyint(4) NOT NULL,
  `data` date NOT NULL,
  `ora` time NOT NULL,
  `giocata` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`giornata`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `#__fanta_giocatore`
--

CREATE TABLE IF NOT EXISTS `#__fanta_giocatore` (
  `id` int(11) NOT NULL DEFAULT '0',
  `pos` char(1) NOT NULL,
  `nome` char(25) NOT NULL,
  `valore_ini` smallint(6) NOT NULL DEFAULT '0',
  `squadra` char(10) NOT NULL,
  `valore_att` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `#__fanta_impiega`
--

CREATE TABLE IF NOT EXISTS `#__fanta_impiega` (
  `squadra_id` int(11) NOT NULL DEFAULT '0',
  `giocatore_id` int(11) NOT NULL DEFAULT '0',
  `giornata` int(11) NOT NULL DEFAULT '0',
  `riserva` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`squadra_id`,`giocatore_id`,`giornata`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `#__fanta_lega`
--

CREATE TABLE IF NOT EXISTS `#__fanta_lega` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `scontri_diretti` varchar(1) NOT NULL,
  `partecipanti` int(11) NOT NULL,
  `giornate` mediumint(9) NOT NULL,
  `ritardo` mediumint(9) NOT NULL,
  `crediti` mediumint(9) NOT NULL,
  `modificatore` varchar(1) NOT NULL,
  `p_fissa` varchar(1) NOT NULL,
  `sostituzioni` mediumint(9) NOT NULL,
  `ruolo` varchar(1) NOT NULL,
  `cambi` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `#__fanta_possiede`
--

CREATE TABLE IF NOT EXISTS `#__fanta_possiede` (
  `squadra_id` int(11) NOT NULL DEFAULT '0',
  `giocatore_id` int(11) NOT NULL DEFAULT '0',
  `data_acq` date NOT NULL DEFAULT '0000-00-00',
  `data_ces` date NOT NULL DEFAULT '0000-00-00',
  `valore_acq` int(11) NOT NULL DEFAULT '0',
  `valore_ces` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`squadra_id`,`giocatore_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `#__fanta_squadra`
--

CREATE TABLE IF NOT EXISTS `#__fanta_squadra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(25) NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0' COMMENT 'chiave esterna user proprietario della squadra',
  `logo` text NOT NULL COMMENT 'immagine squadra',
  `cambi` mediumint(9) NOT NULL DEFAULT '25',
  `pagato` int(11) NOT NULL,
  `bilancio` mediumint(9) NOT NULL DEFAULT '0',
  `permesso` varchar(1) NOT NULL DEFAULT '0',
  `lega` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `#__fanta_voti`
--

CREATE TABLE IF NOT EXISTS `#__fanta_voti` (
  `giocatore_id` int(11) NOT NULL,
  `giornata` tinyint(4) NOT NULL,
  `presente` tinyint(1) NOT NULL,
  `politico` varchar(1) NOT NULL DEFAULT '0',
  `voto` decimal(10,1) NOT NULL,
  `goal` tinyint(4) NOT NULL,
  `ammonizione` tinyint(4) NOT NULL,
  `espulsione` tinyint(4) NOT NULL,
  `assist` tinyint(4) NOT NULL,
  `totale` decimal(10,1) NOT NULL,
  `goal_subito` tinyint(4) NOT NULL,
  `rigore_parato` tinyint(4) NOT NULL,
  `rigore_sbagliato` tinyint(4) NOT NULL,
  `rigore_segnato` tinyint(4) NOT NULL,
  `autorete` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `#__fanta_voti_squadra`
--

CREATE TABLE IF NOT EXISTS `#__fanta_voti_squadra` (
  `giornata` tinyint(4) NOT NULL,
  `squadra_id` int(11) NOT NULL,
  `punti` decimal(10,1) NOT NULL,
  `posizione` varchar(11) NOT NULL DEFAULT '0',
  `data` date NOT NULL,
  `ora` time NOT NULL,
  `modulo` tinyint(4) NOT NULL,
  PRIMARY KEY (`giornata`,`squadra_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;