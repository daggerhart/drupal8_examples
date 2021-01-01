<?php

namespace Drupal\simple;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Class SimpleTypeListBuilder
 */
class SimpleListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(){
    $header['id'] = $this->t('Linked Entity Id');
    $header['content_entity_label'] = $this->t('Content Entity Label');
    $header['content_entity_id'] = $this->t('Content Entity Id');
    $header['bundle_label'] = $this->t('Config Entity (Bundle) Label');
    $header['bundle_id'] = $this->t('Config Entity (Bundle) Id');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['id'] = $entity->toLink($entity->id());
    $row['content_entity_label'] = $entity->getEntityType()->getLabel()->render();
    $row['content_entity_id'] = $entity->getEntityType()->id();
    $row['bundle_label'] = $entity->bundle->entity->label();
    $row['bundle_id'] = $entity->bundle();

    return $row + parent::buildRow($entity);
  }
}
