<?php

namespace App\Controllers;

use App\Models\RekenModel;

class RekenController extends BaseController
{
    protected $rekenModel;

    public function __construct()
    {
        $this->rekenModel = new RekenModel();
    }

    public function index()
    {
        // Toon de startpagina
        return view('Rekenapplicatie', ['step' => 'start']);
    }

    public function instellenMaxGetal()
    {
        // verwerkt de instelling van de max getal
        if ($this->request->getMethod() === 'post') {
            $maxGetal = $this->request->getPost('max_getal');
            // slaat het max getal op in sessie
            session()->set('max_getal', $maxGetal);
            return redirect()->to('/rekencontroller/kiesAantalSommen');
        } else {
            return view('Rekenapplicatie', ['step' => 'start']);
        }
    }

    public function kiesAantalSommen()
    {
        // Verwerk het formulier voor kiezen aantal sommen
        if ($this->request->getMethod() === 'post') {
            $aantalSommen = $this->request->getPost('aantal_sommen');
            // Slaat het aantal sommen op in sessie
            session()->set('aantal_sommen', $aantalSommen);
            return redirect()->to('/rekencontroller/kiesSoortSommen');
        } else {
            return view('Rekenapplicatie', ['step' => 'aantal']);
        }
    }

    public function kiesSoortSommen()
    {
        // Verwerk het formulier voor kiezen van som
        if ($this->request->getMethod() === 'post') {
            $soortSommen = $this->request->getPost('soort_sommen');
            // Sla het soort sommen op in de sessie
            session()->set('soort_sommen', $soortSommen);
            return redirect()->to('/rekencontroller/oefenSommen');
        } else {
            return view('Rekenapplicatie', ['step' => 'soort']);
        }
    }

    public function oefenSommen()
    {
        $maxGetal = session()->get('max_getal');
        $aantalSommen = session()->get('aantal_sommen');
        $soortSommen = session()->get('soort_sommen');

        // Genereer de sommen op basis van de gekozen catogorie dus -,+,x,/
        $sommen = $this->rekenModel->generateSommen($maxGetal, $aantalSommen, $soortSommen);

        if (!empty($sommen)) {
            // Sla de sommen op in de sessie
            session()->set('sommen', $sommen);

            // Toon de oefenpagina met de eerste som
            return redirect()->to('/rekencontroller/beantwoordSommen/0');
        } else {
            // behandeld waneer er een som niet kan worden berekent
            return "Geen sommen beschikbaar.";
        }
    }

    public function beantwoordSommen($index)
    {
        $sommen = session()->get('sommen');

        if (isset($sommen[$index])) {
            $som = $sommen[$index];
            return view('Rekenapplicatie', ['step' => 'oefen', 'sommen' => $sommen, 'som' => $som, 'index' => $index]);
        } else {
            // Behandel waneer de som niet bestaat
            return "Som niet gevonden.";
        }
    }

    public function controleerAntwoorden()
{
    // Verkrijg de gegeven antwoorden vanuit het formulier
    $gegevenAntwoorden = $this->request->getPost('antwoorden');

    // Haal de sommen en het soort sommen op uit de sessie
    $sommen = session()->get('sommen');
    $soortSommen = session()->get('soort_sommen');

    // Bepaal de juiste antwoorden op basis van het soort sommen
    $juisteAntwoorden = array();
    $aantalCorrecteAntwoorden = 0;

    foreach ($sommen as $index => $som) {
        $getal1 = $som['getal1'];
        $getal2 = $som['getal2'];
        $operator = $som['operator'];
        $juistAntwoord = '';

        switch ($operator) {
            case '+':
                $juistAntwoord = $getal1 + $getal2;
                break;
            case '-':
                $juistAntwoord = $getal1 - $getal2;
                break;
            case 'x': 
                $juistAntwoord = $getal1 * $getal2;
                break;
            case '/':
                $juistAntwoord = $getal1 / $getal2;
                break;
            default:
                break;
        }

        $juisteAntwoorden[] = $juistAntwoord;

        // Controleer of het gegeven antwoord overeenkomt met het juiste antwoord
        if (isset($gegevenAntwoorden[$index]) && $gegevenAntwoorden[$index] == $juistAntwoord) {
            $aantalCorrecteAntwoorden++;
        }
    }

    // Slaat de score op in de database
    $score = $aantalCorrecteAntwoorden;
    $total = count($juisteAntwoorden);
    $user_answer = $gegevenAntwoorden;

    $this->rekenModel->saveScore($score, $total, $user_answer);

    // Update de kolom "is_correct" op basis van de juiste antwoorden
    foreach ($sommen as $index => $som) {
        $sommen[$index]['is_correct'] = ($gegevenAntwoorden[$index] == $som['juiste_antwoord']) ? 1 : 0;
    }
 // Toon de view met de scores en de juiste antwoorden
    return view('Rekenapplicatie', [
        'step' => 'scores',
        'score' => $score,
        'total' => $total,
        'juisteAntwoorden' => $juisteAntwoorden,
        'sommen' => $sommen
    ]);
}

}
