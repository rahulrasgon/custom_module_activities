<?php

namespace Drupal\google_book\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use AntoineAugusti\Books\Fetcher;
use GuzzleHttp\Client;


/**
 * Provides a 'Custom' Block.
 *
 * @Block(
 *   id = "book_block",
 *   admin_label = @Translation("Book block"),
 *   category = @Translation("custom"),
 * )
 */
class ExtractGoogleBook extends BlockBase {

    protected $fetcher;
    protected $client;

  public function build() {
      $this->client = new Client(['base_uri' => 'https://www.googleapis.com/books/v1/']);
      $this->fetcher = new Fetcher($this->client);
      $config = $this->getConfiguration();
      // kint(config['book_block_name']);
      $book = $this->fetcher->forISBN($config['book_block_name']);
      //  $check=$book->publishedDate->getTimestamp();
        // kint($book);
       // kint($book->publishedDate->format('d M Y'));
      // exit();
        return [
        '#type' => 'inline_template',
        '#template' => "<p style='text-align:center'><img src='{{thumbnail}}' / ></p><p>{% trans %} Title : {% endtrans %} <strong>{{title}}</strong><p>
        <p>{% trans %} Author : {% endtrans %} <strong>{{authors}}</strong><p>
        <p>{% trans %} Published date : {% endtrans %} <strong>{{publishedDate}}</strong><p>
        <p>{% trans %} Page Count : {% endtrans %} <strong>{{pageCount}}</strong><p>
        <p>{% trans %} Publisher : {% endtrans %} <strong>{{publisher}}</strong><p>
        <p>{% trans %} Rating : {% endtrans %} <strong>{{averageRating}}</strong><p>",
        '#context' => [
            'title' => $book->title,
            'authors' => $book->authors[0],
            'publishedDate' => $book->publishedDate->format('d M Y'),
            'pageCount' => $book->pageCount,
            'publisher' => $book->publisher,
            'averageRating' =>$book->averageRating,
            'thumbnail' => $book->thumbnail,
         ],
      ];
    }

  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['book_block_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('ISBN'),
      '#description' => $this->t('Enter the isbn number !'),
      '#default_value' => isset($config['book_block_name']) ? $config['book_block_name'] : '',
    );

    return $form;
  }

 public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['book_block_name'] = $values['book_block_name'];
  }
}
