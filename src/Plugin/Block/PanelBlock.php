<?php

namespace Drupal\mon_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "panel_block",
 *   admin_label = @Translation("Panneau indicateur"),
 * )
 */
class PanelBlock extends BlockBase implements BlockPluginInterface {

    /**
     * {@inheritdoc}
     */
    public function build() {

        $config = $this->getConfiguration();

        $kiwiOffer = (isset($config['kiwi_offer']) AND !empty($config['kiwi_offer'])) ? $config['kiwi_offer'] : '';

        return array(
            // avec la clé markup
          //  '#markup' => $this->t('Bienvenue, noble visiteur !');
            // ou bien
          '#theme' => 'panel_bloc',
          '#content' => array('text' => t('Bienvenue noble visiteur'), 'offer' => $kiwiOffer),
        );
    }

    /**
     * Définition du formulaire de configuration de notre bloc (pour ajouter le champs de réduction de kiwi
     * Il sera affiché sur la page de config en cliquant sur le bouton configurer de la page de config des régions
     *
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $form = parent::blockForm($form, $form_state);

        $config = $this->getConfiguration();

        // 'panel_block_kiwi_offer' nom technique du champs
        $form['panel_block_kiwi_offer'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Réduction sur le kiwi'),
            '#description' => $this->t("Renseignez ici l'offre commerciale"),
            '#default_value' => isset($config['kiwi_offer']) ? $config['kiwi_offer'] : '',
            '#required' => true,
        );

        return $form;
    }

    /**
     * Sauvegarde de la configuration du formulaire Sans vérification (dans blocVlidate()).
     * Si le bloc est placé a différentes régions => Chaque bloc a sa propre configuration
     *
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        $this->configuration['kiwi_offer'] = $form_state->getValue('panel_block_kiwi_offer');
    }

    /**
     * {@inheritdoc}
     */
    public function blockValidate($form, FormStateInterface $form_state) {
        $silicium_offer = $form_state->getValue('panel_block_kiwi_offer');

        if ( strlen($silicium_offer) < 10 ) {
            $form_state->setErrorByName('panel_block_kiwi_offer', t("L'offre semble trop courte pour être honnête !"));
        }

    }



}