<?php

    // No direct access
    defined('_JEXEC') or die('Restricted access');
    //recupero parametri
    $params = &JComponentHelper::getParams( 'fantacalcio' );
    $params->merge( new JParameter( $this->lista_params ) );
?>
<h1>
    <?php
        echo "Modificatore difesa:" . $params->get( 'modifica' );
        echo "<br>";
        echo "Panchina libera:" . $params->get( 'panca' );
    ?>
</h1>
