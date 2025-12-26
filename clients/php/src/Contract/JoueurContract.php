<?php

declare(strict_types=1);

namespace SmartpingApi\Contract;

use SmartpingApi\Model\Joueur\DetailJoueur;
use SmartpingApi\Model\Joueur\DetailJoueurBaseClassement;
use SmartpingApi\Model\Joueur\DetailJoueurBaseSPID;
use SmartpingApi\Model\Joueur\HistoriqueClassement;
use SmartpingApi\Model\Joueur\JoueurBaseClassement;
use SmartpingApi\Model\Joueur\JoueurBaseSPID;
use SmartpingApi\Model\Partie\Partie;
use SmartpingApi\Model\Partie\PartieBaseClassement;
use SmartpingApi\Model\Partie\PartieBaseSPID;

interface JoueurContract
{
    /**
     * Endpoint : xml_liste_joueur.php
     * ---------------------------------------------------------
     * Cherche un ou plusieurs joueur(s) par leur
     * nom (et prénom éventuellement) sur la base classement.
     *
     * @return array<array-key, JoueurBaseClassement> Ensemble des joueurs trouvés
     */
    public function joueursParNomSurBaseClassement(string $nom, ?string $prenom = null): array;

    /**
     * Endpoint : xml_liste_joueur_o.php
     * ---------------------------------------------------------
     * Cherche un ou plusieurs joueur(s) par leur
     * nom (et prénom éventuellement) sur la base SPID.
     *
     * @param bool $valide Filtrer uniquement sur les licences
     *                    de la saison en cours
     *
     * @return array<array-key, JoueurBaseSPID> Ensemble des joueurs trouvés
     */
    public function joueursParNomSurBaseSPID(string $nom, ?string $prenom = null, bool $valide = false): array;

    /**
     * Endpoint : xml_liste_joueur_o.php
     * ---------------------------------------------------------
     * Cherche un ou plusieurs joueur(s) par leur
     * nom (et prénom éventuellement).
     *
     * @param bool $valide Filtrer uniquement sur les licences
     *                    de la saison en cours
     *
     * @return array<array-key, JoueurBaseSPID[]> Ensemble des joueurs trouvés
     */
    public function joueursParNom(string $nom, ?string $prenom = null, bool $valide = false): array;

    /**
     * Endpoint : xml_liste_joueur.php
     * ---------------------------------------------------------
     * Cherche un ou plusieurs joueur(s) par leur numéro de club
     * sur la base classement.
     *
     * @return array<array-key, JoueurBaseClassement> Ensemble des joueurs trouvés
     */
    public function joueursParClubSurBaseClassement(string $numeroClub): array;

    /**
     * Endpoint : xml_liste_joueur_o.php
     * ---------------------------------------------------------
     * Cherche un ou plusieurs joueur(s) par leur numéro de club
     * sur la base SPID.
     *
     * @param bool $valide Filtrer uniquement sur les licences
     *                    de la saison en cours
     *
     * @return array<array-key, JoueurBaseSPID> Ensemble des joueurs trouvés
     */
    public function joueursParClubSurBaseSPID(string $numeroClub, bool $valide = false): array;

    /**
     * Endpoint : xml_licence_b.php
     * ---------------------------------------------------------
     * Cherche un ou plusieurs joueur(s) par leur numéro de club.
     *
     * @return array<array-key, DetailJoueur[]> Ensemble des joueurs trouvés
     */
    public function joueursParClub(string $numeroClub): array;

    /**
     * Endpoint : xml_joueur.php
     * ---------------------------------------------------------
     * Cherche un joueur par son numéro de licence sur la base classement.
     *
     * @return ?DetailJoueurBaseClassement Joueur trouvé (si existant)
     */
    public function joueurParLicenceSurBaseClassement(string $licence): ?DetailJoueurBaseClassement;

    /**
     * Endpoint : xml_licence.php
     * ---------------------------------------------------------
     * Cherche un joueur par son numéro de licence sur la base SPID.
     *
     * @return ?DetailJoueurBaseSPID Joueur trouvé (si existant)
     */
    public function joueurParLicenceSurBaseSPID(string $licence): ?DetailJoueurBaseSPID;

    /**
     * Endpoint : xml_licence_b.php
     * ---------------------------------------------------------
     * Cherche un joueur par son numéro de licence sur les bases
     * SPID et classement.
     *
     * @return ?DetailJoueur Joueur trouvé (si existant)
     */
    public function joueurParLicence(string $licence): ?DetailJoueur;

    /**
     * Endpoint : xml_partie_mysql.php
     * ---------------------------------------------------------
     * Renvoie la liste des parties de la base classement
     * d’un joueur.
     *
     * @return array<array-key, PartieBaseClassement> Ensemble des parties trouvées
     */
    public function historiquePartiesBaseClassement(string $licence): array;

    /**
     * Endpoint : xml_partie.php
     * ---------------------------------------------------------
     * Renvoie la liste des parties de la base SPID
     * d’un joueur.
     *
     * @return array<array-key, PartieBaseSPID> Ensemble des parties trouvées
     */
    public function historiquePartiesBaseSPID(string $licence): array;

    /**
     * Endpoint : xml_partie.php
     * ---------------------------------------------------------
     * Renvoie une liste des parties d’un joueur.
     *
     * @return array<array-key, Partie[]> Ensemble des parties trouvées
     */
    public function historiqueParties(string $licence): array;

    /**
     * Endpoint : xml_histo_classement.php
     * ---------------------------------------------------------
     * Renvoie une liste des parties d’un joueur.
     *
     * @return array<array-key, HistoriqueClassement> Ensemble des parties trouvées
     */
    public function historiqueClassementOfficiel(string $licence): array;

    /**
     * Renvoie une liste des parties validées d’un joueur.
     *
     * @return array<array-key, Partie> Ensemble des parties trouvées
     */
    public function partiesValidees(string $licence): array;

    /**
     * Renvoie une liste des parties non-validées d’un joueur.
     *
     * @return array<array-key, Partie> Ensemble des parties trouvées
     */
    public function partiesNonValidees(string $licence): array;

    /**
     * Renvoie le nombre de points virtuels d’un joueur (estimation).
     *
     * @return float Nombre de points virtuels
     */
    public function pointsVirtuels(string $licence): float;

    /**
     * Renvoie le nombre de points virtuels d’un joueur (estimation) sur une période donnée.
     *
     * @param string $debut Date de début de la période (jj/mm/aaaa)
     * @param string $fin Date de fin de la période (jj/mm/aaaa)
     *
     * @return float Nombre de points virtuels
     */
    public function pointsVirtuelsSurPeriode(string $licence, string $debut, string $fin): float;
}
