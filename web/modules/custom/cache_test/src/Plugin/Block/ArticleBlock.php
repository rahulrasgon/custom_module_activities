<?php

namespace Drupal\cache_test\Plugin\Block;

use Drupal\Core\Block\BlockBase;


/**
 * Provides a 'Article' Block.
 *
 * @Block(
 *   id = "article_block",
 *   admin_label = @Translation("Article block"),
 *   category = @Translation("custom"),
 * )
 */
class ArticleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $query = \Drupal::entityQuery('node')
          ->sort('created', 'DESC')
          ->range(0,3);

    $nids = $query->execute();
    $nodes = entity_load_multiple('node', $nids);
    $results[]="";
    $i=0;
    foreach($nodes as $key => $node)
    {
    $results[$i]['title']=$node->getTitle();
    $results[$i]['nid']=$key;
      $i++;
  }
  $email =\Drupal::currentUser()->getEmail();
    return array(
      '#markup' => $results[0]['title'] . "<br />" . $results[1]['title'] . "<br />" . $results[2]['title'] . "<br />" . $email,
      '#cache' => [
      'tags' => [
        'node:' . $results[0]['nid'], 'node:' . $results[1]['nid'], 'node:' . $results[2]['nid'],
      ],
      'contexts'=>['user'],
      ],
    );
  }

}

