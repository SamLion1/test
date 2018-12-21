<?php

namespace Drupal\mon_module\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the UpkeepRobot entity
 *
 * handler : permet d'afficher l'entité
 * links : indique les chemins qui correspondent aux actions de CRUD
 * pour que les onglets Voir, Editer et Supprimer apparaissent sur la page d'entité => mon_module.links.task.yml
 *
 * @ingroup upkeep_robot
 *
 * @ContentEntityType(
 *   id = "upkeep_robot",
 *   label = @Translation("UpKeepRobot"),
 *   base_table = "upkeep_robot",
 *   entity_keys = {
 *    "id" = "id",
 *    "label" = "nickname",
 *    "uuid" = "uuid",
 *   },
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "access" = "Drupal\mon_module\UpKeepRobotAccessControlHandler",
 *   },
 *   links = {
 *      "canonical" = "/see_robot/{upkeep_robot}"
 *   },
 * )
 */
class UpKeepRobot extends ContentEntityBase implements ContentEntityInterface
{
    public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
    {
        $fields['id'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('ID'))
            ->setDescription('The ID of the UpkeepRobot entity.')
            ->setReadOnly(true)
        ;

        $fields['nickname'] = BaseFieldDefinition::create('string')
            ->setLabel(t("The robot's name"))
            ->setDescription(t('The nickname of the robot.'))
            ->setRequired(true)
            ->setSettings(array(
                'default_value' => '',
                'max_length' => 255,
                'text_processing' => 0,
            ))
        ;

        $fields['uuid'] = BaseFieldDefinition::create('uuid')
            ->setLabel(t('UUID'))
            ->setDescription(t('The UUID of the UpKeepRobot entity.'))
            ->setReadOnly(true)
        ;

        $fields['years_of_service'] = BaseFieldDefinition::create('integer')
            ->setLabel("The robot's years of service")
            ->setDescription('The years of service of the robot.')
            ->addPropertyConstraints('value',[
                'Range' => [
                    'min' => 0,
                    'max' => 25,
                ]
            ]);

        return $fields;
    }

    /**
     * @return int
     */
    public function getYearsOfService()
    {
        return $this->get('years_of_service')->value;
    }

    /**
     * @param int $yearsOfService
     * @return $this
     */
    public function setYearsOfService($yearsOfService)
    {
        $this->get('years_of_service')->value = $yearsOfService;
        return $this;
    }
}