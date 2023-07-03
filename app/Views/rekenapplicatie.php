<!DOCTYPE html>
<html>
<head>
    <title>Rekenapplicatie - Antwoorden</title>
</head>
<body>
    <?php if ($step === 'start'): ?>
        <h1>Welkom bij mijn Rekenapplicatie</h1>
        <p>Kies een maximaal getal om mee te oefenen:</p>
        <!-- hier laat die de dingen zien waar je de max getal kan invoegen -->
        <form method="post" action="<?php echo base_url('rekencontroller/instellenMaxGetal'); ?>">
            <input type="number" name="max_getal" required>
            <input type="submit" value="Volgende">
        </form>
    <?php elseif ($step === 'aantal'): ?>
        <h1>Rekenapplicatie - Kiez de aantal sommen die je wilt</h1>
        <p>Kies het aantal sommen waarmee je wilt oefenen:</p>
        <!-- hier laat die de dingen zien waar je de max aantal sommen kan invoegen -->
        <form method="post" action="<?php echo base_url('rekencontroller/kiesAantalSommen'); ?>">
            <input type="number" name="aantal_sommen" required>
            <input type="submit" value="Volgende">
        </form>
    <?php elseif ($step === 'soort'): ?>
        <h1>Rekenapplicatie - Kiez met wat voor sommen je wilt oefenen:P</h1>
        <p>Kies het soort sommen dat je wilt oefenen:</p>
        <!-- hier kan je kiezen wat voor som/sommen je wilt -->
        <form method="post" action="<?php echo base_url('rekencontroller/kiesSoortSommen'); ?>">
            <input type="radio" name="soort_sommen" value="plussommen" required> Plussommen<br>
            <input type="radio" name="soort_sommen" value="minsommen"> Minsommen<br>
            <input type="radio" name="soort_sommen" value="keersommen"> Keersommen<br>
            <input type="radio" name="soort_sommen" value="deelsommen"> Deelsommen<br>
            <input type="submit" value="Volgende">
        </form>
    <?php elseif ($step === 'oefen'): ?>
        <h1>Rekenapplicatie - Oefenen</h1>
        <!-- dit laat de sommen zien die je moet oplossem -->
        <?php foreach ($sommen as $index => $som): ?>
            <p>
                <?php echo $som['getal1'] . ' ' . $som['operator'] . ' ' . $som['getal2']; ?>
                = ______
            </p>
        <?php endforeach; ?>
        <!-- dit is de veld waar de gebruiker kan antwoord geven  -->
        <form method="post" action="<?php echo base_url('rekencontroller/controleerAntwoorden'); ?>">
            <?php foreach ($sommen as $index => $som): ?>
                <input type="number" name="antwoorden[<?php echo $index; ?>]" required>
            <?php endforeach; ?>
            <input type="submit" value="Antwoorden controleren">
        </form>

        <!-- hier zie je als je antwoord heb gegeven de scoren en de juisten antwoorden -->
    <?php elseif ($step === 'scores'): ?>
        <h1>Rekenapplicatie - Scores</h1>
        <p>Je score is: <?php echo $score; ?> van <?php echo $total; ?></p>

        <h2>Juiste antwoorden:</h2>
        <?php foreach ($sommen as $index => $som): ?>
            <p>
                <?php echo $som['getal1'] . ' ' . $som['operator'] . ' ' . $som['getal2']; ?>
                = <?php echo $juisteAntwoorden[$index]; ?>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
