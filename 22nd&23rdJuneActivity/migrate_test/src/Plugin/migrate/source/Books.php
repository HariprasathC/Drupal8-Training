<?php

namespace Drupal\migrate_test\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Source plugin for the books.
 *
 * @MigrateSource(
 *   id = "books"
 * )
 */
class Books extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('books', 'g')
      ->fields('g', ['id', 'chapter_id', 'name']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('Books ID'),
      'chapter_id' => $this->t('Chapter ID'),
      'name' => $this->t('Books name'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'id' => [
        'type' => 'integer',
        'alias' => 'g',
      ],
    ];
  }
}