<?php
namespace Drupal\migrate_test\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for the chapters.
 *
 * @MigrateSource(
 *   id = "chapters"
 * )
 */
class Chapters extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('chapters', 'd')
      ->fields('d', ['id', 'name', 'description']);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('Chapter ID'),
      'name' => $this->t('Chapter Name'),
      'description' => $this->t('Chapter Description'),
      'books' => $this->t('Chapter on Books'),
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
        'alias' => 'd',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $books = $this->select('Books', 'g')
      ->fields('g', ['id'])
      ->condition('chapter_id', $row->getSourceProperty('id'))
      ->execute()
      ->fetchCol();
    $row->setSourceProperty('books', $books);
    return parent::prepareRow($row);
  }
}