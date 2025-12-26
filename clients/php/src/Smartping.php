<?php

declare(strict_types=1);

namespace SmartpingApi;

use SmartpingApi\Core\HttpClient;
use SmartpingApi\Core\HttpClientContract;
use SmartpingApi\Service\ActualitesService;
use SmartpingApi\Service\AuthentificationService;
use SmartpingApi\Service\ClubService;
use SmartpingApi\Service\EpreuveIndividuelleService;
use SmartpingApi\Service\EpreuveParEquipeService;
use SmartpingApi\Service\EpreuveService;
use SmartpingApi\Service\JoueurService;
use SmartpingApi\Service\OrganismeService;

final readonly class Smartping
{
    public ActualitesService $actualites;

    public AuthentificationService $authentification;

    public ClubService $club;

    public EpreuveIndividuelleService $epreuveIndividuelle;

    public EpreuveParEquipeService $epreuveParEquipe;

    public EpreuveService $epreuve;

    public JoueurService $joueur;

    public OrganismeService $organisme;

    private function __construct(private HttpClientContract $httpClient)
    {
        $this->actualites = new ActualitesService($this->httpClient);
        $this->authentification = new AuthentificationService($this->httpClient);
        $this->club = new ClubService($this->httpClient);
        $this->epreuveIndividuelle = new EpreuveIndividuelleService($this->httpClient);
        $this->epreuveParEquipe = new EpreuveParEquipeService($this->httpClient);
        $this->epreuve = new EpreuveService($this->httpClient);
        $this->joueur = new JoueurService($this->httpClient);
        $this->organisme = new OrganismeService($this->httpClient);
    }

    /**
     * Initialise la librairie avec les identifiants fournis par la FFTT.
     *
     * @param string $appId Identifiant unique fourni par la FFTT.
     * @param string $appKey Mot de passe unique fourni par la FFTT.
     * @param string $serial Chaîne de caractères identifiant l'utilisateur de façon permanente, doit respecter le format suivant : [A-Za-z0-9]{15}.
     */
    public static function create(string $appId, string $appKey, string $serial, ?HttpClientContract $httpClient = null): self
    {
        if (!$httpClient instanceof \SmartpingApi\Core\HttpClientContract) {
            $httpClient = new HttpClient($appId, $appKey, $serial);
        }

        return new self($httpClient);
    }
}
