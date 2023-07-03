<?php
namespace App\Models;

use CodeIgniter\Model;

class RekenModel extends Model
{
    protected $table = 'exercises'; 
    protected $allowedFields = ['score', 'total', 'user_answer'];


    public function generateSommen($maxGetal, $aantalSommen, $soortSommen)
    {
        $sommen = [];
    
        for ($i = 0; $i < $aantalSommen; $i++) {
            $getal1 = mt_rand(1, $maxGetal);
            $getal2 = mt_rand(1, $maxGetal);
    
            switch ($soortSommen) {
                case 'plussommen':
                    $operator = '+';// operator word gebruikt bij cijfers en values en als je + kiest word het een plus
                    $juisteAntwoord = $getal1 + $getal2;
                    break;
                case 'minsommen':
                    $operator = '-';
                    $juisteAntwoord = $getal1 - $getal2;
                    break;
                case 'keersommen':
                    $operator = 'x';
                    $juisteAntwoord = $getal1 * $getal2;
                    break;
                case 'deelsommen':
                    $operator = '/';
                    // Controleer of de deling een geheel getal oplevert
                    $juisteAntwoord = ($getal2 != 0 && $getal1 % $getal2 == 0) ? $getal1 / $getal2 : null;
                    break;
                default:
                    // Ongeldig soort som, stop de generatie van sommen
                    return [];
            }
    
            if ($juisteAntwoord !== null) {
                $som = [
                    'getal1' => $getal1,
                    'getal2' => $getal2,
                    'operator' => $operator,
                    'juiste_antwoord' => $juisteAntwoord
                ];
    
                $sommen[] = $som;
            }
        }
    
        return $sommen;
    }
    
    // De functie "generateSommen" genereert een array van sommen op basis van de opgegeven cijfers dus max getal. 
    // Het maximaal getal, het aantal sommen en het soort sommen worden gebruikt om willekeurige sommen te genereren.
    // De gegenereerde sommen worden in een array opgeslagen en geretourneerd.
    

    public function controleerAntwoord($antwoord, $som)
    {
        // dit controlleerd of de antwoord overeen komt met de gegeven antwoord
    
        return $antwoord == $som['juiste_antwoord'];
    }
    
    // De functie "controleerAntwoord" controleert het gegeven antwoord tegen het juiste antwoord van een som.
    // Het gegeven antwoord en de som worden als variable doorgegeven.
    // De functie retourneert een boolean-waarde (true als het antwoord juist is, anders false).
    public function saveScore($score, $total, $user_answer)
    {
        $data = [
            'score' => $score,
            'total' => $total,
            'user_answer' => $user_answer[0], // Hier wordt de gegeven santwoord opgeslagen

        ];

        $this->insert($data);
    }

    
}
