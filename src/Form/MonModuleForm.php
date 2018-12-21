<?php

namespace Drupal\mon_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class MonModuleForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'mon_module_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

        $form = parent::buildForm($form, $form_state);

        // $config : an editable configuration object as the given name is listed in the getEditableConfigNames()
        $config = $this->config('mon_module.settings');
        $form['page_text'] = array(
            '#type' => 'textarea',
            '#title' => $this->t('Contenu de la page Mon Module'),
            '#default_value' => $config->get('page_text'),
            '#description' => $this->t('Permet de définir le texte de la page Mon Module'),
        );

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {

    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {

        $config = $this->config('mon_module.settings');

        $config->set('page_text', $form_state->getValue('page_text'));

        $config->save();

        return parent::submitForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [
            'mon_module.settings',
        ];
    }

}