<?php

namespace Drupal\mon_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\mon_module\Entity\UpKeepRobot;
use Drupal\node\Entity\Node;

class MonModuleController extends ControllerBase
{
    public function displayMonModulePage()
    {
        $this->createArticle();

        $robot1 = UpKeepRobot::create(array(
            'nickname' => 'humanoid',
            'years_of_service' => 3,
        ));

        $robot1->save();

        $robot2 = UpKeepRobot::create(array(
            'nickname' => 'alien',
            'years_of_service' => 5,
        ));

        $robot2->save();

        $storage = \Drupal::entityTypeManager()->getStorage('upkeep_robot');

        $ids = $storage->getQuery()
            ->condition('nickname', 'humanoid')
            ->execute();
        $upKeepRobots = $storage->loadMultiple($ids);

        foreach ($upKeepRobots as $upKeepRobot) {
            $upKeepRobot->delete();
        }

        $config = $this->config('mon_module.settings');

        return array(
            '#theme' => 'panel_page',
            '#content' => array('text' => $config->get('page_text')),
            //'#content' => array('text' => $this->t('Hello, Galaxy!!!'), 'source' => 'www.google.com') ,
        );
    }

    /**
     * @throws \Drupal\Core\Entity\EntityStorageException
     */
    private function createArticle()
    {
        $articleBody = 'Le kiwi. Il s’agit d’un petit fruit, connu pour sa couleur marron et ses petits poils extérieurs. Ainsi que pour la belle couleur verte de sa chair.
Il est originaire d’une vallée située en Chine. Puis, il fut importé en Nouvelle-Zélande, pays actuellement à l’origine de la majeure partie de la production mondiale. La vitamine C est un puissant antioxydant, dont la capacité à neutraliser les radicaux libres fait du kiwi un aliment luttant contre les dommages corporels de toute nature, surtout ceux liés au vieillissement.
Manger ce fruit permet de maintenir ses cellules plus jeunes, et de conserver son corps en excellente santé.';

        $article = Node::create(array(
            'type' => 'article',
            'title' => 'Article créé pour tester les entités',
            'langcode' => 'fr',
            'uid' => '1',
            'status' => 1,
            'body' => $articleBody,
        ));

        $article->save();
    }
}