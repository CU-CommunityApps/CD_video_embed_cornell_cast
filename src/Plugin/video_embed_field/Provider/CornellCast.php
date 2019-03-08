<?php

/**
 * @file
 * Contains \Drupal\video_embed_cornell_cast\Plugin\video_embed_field\Provider\CornellCast.
 */

namespace Drupal\video_embed_cornell_cast\Plugin\video_embed_field\Provider;

use Drupal\video_embed_field\ProviderPluginBase;

/**
 * @VideoEmbedProvider(
 *   id = "cornell_cast",
 *   title = @Translation("CornellCast")
 * )
 */
class CornellCast extends ProviderPluginBase {

  /**
   * {@inheritdoc}
   */
  public function renderEmbedCode($width, $height, $autoplay) {
    return [
      '#type' => 'html_tag',
      '#tag' => 'iframe',
      '#attributes' => [
        'width' => $width,
        'height' => $height,
        'style' => 'border: 0',
        'title' => 'CornellCast video',
        'allowfullscreen' => 'allowfullscreen',
        'src' => sprintf('https://www.cornell.edu/video/%s/embed', $this->getVideoId(), $autoplay),
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getRemoteThumbnailUrl() {
    $json_url = 'https://www.cornell.edu/video/getJSON.cfm?cleanURL='. $this->getVideoId();
    $json_data = json_decode(file_get_contents($json_url));
    $poster_url = $json_data->poster;
    return $poster_url;
  }

  /**
   * {@inheritdoc}
   */
  public static function getIdFromInput($input) {
    preg_match('/^https?:\/\/(www\.)?cornell.edu\/video\/(?<clean_id>[\w-]*)\/?$/', $input, $matches);

    return isset($matches['clean_id']) ? $matches['clean_id'] : FALSE;
  }

}
