-- Structure de la table `agend`
--

CREATE TABLE IF NOT EXISTS `agend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date default NULL,
  `liaison` int(11) NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `agend`
--

-- --------------------------------------------------------

--
-- Structure de la table `agendsujet`
--

CREATE TABLE IF NOT EXISTS `agendsujet` (
  `topicid` int(3) NOT NULL AUTO_INCREMENT,
  `topicimage` varchar(20) collate utf8_unicode_ci default NULL,
  `topictext` mediumtext collate utf8_unicode_ci,
  PRIMARY KEY  (`topicid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `agendsujet`
--

-- --------------------------------------------------------

--
-- Structure de la table `agend_dem`
--

CREATE TABLE IF NOT EXISTS `agend_dem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` mediumtext collate utf8_unicode_ci NOT NULL,
  `intro` longtext collate utf8_unicode_ci NOT NULL,
  `descript` longtext collate utf8_unicode_ci NOT NULL,
  `lieu` varchar(100) collate utf8_unicode_ci NOT NULL,
  `topicid` int(11) NOT NULL,
  `posteur` varchar(100) collate utf8_unicode_ci NOT NULL,
  `groupvoir` int(3) NOT NULL,
  `valid` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `agend_dem`
--