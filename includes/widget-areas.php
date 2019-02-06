<?php
/**
 * Registrar widget areas
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */
genesis_register_sidebar( array(
    'id' => 'bienvenida',
    'name' => __('Bienvenidos al HOME', 'retinalatina' ),
    'description' => __( 'Zona de bienvenida', 'retinalatina')
));
genesis_register_sidebar( array(
    'id' => 'call-to-action',
    'name' => __('Llamado a la acción', 'retinalatina' ),
    'description' => __( 'Un llamado a las acciones', 'retinalatina')
));